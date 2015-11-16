<?php
namespace App\Controller;

use App\Model\Entity\User;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(
            ['signup', 'logout']
        );
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Coordinates', 'Favorites']
        ]);
        $favoriteTable = TableRegistry::get('Favorites');
        $favorite = $favoriteTable->find()->where(
            [
                'Favorites.user_id' => $id
            ]
        )->contain(['Coordinates']);
        $this->set('favorite', $favorite);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        if ((int)$this->Auth->user('id') === (int)$id) {
            $this->set('is_self_page', true);
        } else {
            $this->set('is_self_page', false);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->set('password', User::hashPassword($user->get('password')));
            $user->set('created_at', time());
            $user->set('updated_at', time());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect([
                    'controller' => 'Pages',
                    'action' => 'display',
                ]);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function signup()
    {
        $this->add();
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(
                __('Username or password is incorrect'),
                'default',
                [],
                'auth'
            );
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
