<?php
namespace App\Controller;

use App\Model\Entity\Coordinate;
use App\Model\Entity\Item;
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

        $this->set('sex_list', Item::getSexes());
        $this->set('ranking', $ranking_array);
        $this->set('_serialize', ['ranking']);
    }

    public function ajaxUpdateRanking()
    {
        if ($this->request->is('post')) {
            $criteria_json_string = $this->request->data('coordinate_criteria');

            // 条件にあったコーデ群を取得する
            // 検索条件毎に一意の文字列(JSON文字列に対してSHA-1を使用する)を生成し，
            // それをキーとしてキャッシュする
            $filtered_coordinates = Criteria\CoordinatesCriteria::createQueryFromJson(
                $criteria_json_string
            )->cache('filtered_coordinates_' . sha1($criteria_json_string));
            $coordinates = $filtered_coordinates
                ->limit(self::RANKING_SHOW_LIMIT)
                ->all()
                ->sortBy(
                'n_like', SORT_DESC, SORT_NUMERIC
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
}
