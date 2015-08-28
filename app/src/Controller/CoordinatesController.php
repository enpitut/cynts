<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Coordinates Controller
 *
 * @property \App\Model\Table\CoordinatesTable $Coordinates
 */
class CoordinatesController extends AppController
{
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
        $this->set('coordinate', $coordinate);
        $this->set('_serialize', ['coordinate']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
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
     * @return void Redirects on successful edit, renders view otherwise.
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
     * @return void Redirects to index.
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

    public function battle()
    {
        if ($this->request->is('post')){
            $coordinate = $this->Coordinates->patchEntity($coordinate, $this->request->data);
        }

        $coordinates = $this->Coordinates->find('all',
                                                ['order' => 'rand()',
                                                 'limit' => 2]);
        $this->set(compact('coordinates'));
    }

    public function send(){
        $pushed_coordinate_id = $this->request->data('id');
        $pushed_coordinate = $this->Coordinates->get($pushed_coordinate_id);
        $pushed_coordinate->n_like = $pushed_coordinate->n_like+1;
        $this->Coordinates->save($pushed_coordinate);

        $unpushed_coordinate_id = $this->request->data('d_id');
        $unpushed_coordinate = $this->Coordinates->get($unpushed_coordinate_id);
        $unpushed_coordinate->n_unlike = $unpushed_coordinate->n_unlike+1;
        $this->Coordinates->save($unpushed_coordinate);

        $flag = false;
        while (true) {
            $coordinates = $this->Coordinates->find('all',
                                                    ['order' => 'rand()',
                                                     'limit' => 1]);
            foreach ($coordinates as $coordinate){
                if ($pushed_coordinate_id == $coordinate->id ||
                $unpushed_coordinate_id == $coordinate->id)
                    continue;
                echo "{id:\"" . $coordinate->id . "\", url:\"" . $coordinate->photos . "\"}";
                $flag = true;
            }
            if ($flag)
                break;
        }
    }
}
