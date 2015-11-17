<?php
namespace App\Controller;

use Cake\Event\Event;

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
    public function signup()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->set('created_at', time());
            $user->set('updated_at', time());
            if ($this->Users->save($user)) {
                return $this->redirect(['action' => 'login']);
            }
        }
        $this->set('user', $user);
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
                __('メールアドレスかパスワードが間違っています'),
                'default',
                [],
                'auth'
            );
            $this->request->data['mail'] = '';
            $this->request->data['password'] = '';
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
