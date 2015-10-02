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
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('coordinates', $this->paginate($this->Coordinates));
        $this->set('_serialize', ['coordinates']);
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
     * Edit method
     *
     * @param string|null $id Coordinate id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coordinate = $this->Coordinates->get($id, [
            'contain' => ['Items']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coordinate = $this->Coordinates->patchEntity($coordinate, $this->request->data);
            if ($this->Coordinates->save($coordinate)) {
                $this->Flash->success(__('The coordinate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The coordinate could not be saved. Please, try again.'));
            }
        }
        $users = $this->Coordinates->Users->find('list', ['limit' => 200]);
        $items = $this->Coordinates->Items->find('list', ['limit' => 200]);
        $this->set(compact('coordinate', 'users', 'items'));
        $this->set('_serialize', ['coordinate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Coordinate id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coordinate = $this->Coordinates->get($id);
        if ($this->Coordinates->delete($coordinate)) {
            $this->Flash->success(__('The coordinate has been deleted.'));
        } else {
            $this->Flash->error(__('The coordinate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return \Cake\Network\Response|void
     */
    public function battle()
    {
        if ($this->request->is('post')) {
            $max_n_battle = $this->request->data('max_n_battle');
        } else {
            return $this->redirect(['action' => 'selectBattleMode']);
        }

        $coordinates = $this->Coordinates->find(
            'all',
            [
                'order' => 'rand()',
                'limit' => 2,
            ]
        );
        if (count($coordinates->toArray()) < 2) {
            error_log('Too few coordinates');
            return $this->redirect(
                [
                    'controller' => 'Pages',
                    'action' => 'display',
                ]
            );
        }
        $this->set(compact('coordinates', 'max_n_battle'));
    }

    /**
     * ajax用関数(echo を利用しているので他では使わないこと)
     * ここでレンダリングされたビュー(get_new_coordinate.ctp)は利用しないので，
     * ajax から POST メソッドでデータが送られてきた場合のみ利用可能
     */
    public function getNewCoordinate()
    {
        if ($this->request->is('post')) {
            $like_coordinate_id = filter_input(INPUT_POST, 'liked_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            $dislike_coordinate_id = filter_input(INPUT_POST, 'disliked_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            if ($like_coordinate_id === NULL || $like_coordinate_id === false
                || $dislike_coordinate_id === NULL || $dislike_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo '{"hasSucceeded": false}';
                exit;
            }

            $like_coordinate = $this->Coordinates->get($like_coordinate_id);
            $like_coordinate->n_like = $like_coordinate->n_like + 1;
            $this->Coordinates->save($like_coordinate);

            $dislike_coordinate = $this->Coordinates->get($dislike_coordinate_id);
            $dislike_coordinate->n_unlike = $dislike_coordinate->n_unlike + 1;
            $this->Coordinates->save($dislike_coordinate);

            $duplicated_flg = false;
            $n_loop = 0;
            while (true) {
                $coordinates = $this->Coordinates->find(
                    'all',
                    [
                        'order' => 'rand()',
                        'limit' => 1
                    ]
                );

                foreach ($coordinates as $coordinate) {
                    if ($like_coordinate_id == $coordinate->id ||
                        $dislike_coordinate_id == $coordinate->id
                    ) {
                        continue;
                    }
                    echo sprintf(
                        '{"id":%d, "url":"%s", "hasSucceeded":true}',
                        $coordinate->id,
                        $coordinate->photo_path
                    );
                    $duplicated_flg = true;
                }

                if ($duplicated_flg) {
                    break;
                }

                // セーフティブレーク
                if (++$n_loop > 20) {
                    break;
                }
            }
        } else {
            return $this->redirect(['action' => 'selectBattleMode']);
        }
    }

    public function buy()
    {
        echo "buy";
    }

    /**
     * ajax用関数(echo を利用しているので他では使わないこと)
     * ここでレンダリングされたビュー(favorite.ctp)は利用しないので，
     * ajax から POST メソッドでデータが送られてきた場合のみ利用可能
     */
    public function favorite()
    {
        if ($this->request->is('post')) {
            $favorite_coordinate_id = filter_input(INPUT_POST, 'favorite_id', FILTER_SANITIZE_NUMBER_INT);
            if ($favorite_coordinate_id === NULL || $favorite_coordinate_id === false) {
                error_log('Illegal value type');
                echo '{"hasSucceeded": false}';
                exit;
            }

            $uid = $this->Auth->user('id');
            $favorites_table = TableRegistry::get('Favorites');

            $exist_check = $favorites_table->find()->where(
                [
                    'Favorites.user_id' => $uid,
                    'Favorites.coordinate_id' => $favorite_coordinate_id,
                ]
            );
            if (empty(count($exist_check->toArray()))) {
                $now = new \DateTime();
                $favorite = $favorites_table->newEntity(
                    [
                        'user_id' => $uid,
                        'coordinate_id' => $favorite_coordinate_id,
                    ]
                );
                $favorite->created_at = $now->format('Y-m-d H:i:s');
                $favorites_table->save($favorite);
                echo '{"hasSucceeded": true, "hasRegistered": true}';
                exit;
            }
            echo '{"hasSucceeded": true, "hasRegistered": false }';
            exit;
        } else {
            return $this->redirect(['action' => 'selectBattleMode']);
        }
    }

    public function selectBattleMode()
    {
        // dummy
    }

    const SCORE_WIN = 100;
    const SCORE_LOOSE = 0;
    const SCORE_DRAW = 50;

    /**
     * ajax用関数(echo を利用しているので他では使わないこと)
     * ここでレンダリングされたビュー(get_score.ctp)は利用しないので，
     * ajax から POST メソッドでデータが送られてきた場合のみ利用可能
     */
    public function getScore()
    {
        if ($this->request->is('post')) {
            $a_side_coordinate_id = filter_input(INPUT_POST, 'a_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            $b_side_coordinate_id = filter_input(INPUT_POST, 'b_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            $like_coordinate_id = filter_input(INPUT_POST, 'liked_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            if ($a_side_coordinate_id === NULL || $a_side_coordinate_id === false
                || $b_side_coordinate_id === NULL || $b_side_coordinate_id === false
                || $like_coordinate_id === NULL || $like_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo '{"hasSucceeded": false}';
                exit;
            }

            $a_side_coordinate = $this->Coordinates->find()->where(
                [
                    'Coordinates.id' => $a_side_coordinate_id,
                ]
            )->first();
            $b_side_coordinate = $this->Coordinates->find()->where(
                [
                    'Coordinates.id' => $b_side_coordinate_id,
                ]
            )->first();

            // TODO: コーデの得票数が明らかに少ない場合には，無視した方が良い？
            $a_side_point = $a_side_coordinate->n_like;
            $b_side_point = $b_side_coordinate->n_like;
            // ユーザが良いコーデを選択したか，悪いコーデを選択したかをここで保持しておく
            // 1: 良いコーデを選択した
            // 0: 悪いコーデを選択した
            // -1: 引き分け
            if ($a_side_point === $b_side_point) {
                $result = -1;
                $score = self::SCORE_DRAW;
            } else {
                $winner = $a_side_point > $b_side_point ? $a_side_coordinate_id : $b_side_coordinate_id;
                $result = $winner === $like_coordinate_id ? 1 : 0;
                $score = $result === 1 ? self::SCORE_WIN : self::SCORE_LOOSE;
            }

            echo sprintf(
                '{"a_side_point":%d, "b_side_point":%d,
                  "a_side_photo_path":"%s", "b_side_photo_path":"%s",
                  "score":%d, "result":%d, "hasSucceeded":true}',
                $a_side_point,
                $b_side_point,
                $a_side_coordinate->photo_path,
                $b_side_coordinate->photo_path,
                $score,
                $result
            );
        } else {
            return $this->redirect(['action' => 'selectBattleMode']);
        }
    }

    /**
     * JavaScript から呼ばれる関数
     * POST メソッドで画面遷移してきた場合にのみ利用可能
     * JS 側のデータを受け渡すために，現在は JS 上で form タグを動的に生成し，それを実行することで result 画面に遷移させている
     * バトルの結果を取得し，結果画面をレンダリングする
     *
     * @return \Cake\Network\Response|void
     */
    public function result()
    {
        if ($this->request->is('post')) {
            $json_data = json_decode($this->request->data('battle_info'));
            $score = $json_data->{"score"};
            $max_n_battle = $json_data->{"max_n_battle"};
            $battle_history = $json_data->{"battle_history"};

            $score_win = self::SCORE_WIN;

            $this->set(compact('score', 'max_n_battle', 'battle_history', 'score_win'));
        } else {
            return $this->redirect(['action' => 'selectBattleMode']);
        }
    }
}
