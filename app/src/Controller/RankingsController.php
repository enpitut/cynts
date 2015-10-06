<?php
namespace App\Controller;

use App\Model\Entity\Coordinate;
use App\Model\Entity\Item;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Class RankingsController
 * @package App\Controller
 */
class RankingsController extends AppController
{
    const RANKING_SHOW_LIMIT = 9;
    const RANKING_TYPE_LIKE = 'like';
    const RANKING_TYPE_UNLIKE = 'unlike';

    /** @var \App\Model\Table\CoordinatesTable $Coordinates */
    protected $Coordinates;

    public function initialize()
    {
        parent::initialize();
        $this->Coordinates = TableRegistry::get('Coordinates');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(
            ['view']
        );
    }

    /**
     * View method
     *
     * @param null $type
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($type = null)
    {
        switch ($type) {
            case self::RANKING_TYPE_UNLIKE:
                $ranking = $this->Coordinates->find('all',
                    [
                        'order' => ['Coordinates.n_unlike' => 'DESC'],
                        'contain' => ['Users', 'Items', 'Favorites'],
                        'limit' => self::RANKING_SHOW_LIMIT,
                    ]
                );
                break;
            default:
                $ranking = $this->Coordinates->find('all',
                    [
                        'order' => ['Coordinates.n_like' => 'DESC'],
                        'contain' => ['Users', 'Items', 'Favorites'],
                        'limit' => self::RANKING_SHOW_LIMIT,
                    ]
                );
        }

        /** @var Coordinate $coordinate */
        $ranking_array = $ranking->toArray();
        foreach ($ranking_array as $key => $coordinate) {
            $total_price = 0;
            /** @var Item $item */
            foreach ($coordinate->items as $item) {
                $total_price += $item->price;
            }
            $ranking_array[$key]->set('total_price', $total_price);
        }

        $this->set('ranking', $ranking_array);
        $this->set('_serialize', ['ranking']);
    }
}
