<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Rankings Controller
 *
 * @property \App\Model\Table\CoordinatesTable $Coordinates
 */
class RankingsController extends AppController
{
    /**
     * View method
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view()
    {
        /** @var \App\Model\Table\CoordinatesTable $coordinates */
        $coordinates = TableRegistry::get('Coordinates');
        $ranking = $coordinates->find('all', [
            'order' => ['Coordinates.n_like' => 'DESC'],
            'contain' => ['Users', 'Items', 'Favorites'],
        ]);
        $this->set('ranking', $ranking);
        $this->set('_serialize', ['ranking']);
    }
}
