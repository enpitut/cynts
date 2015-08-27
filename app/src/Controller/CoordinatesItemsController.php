<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CoordinatesItems Controller
 *
 * @property \App\Model\Table\CoordinatesItemsTable $CoordinatesItems
 */
class CoordinatesItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Coordinates', 'Items']
        ];
        $this->set('coordinatesItems', $this->paginate($this->CoordinatesItems));
        $this->set('_serialize', ['coordinatesItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Coordinates Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coordinatesItem = $this->CoordinatesItems->get($id, [
            'contain' => ['Coordinates', 'Items']
        ]);
        $this->set('coordinatesItem', $coordinatesItem);
        $this->set('_serialize', ['coordinatesItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $coordinatesItem = $this->CoordinatesItems->newEntity();
        if ($this->request->is('post')) {
            $coordinatesItem = $this->CoordinatesItems->patchEntity($coordinatesItem, $this->request->data);
            if ($this->CoordinatesItems->save($coordinatesItem)) {
                $this->Flash->success(__('The coordinates item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The coordinates item could not be saved. Please, try again.'));
            }
        }
        $coordinates = $this->CoordinatesItems->Coordinates->find('list', ['limit' => 200]);
        $items = $this->CoordinatesItems->Items->find('list', ['limit' => 200]);
        $this->set(compact('coordinatesItem', 'coordinates', 'items'));
        $this->set('_serialize', ['coordinatesItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Coordinates Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coordinatesItem = $this->CoordinatesItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coordinatesItem = $this->CoordinatesItems->patchEntity($coordinatesItem, $this->request->data);
            if ($this->CoordinatesItems->save($coordinatesItem)) {
                $this->Flash->success(__('The coordinates item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The coordinates item could not be saved. Please, try again.'));
            }
        }
        $coordinates = $this->CoordinatesItems->Coordinates->find('list', ['limit' => 200]);
        $items = $this->CoordinatesItems->Items->find('list', ['limit' => 200]);
        $this->set(compact('coordinatesItem', 'coordinates', 'items'));
        $this->set('_serialize', ['coordinatesItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Coordinates Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coordinatesItem = $this->CoordinatesItems->get($id);
        if ($this->CoordinatesItems->delete($coordinatesItem)) {
            $this->Flash->success(__('The coordinates item has been deleted.'));
        } else {
            $this->Flash->error(__('The coordinates item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
