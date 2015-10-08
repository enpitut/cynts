<?php
namespace App\Controller;

use App\Model\Entity\Item;
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
    const N_ITEM_LIST_SHOW = 100;

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
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coordinate = $this->Coordinates->get($id, [
            'contain' => ['Users', 'Items', 'Favorites']
        ]);
        $total_price = 0;
        foreach ($coordinate->items as $item) {
            $total_price += $item->price;
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
        $coordinate = $this->Coordinates->newEntity();
        if ($this->request->is('post')) {
            $coordinate = $this->Coordinates->patchEntity($coordinate, $this->request->data);
            if ($this->Coordinates->save($coordinate)) {
                $this->Flash->success(__('The coordinate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The coordinate could not be saved. Please, try again.'));
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
     * @param array $request_data
     * @return array
     */
    protected static function validateCriteria(array $request_data)
    {
        $criteria = [];
        if (!empty($request_data['sex'])) {
            if (array_key_exists($request_data['sex'], Item::getSexes())) {
                $criteria['sex'] = (int)$request_data['sex'];
            }
        }

        if (!empty($request_data['category'])) {
            if (array_key_exists($request_data['category'], Item::getCategories())) {
                $criteria['category'] = Item::getCategories()[$request_data['category']];
            }
        }

        if (!empty($request_data['color'])) {
            if (array_key_exists($request_data['color'], Item::getColors())) {
                $criteria['color'] = Item::getColors()[$request_data['color']];
            }
        }

        if (!empty($request_data['price'])) {
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
