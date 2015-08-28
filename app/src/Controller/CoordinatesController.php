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
}
