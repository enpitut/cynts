<?php
namespace App\Controller;

use App\Model\Entity\Item;
use Cake\Event\Event;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 */
class ItemsController extends AppController
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
            'contain' => ['Shops']
        ];
        $this->set('items', $this->paginate($this->Items));
        $this->set('_serialize', ['items']);
        $this->set('sex_list', self::_getSexesIncludingUnisex());
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Shops', 'Coordinates']
        ]);
        $this->set('item', $item);
        $this->set('_serialize', ['item']);
        $this->set('sex_list', self::_getSexesIncludingUnisex());
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->data);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        $shops = $this->Items->Shops->find('list', ['limit' => 200]);
        $coordinates = $this->Items->Coordinates->find('list', ['limit' => 200]);
        $this->set(compact('item', 'shops', 'coordinates'));
        $this->set('_serialize', ['item']);
        $this->set('sex_list', self::_getSexesIncludingUnisex());
        $this->set('color_list', self::_getColorsForFormOption());
        $this->set('category_list', self::_getCategoriesForFormOption());
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Coordinates']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->data);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        $shops = $this->Items->Shops->find('list', ['limit' => 200]);
        $coordinates = $this->Items->Coordinates->find('list', ['limit' => 200]);
        $this->set(compact('item', 'shops', 'coordinates'));
        $this->set('_serialize', ['item']);
        $this->set('sex_list', self::_getSexesIncludingUnisex());
        $this->set('color_list', self::_getColorsForFormOption());
        $this->set('category_list', self::_getCategoriesForFormOption());
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * こういうこと書きたくなかった
     *
     * @return array
     */
    private static function _getSexesIncludingUnisex()
    {
        return array_merge(Item::getSexes(), [Item::SEX_UNISEX => 'unisex']);
    }

    /**
     * こういうこと書きたくなかった
     *
     * @return array
     */
    private static function _getCategoriesForFormOption()
    {
        $category_list_for_form_option = [];
        foreach (item::getcategories() as $_val) {
            $category_list_for_form_option[$_val] = $_val;
        }
        return $category_list_for_form_option;
    }

    /**
     * こういうこと書きたくなかった
     *
     * @return array
     */
    private static function _getColorsForFormOption()
    {
        $color_list_for_form_option = [];
        foreach (item::getColors() as $_val) {
            $color_list_for_form_option[$_val] = $_val;
        }
        return $color_list_for_form_option;
    }
}
