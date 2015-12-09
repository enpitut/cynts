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
    const MODE_COORDINATES = 'coordinates';
    const MODE_FAVORITES = 'favorites';

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(
            ['signup', 'logout']
        );
    }

    /**
     * @param string|null $user_id
     * @param string|null $mode 'coordinates' or 'favorites'
     */
    public function view($user_id = null, $mode = null)
    {
        //2回目以上の訪問かをチェックし， SESSION 情報を更新する
        $this->updateHasVisitedFlag();

        if ((int)$this->Auth->user('id') === (int)$user_id) {
            $this->set('is_self_page', true);
        } else {
            $this->set('is_self_page', false);
        }

        switch ($mode) {
            case self::MODE_FAVORITES:
                $user = $this->Users->get($user_id, ['contain' => ['Favorites.Coordinates']]);
                $favorites = $user->favorites;
                $coordinates = [];
                foreach ($favorites as $_val) {
                    $coordinates[] = $_val->coordinate;
                }
                break;
            case self::MODE_COORDINATES:
            default:
                $user = $this->Users->get($user_id, ['contain' => ['Coordinates']]);
                $coordinates = $user->coordinates;
                $mode = self::MODE_COORDINATES;
        }

        $this->set('user', $user);
        $this->set('mode', $mode);
        $this->set('coordinates', $coordinates);
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
