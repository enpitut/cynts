<?php
namespace App\Controller;

use App\Model\Entity\Item;
use App\Model\Table\ItemsTable;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
        $this->set(compact('coordinates'));
    }

    /**
     * ajax 用の関数だから，echo してる（他では使わないこと）
     */
    public function send()
    {
        $pushed_coordinate_id = $this->request->data('id');
        $pushed_coordinate = $this->Coordinates->get($pushed_coordinate_id);
        $pushed_coordinate->n_like = $pushed_coordinate->n_like + 1;
        $this->Coordinates->save($pushed_coordinate);

        $unpushed_coordinate_id = $this->request->data('d_id');
        $unpushed_coordinate = $this->Coordinates->get($unpushed_coordinate_id);
        $unpushed_coordinate->n_unlike = $unpushed_coordinate->n_unlike + 1;
        $this->Coordinates->save($unpushed_coordinate);

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
                if ($pushed_coordinate_id == $coordinate->id ||
                    $unpushed_coordinate_id == $coordinate->id
                ) {
                    continue;
                }
                echo "{id:\"" . $coordinate->id . "\", url:\"" . $coordinate->photo_path . "\"}";
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
    }

    public function buy()
    {
        echo "buy";
    }
}
