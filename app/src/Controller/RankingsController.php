<?php
namespace App\Controller;

use App\Model\Entity\Coordinate;
use App\Model\Entity\Item;
use App\Model\Table\CoordinatesTable;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use App\Model\Criteria;

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
            ['view', 'ajaxUpdateRanking']
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
        $ranking_array = $this->_getRanking($type);

        $this->set('sex_list', Item::getSexes());
        $this->set('ranking', $ranking_array);
        $this->set('_serialize', ['ranking']);
    }

    public function ajaxUpdateRanking($type = null)
    {
        if ($this->request->is('post')) {
            $coordinates = $this->_getRanking(
                $type,
                $this->request->data('coordinate_criteria')
            );

            // javascript で処理するため，配列に変換する
            $coordinates_array = [];
            $rank = 0;
            foreach ($coordinates as $coordinate) {
                $coordinates_array[(String)$rank++] = [
                    "id" => $coordinate->id,
                    "total_price" => $coordinate->price,
                    "photo_path" => $coordinate->photo_path,
                    "n_like" => $coordinate->n_like,
                    "user_name" => is_null($coordinate->user) ? "" : $coordinate->user->name,
                    "user_id" => is_null($coordinate->user) ? "" : $coordinate->user->id,
                ];
            }
            $coordinates_array["RANKING_SHOW_LIMIT"] = self::RANKING_SHOW_LIMIT;

            echo json_encode($coordinates_array);
        } else {
            return $this->redirect(['action' => 'battle']);
        }
    }

    private function _getRanking($type, $criteria_json_string="{}")
    {
        switch ($type) {
        case self::RANKING_TYPE_UNLIKE:
            return $ranking = Criteria\CoordinatesCriteria::createQueryFromJson(
                $criteria_json_string,
                [
                    'order' => ['Coordinates.n_unlike' => 'DESC'],
                    'contain' => ['Users', 'Items', 'Favorites'],
                    'limit' => self::RANKING_SHOW_LIMIT,
                ]
            )->cache(
                CoordinatesTable::COORDINATES_CACHE_PREFIX . '_ranking_' . sha1(
                    $criteria_json_string
                )
            );
            break;
        default:
            return $ranking = Criteria\CoordinatesCriteria::createQueryFromJson(
                $criteria_json_string,
                [
                    'order' => ['Coordinates.n_like' => 'DESC'],
                    'contain' => ['Users', 'Items', 'Favorites'],
                    'limit' => self::RANKING_SHOW_LIMIT,
                ]
            )->cache(
                CoordinatesTable::COORDINATES_CACHE_PREFIX . '_ranking_' . sha1(
                    $criteria_json_string
                )
            );
        }
    }
}
