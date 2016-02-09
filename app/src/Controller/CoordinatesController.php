<?php
namespace App\Controller;

use App\Model\Entity\Item;
use App\Model\Table\CoordinatesItemsTable;
use App\Model\Table\ItemsTable;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Coordinates Controller
 *
 * @property \App\Model\Table\CoordinatesTable $Coordinates
 */
class CoordinatesController extends AppController
{
    const N_ITEM_LIST_SHOW = 500;
    const SESSION_KEY = 'items';
    const BUTTON_SIZE = 34;
    const BUTTON_NUMBER_IN_ROW = 4;

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(
            ['view']
        );
    }

    /**
     * View method
     *
     * @param string|null $id Coordinate id.
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        //2回目以上の訪問かをチェックし， SESSION 情報を更新する
        $this->updateHasVisitedFlag();

        $coordinate = $this->Coordinates->get($id, [
                'contain' => ['Users', 'Items', 'Favorites']
            ]
        );

        $total_price = 0;
        foreach ($coordinate->items as $item) {
            $total_price += $item->price;
        }

        foreach ($coordinate->items as $item) {
            $item->buttons_height = self::BUTTON_SIZE * (floor(count($item->size_array) / self::BUTTON_NUMBER_IN_ROW) + 1);
            $item->size_label = 'size' . $item->id;
            $item->options = [];
            foreach ($item->size_array as $size) {
                if ($size === $item->size_array[0]) {
                    $item->options[] = ['value' => $size, 'text' => $size, 'checked' => true];
                } else {
                    $item->options[] = ['value' => $size, 'text' => $size];
                }
            }
        }

        $access_user_id = $this->request->session()->read('Auth.User.id');
        $isRegistered = false;
        $coordinate->favorite_disabled = true;
        foreach ($coordinate->favorites as $favorite) {
            if ($favorite->user_id === $access_user_id) {
                $isRegistered = true;
                break;
            }
        }
        $coordinate->favorite_disabled = $isRegistered ||
            is_null($access_user_id);

        $caller = filter_input(
            INPUT_POST, 'caller', FILTER_SANITIZE_STRING
        );
        $visited = $this->request->session()->read('Visited.coordinates_view');
        if($caller === 'modal' && !($visited)) {
            $this->request->session()->delete('Visited.coordinates_view');
        }

        $this->set('coordinate', $coordinate);
        $this->set('_serialize', ['coordinate']);
        $this->set('total_price', $total_price);
    }

    /**
     * コーディネート投稿画面を表示するための情報を取得する
     * 投稿画面ではコーディネートに利用するアイテムを一覧で表示，条件で絞込表示をする
     *
     * @return \Cake\Network\Response|void
     */
    public function create()
    {
        //2回目以上の訪問かをチェックし， SESSION 情報を更新する
        $this->updateHasVisitedFlag();

        $coordinate = $this->Coordinates->newEntity();
        if ($this->request->is('post')) {
            $coordinate = $this->Coordinates->patchEntity($coordinate, $this->request->data);
            if ($this->Coordinates->save($coordinate)) {
                return $this->redirect(['action' => 'index']);
            }
        }

        $criteria = self::validateCriteria($this->request->data);
        $items = $this->findItemList($criteria);

        $this->set('items', $items->toArray());
        $this->set('sex_list', Item::getSexes());
        $this->set('category_list', Item::getCategories());
        $this->set('color_list', Item::getColors());
        $this->set('criteria', $criteria);
    }

    /**
     * コーディネートを作成し投稿を行う
     *
     * @return \Cake\Network\Response|void
     */
    public function post()
    {
        //2回目以上の訪問かをチェックし， SESSION 情報を更新する
        $this->updateHasVisitedFlag();

        $this->set('sex_list', Item::getSexes());
    }


    /**
     * @param string $string_img
     * @param array $items
     * @param int $sex
     * @param string $season
     * @return int
     * @throws \Exception
     */
    protected function postCoordinate($string_img, array $items, $sex, $season)
    {
        /** @var CoordinatesItemsTable $coordinates_items_repository */
        $coordinates_items_repository = TableRegistry::get('CoordinatesItems');

        $now = new \DateTime();

        /** @var /App/Model/Entity/Coordinate $coordinate */
        $coordinate = $this->Coordinates->newEntity();

        $coordinate->user_id = $this->Auth->user('id');
        $coordinate->n_like = 0;
        $coordinate->n_unlike = 0;
        $coordinate->sex = $sex === "1";
        $coordinate->season = $season;
        $coordinate->created_at = $now->format('Y-m-d H:i:s');

        if ($this->Coordinates->save($coordinate)) {
            $string_img = preg_replace("/data:[^,]+,/i", "", $string_img);
            $base64_img = base64_decode($string_img);
            if ($base64_img === false) {
                throw new \Exception('Failed to decode to base64.');
            }

            $img_resource = imagecreatefromstring($base64_img);
            if ($img_resource === false) {
                throw new \Exception(
                    'Failed to create image from string. The image type is unsupported, the data is not in a recognised format, or the image is corrupt and cannot be loaded.'
                );
            }

            imagesavealpha($img_resource, true);
            $result = imagepng($img_resource, WWW_ROOT . '/img/coordinates/' . $coordinate->id . '.png');
            if ($result === false) {
                throw new \Exception('Failed to save image.');
            }

            foreach ($items as $item) {
                $coordinates_item = $coordinates_items_repository->newEntity();
                $coordinates_item->coordinate_id = $coordinate->id;
                $coordinates_item->item_id = $item['itemId'];
                $coordinates_item->created_at = $now->format('Y-m-d H:i:s');

                if (!$coordinates_items_repository->save($coordinates_item)) {
                    throw new \Exception('Failed to save coordinates_item entity');
                }
            }

            $coordinate->photo = $coordinate->id . '.png';
            $this->Coordinates->save($coordinate);

            return $coordinate->id;
        } else {
            throw new \Exception('Failed to save coordinate entity.');
        }
    }

    /**
     * Ajax用関数
     * コーディネート画像を受け取り投稿処理を行う
     *
     * @throws \Exception
     */
    public function ajaxPostCoordinate()
    {
        $this->autoRender = FALSE;
        if ($this->request->is('post')) {
            $result = null;
            try {
                $result = $this->postCoordinate(
                    $this->request->data('img'),
                    json_decode($this->request->data(self::SESSION_KEY), true),
                    $this->request->data('sex'),
                    $this->request->data('season')
                );
            } catch (\Exception $e) {
                trigger_error($e->getMessage(), E_USER_WARNING);
                echo '{"hasSucceeded": false}';
                exit;
            }
            echo '{"hasSucceeded": true, "id": ' . $result . '}';
            exit;
        }
    }

    /**
     * @TODO : Also remove images of the coordinate when the coordinate deleted.
     *
     * @param int|null $id
     * @return \Cake\Network\Response|null
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $coordinate = $this->Coordinates->get($id);
        $user_id = $this->request->session()->read('Auth.User.id');
        if ($user_id !== $coordinate->user_id) {
            throw new \Exception('Permission error. Coordinate can be deleted only by that author.');
        }

        $result = $this->Coordinates->delete($coordinate);
        if (!$result) {
            throw new \Exception('Failed to delete coordinate.');
        }

        return $this->redirect(
            [
                'controller' => 'users',
                'action' => 'view',
                $user_id,
            ]
        );
    }

    /**
     * @param array $request_data
     * @return array
     */
    protected static function validateCriteria(array $request_data)
    {
        $criteria = [];
        if (strlen($request_data['sex']) !== 0) {
            if (array_key_exists($request_data['sex'], Item::getSexes())) {
                $criteria['sex in'] = [(int)$request_data['sex'], Item::SEX_UNISEX];
            }
        }

        if (strlen($request_data['category']) !== 0) {
            if (array_key_exists($request_data['category'], Item::getCategories())) {
                $criteria['category'] = Item::getCategories()[$request_data['category']];
            }
        }

        if (strlen(!empty($request_data['color'])) !== 0) {
            if (array_key_exists($request_data['color'], Item::getColors())) {
                $criteria['color'] = Item::getColors()[$request_data['color']];
            }
        }

        if (strlen(!empty($request_data['price'])) !== 0) {
            $price_limit = explode(',', $request_data['price']);
            if (count($price_limit) === 2) {
                $criteria['price >='] = (int)$price_limit[0];
                $criteria['price <='] = (int)$price_limit[1];
            }
        }

        return $criteria;
    }

    /**
     * @param array $criteria
     * @return \Cake\ORM\Query
     */
    protected function findItemList(array $criteria)
    {
        /** @var ItemsTable $items_repository */
        $items_repository = TableRegistry::get('Items');
        $items = $items_repository->find()
            ->where($criteria)
            ->limit(self::N_ITEM_LIST_SHOW);
        return $items;
    }


    /**
     * Ajax用関数
     * お気に入りに入れたいコーディネートの ID を受け取り，
     * お気に入りに追加する処理を行う
     *
     * @throws \Exception
     */
    public function ajaxPostFavorite()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $favorite_id = filter_input(
                INPUT_POST, 'coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            $user_id = $this->request->session()->read('Auth.User.id');
            try {
                $this->postFavorite($user_id, $favorite_id);
            } catch (\Exception $e) {
                trigger_error($e->getMessage(), E_USER_WARNING);
                echo '{"hasSucceeded": false}';
                exit;
            }
        }
        echo '{"hasSucceeded": true}';
        exit;
    }

    /**
     * お気に入りを追加する
     *
     * @param $uid
     * @param $coordinate_id
     *
     * @return bool 登録できたなら true, 重複により登録できなかったなら false
     * @throws \Exception
     */
    public function postFavorite($uid, $coordinate_id)
    {
        if (is_numeric($coordinate_id) == false
            || is_numeric($uid) == false
        ) {
            throw new \Exception(
                'Failed to save entity. Illegal value type.'
            );
        }

        $favorites_table = TableRegistry::get('Favorites');
        $exist_check = $favorites_table->find()->where(
            [
                'Favorites.user_id' => $uid,
                'Favorites.coordinate_id' => $coordinate_id,
            ]
        );
        if (empty(count($exist_check->toArray()))) {
            $now = new \DateTime();
            $favorite = $favorites_table->newEntity(
                [
                    'user_id' => $uid,
                    'coordinate_id' => $coordinate_id,
                ]
            );
            $favorite->created_at = $now->format('Y-m-d H:i:s');
            $favorites_table->save($favorite);
            return true;
        } else {
            return false;
        }
    }
}
