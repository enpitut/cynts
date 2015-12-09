<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * @var array
     * @see \Cake\Controller\Component\AuthComponent::$components
     */
    public $components = [
        'Auth' => [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'mail',
                        'password' => 'password',
                    ],
                ],
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'home'
            ],
            'authError' => 'ログインしてください'
        ],
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->viewBuilder()->autoLayout(false);
    }

    public function isVisited()
    {
        $session = $this->request->session();
        $page_data = [];
        $page_data["controller"]  = is_null($this->name) ? "pages": $this->name;
        $page_data["action"] = is_null($this->request->action) ? "home" : $this->request->action;
        $page_data["page"] = strtolower($page_data["controller"])."_".strtolower($page_data["action"]);

        //$session->destroy('Visit');

        if(!($session->check('Visit.'.$page_data["page"]))){
            $session->write('Visit.'.$page_data["page"], 0);
        } else if (!($session->read('Visit.'.$page_data["page"]))) {
            $session->write('Visit.'.$page_data["page"], 1);
        }

        $this->set('page_data', $page_data);
    }

    public function beforeFilter(Event $event)
    {
        $this->isVisited();
    }

}
