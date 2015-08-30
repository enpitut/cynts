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
    const RANKING_SHOW_LIMIT = 9;

    const RANKING_TYPE_LIKE = 'like';
    const RANKING_TYPE_UNLIKE = 'unlike';

    /**
     * View method
     *
     * @param null $type
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($type = null)
    {
        /** @var \App\Model\Table\CoordinatesTable $coordinates */
        $coordinates = TableRegistry::get('Coordinates');

        switch ($type) {
            case self::RANKING_TYPE_UNLIKE:
                $ranking = $coordinates->find('all',
                    [
                        'order' => ['Coordinates.n_unlike' => 'DESC'],
                        'contain' => ['Users', 'Items', 'Favorites'],
                        'limit' => self::RANKING_SHOW_LIMIT,
                    ]
                );
                break;
            default:
                $ranking = $coordinates->find('all',
                    [
                        'order' => ['Coordinates.n_like' => 'DESC'],
                        'contain' => ['Users', 'Items', 'Favorites'],
                        'limit' => self::RANKING_SHOW_LIMIT,
                    ]
                );
        }

        $this->set('ranking', $ranking);
        $this->set('_serialize', ['ranking']);
    }
}
