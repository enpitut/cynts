<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Event\Event;

/**
 * Coordinates Controller
 *
 * @property \App\Model\Table\CoordinatesTable $Coordinates
 */
class CoordinatesController extends AppController
{
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
     * Add method
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
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
        $users = $this->Coordinates->Users->find('list', ['limit' => 200]);
        $items = $this->Coordinates->Items->find('list', ['limit' => 200]);
        $this->set(compact('coordinate', 'users', 'items'));
        $this->set('_serialize', ['coordinate']);
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
                echo "{\"id\":\"" . $coordinate->id . "\", \"url\":\"" . $coordinate->photo_path . "\"}";
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

    public function favorite()
    {
        if ($this->request->is('post')) {
            $favorite_coordinate_id = $this->request->data('favorite_id');
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
                echo "saved";
            }
        }
    }
}
