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
    const RANKING_SHOW_LIMIT = 13;
    const RANKING_TYPE_LIKE = 'like';
    const RANKING_TYPE_UNLIKE = 'unlike';
    const NUM_COLUMN_UNDER_RANK_4TH = 5;

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

        $this->set('type', is_null($type) ? self::RANKING_TYPE_LIKE : $type);
        $this->set('sex_list', Item::getSexes());
        $this->set('ranking', $ranking_array);
        $this->set('_serialize', ['ranking']);
    }

    public function ajaxUpdateRanking()
    {
        if ($this->request->is('post')) {
            $type = $this->request->data('type');
            if (
                $type !== self::RANKING_TYPE_LIKE &&
                $type !== self::RANKING_TYPE_UNLIKE
            ) {
                error_log('Received illegal ranking type.');
                echo sprintf(
                    '{"hasSucceeded":false, "errorMessage":"%s"}',
                    "POSTメソッドで送信された値が不正でした．"
                );
                exit;
            }

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
                    "n_unlike" => $coordinate->n_unlike,
                    "user_name" => is_null($coordinate->user) ? "" : $coordinate->user->name,
                    "user_id" => is_null($coordinate->user) ? "" : $coordinate->user->id,
                ];
            }
            $coordinates_array["RANKING_SHOW_LIMIT"] = self::RANKING_SHOW_LIMIT;
            $coordinates_array["type"] = $type;
            $coordinates_array["hasSucceeded"] = true;

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
                CoordinatesTable::COORDINATES_UNLIKE_RANKING_CACHE_PREFIX . sha1(
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
                CoordinatesTable::COORDINATES_LIKE_RANKING_CACHE_PREFIX . sha1(
                    $criteria_json_string
                )
            );
        }
    }
}
