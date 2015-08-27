<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Shops Controller
 *
 * @property \App\Model\Table\ShopsTable $Shops
 */
class ShopsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('shops', $this->paginate($this->Shops));
        $this->set('_serialize', ['shops']);
    }

    /**
     * View method
     *
     * @param string|null $id Shop id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shop = $this->Shops->get($id, [
            'contain' => ['Items']
        ]);
        $this->set('shop', $shop);
        $this->set('_serialize', ['shop']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shop = $this->Shops->newEntity();
        if ($this->request->is('post')) {
            $shop = $this->Shops->patchEntity($shop, $this->request->data);
            if ($this->Shops->save($shop)) {
                $this->Flash->success(__('The shop has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shop could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('shop'));
        $this->set('_serialize', ['shop']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Shop id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shop = $this->Shops->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shop = $this->Shops->patchEntity($shop, $this->request->data);
            if ($this->Shops->save($shop)) {
                $this->Flash->success(__('The shop has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shop could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('shop'));
        $this->set('_serialize', ['shop']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shop id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shop = $this->Shops->get($id);
        if ($this->Shops->delete($shop)) {
            $this->Flash->success(__('The shop has been deleted.'));
        } else {
            $this->Flash->error(__('The shop could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
