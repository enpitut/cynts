<?php
namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Table\CoordinatesTable;
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use App\Model\Entity\Item;
use App\Model\Criteria;

/**
 * Class CoordinatesBattleController
 * @package App\Controller
 */
class CoordinatesBattleController extends AppController
{
    /** @var \App\Model\Table\CoordinatesTable $Coordinates */
    protected $Coordinates;
    /** @var \App\Controller\CoordinatesController $CoordinatesController */
    protected $CoordinatesController;

    public function initialize()
    {
        parent::initialize();
        $this->Coordinates = TableRegistry::get('Coordinates');
        $this->CoordinatesController = new CoordinatesController();
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(
            ['view']
        );
    }

    /**
     * @return \Cake\Network\Response|void
     */
    public function battle()
    {
        $coordinates = $this->Coordinates->find(
            'all',
            [
                'order' => 'rand()',
                'limit' => 2,
            ]
        );
        if (count($coordinates->toArray()) < 2) {
            error_log('Too few coordinates');
            return $this->redirect(
                [
                    'controller' => 'Pages',
                    'action' => 'display',
                ]
            );
        }
        $this->set('sex_list', Item::getSexes());
        $this->set(compact('coordinates'));
    }

    /**
     * ajax用関数(echo を利用しているので他では使わないこと)
     * ここでレンダリングされたビュー(get_new_coordinate.ctp)は利用しないので，
     * ajax から POST メソッドでデータが送られてきた場合のみ利用可能
     */
    public function getNewCoordinate()
    {
        if ($this->request->is('post')) {
            $like_coordinate_id = filter_input(
                INPUT_POST, 'liked_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            $dislike_coordinate_id = filter_input(
                INPUT_POST, 'disliked_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            if ($like_coordinate_id === null || $like_coordinate_id === false
                || $dislike_coordinate_id === null || $dislike_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo sprintf(
                    '{"hasSucceeded":false, "errorMessage":"%s"}',
                    "POSTメソッドで送信された値が不正でした．" .
                    "ページをリロードするか，ヘッダーの「Unichronicle」からTOPページへ" .
                    "戻り，Play しなおしてください(これまでのバトル経過は破棄されます)．"
                );
                exit;
            }
            $criteria_json_string = $this->request->data('coordinate_criteria');

            try {
                $this->_incrementCoordinatesPoint('n_like', $like_coordinate_id);
                $this->_incrementCoordinatesPoint('n_unlike', $dislike_coordinate_id);
            } catch(\Exception $e) {
                error_log($e->getMessage());
                exit();
            }

            try {
                $coordinate = $this->_findCoordinateNotDuplicated(
                    [
                        $like_coordinate_id,
                        $dislike_coordinate_id
                    ],
                    $criteria_json_string
                );
            } catch (Exception $e) {
                echo sprintf(
                    '{"hasSucceeded":false, "errorMessage":"%s"}',
                    "条件に一致するコーデが存在しません"
                );
                exit;
            }

            echo sprintf(
                '{"id":%d, "url":"%s", "hasSucceeded":true}',
                $coordinate->id,
                $coordinate->photo_path
            );

        } else {
            return $this->redirect(['action' => 'battle']);
        }
    }

    public function ajaxGetCoordinatesPairMeetCriteria() {
        if ($this->request->is('post')) {
            $a_side_coordinate_id = filter_input(
                INPUT_POST, 'a_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            $b_side_coordinate_id = filter_input(
                INPUT_POST, 'b_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            if (is_null($a_side_coordinate_id) || $a_side_coordinate_id === false ||
                is_null($b_side_coordinate_id) || $b_side_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo sprintf(
                    '{"hasSucceeded":false, "errorMessage":"%s"}',
                    "POSTメソッドで送信された値が不正でした．" .
                    "ページをリロードするか，ヘッダーの「Unichronicle」からTOPページへ" .
                    "戻り，Play しなおしてください(これまでのバトル経過は破棄されます)．"
                );
                exit;
            }
            $criteria_json_string = $this->request->data('coordinate_criteria');

            try {

                $new_a_side_coordinate = $this->_findCoordinateNotDuplicated(
                    [
                        $a_side_coordinate_id,
                        $b_side_coordinate_id
                    ],
                    $criteria_json_string
                );

                $new_b_side_coordinate = $this->_findCoordinateNotDuplicated(
                    [
                        $a_side_coordinate_id,
                        $b_side_coordinate_id,
                        $new_a_side_coordinate->id
                    ],
                    $criteria_json_string
                );

            } catch (Exception $e) {
                echo sprintf(
                    '{"hasSucceeded":false, "errorMessage":"%s"}',
                    "条件に一致するコーデが存在しません"
                );
                exit;
            }

            echo sprintf(
                '{"0":{"id":%d, "url":"%s"}, "1":{"id":%d, "url":"%s"}, "hasSucceeded":true}',
                $new_a_side_coordinate->id,
                $new_a_side_coordinate->photo_path,
                $new_b_side_coordinate->id,
                $new_b_side_coordinate->photo_path
            );
        }
    }

    private function _findCoordinateNotDuplicated($coordinate_ids, $criteria_json_string){
        $n_loop = 0;

        while (true) {
            $coordinate = $this->_extractRandomCoordinateMeetCriteria($criteria_json_string);

            if ($coordinate === null) {
                throw new Exception("Not coordinate found");
            }

            if (in_array($coordinate->id, $coordinate_ids)) {
                // セーフティブレーク
                if (++$n_loop > 20) {
                    // 条件に一致するコーデは存在しているが，現在表示されているコーデと重複している
                    // (1~2着しか条件に一致するコーデがない)
                    throw new Exception("Not coordinate found");
                }
                continue;
            } else {
                return $coordinate;
            }
        }
    }

    /**
     * @param $criteria_json_string
     *
     * @return \App\Model\Entity\Coordinate $coordinate
     */
    private function _extractRandomCoordinateMeetCriteria($criteria_json_string)
    {
        /*
         * 条件にあったコーデ群を取得する
         * 検索条件毎に一意の文字列(JSON文字列に対してSHA-1を使用する)を生成し，それをキーとしてキャッシュする
         */
        $filtered_coordinates = Criteria\CoordinatesCriteria::createQueryFromJson(
            $criteria_json_string
        )->cache(CoordinatesTable::COORDINATES_CACHE_PREFIX . sha1($criteria_json_string));

        // 取得したコーデ群からランダムに 1 つ抽出し返す
        return $coordinate = $filtered_coordinates->all()->shuffle()->first();
    }

    /**
     * コーディネートのポイント(n_like, n_unlike)の値をインクリメントする
     * 指定された ID のコーディネートが見つからなかった場合は，何もしない
     *
     * @param $element
     * @param $id
     *
     * @throws \Exception
     */
    private function _incrementCoordinatesPoint($element, $id)
    {
        if ($element !== 'n_like' && $element !== 'n_unlike') {
            throw new \Exception(
                'Invalid element is given. \'n_like\' or \'n_unlike\' is only allowed.'
            );
        }
        $coordinate = $this->Coordinates->find()->where(
            ['Coordinates.id' => $id]
        )->first();
        if (is_null($coordinate)) { return; }
        $coordinate->$element = $coordinate->$element + 1;
        $this->Coordinates->save($coordinate);
    }

    public function buy()
    {
        echo "buy";
    }

    /**
     * ajax用関数(echo を利用しているので他では使わないこと)
     * ここでレンダリングされたビュー(favorite.ctp)は利用しないので，
     * ajax から POST メソッドでデータが送られてきた場合のみ利用可能
     */
    public function ajaxPostFavorite()
    {
        if ($this->request->is('post')) {
            $favorite_coordinate_id = $this->request->data('favorite_id');
            $uid = $this->Auth->user('id');

            try {
                if ($this->CoordinatesController->postFavorite(
                    $uid,
                    $favorite_coordinate_id
                )
                ) {
                    echo '{"hasSucceeded": true, "hasRegistered": true}';
                    exit;
                } else {
                    echo '{"hasSucceeded": true, "hasRegistered": false }';
                    exit;
                }
            } catch (\Exception $e) {
                error_log($e->getMessage(), E_WARNING);
                sprintf('{"hasSucceeded": false, "errorMessage":%s}',
                    $e->getMessage()
                );
                exit;
            }
        } else {
            return $this->redirect(['action' => 'battle']);
        }
    }

    const SCORE_WIN = 100;
    const SCORE_LOOSE = 0;
    const SCORE_DRAW = 50;

    /**
     * ajax用関数(echo を利用しているので他では使わないこと)
     * ここでレンダリングされたビュー(get_score.ctp)は利用しないので，
     * ajax から POST メソッドでデータが送られてきた場合のみ利用可能
     */
    public function getScore()
    {
        if ($this->request->is('post')) {
            $a_side_coordinate_id = filter_input(
                INPUT_POST, 'a_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            $b_side_coordinate_id = filter_input(
                INPUT_POST, 'b_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            $like_coordinate_id = filter_input(
                INPUT_POST, 'liked_coordinate_id', FILTER_SANITIZE_NUMBER_INT
            );
            if (is_null($a_side_coordinate_id)
                || $a_side_coordinate_id === false
                || is_null($b_side_coordinate_id)
                || $b_side_coordinate_id === false
                || is_null($like_coordinate_id)
                || $like_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo sprintf('{"hasSucceeded": false, "errorMessage": "%s"}',
                    "Received illegal post value."
                );
                exit;
            }

            $a_side_coordinate = $this->Coordinates->find()->where(
                ['Coordinates.id' => $a_side_coordinate_id]
            )->first();
            $b_side_coordinate = $this->Coordinates->find()->where(
                ['Coordinates.id' => $b_side_coordinate_id]
            )->first();

            if (is_null($a_side_coordinate) || is_null($b_side_coordinate))
            {
                echo sprintf('{"hasSucceeded": false, "errorMessage": "%s"}',
                    "Selected coordinates are not found. Ignored."
                );
                exit;
            }

            // TODO: コーデの得票数が明らかに少ない場合には，無視した方が良い？
            $a_side_point = $a_side_coordinate->n_like;
            $b_side_point = $b_side_coordinate->n_like;
            // ユーザが良いコーデを選択したか，悪いコーデを選択したかをここで保持しておく
            // 1: 良いコーデを選択した
            // 0: 悪いコーデを選択した
            // -1: 引き分け
            if ($a_side_point === $b_side_point) {
                $result = -1;
                $score = self::SCORE_DRAW;
            } else {
                $winner = $a_side_point > $b_side_point ?
                    $a_side_coordinate_id : $b_side_coordinate_id;
                $result = $winner === $like_coordinate_id ? 1 : 0;
                $score = $result === 1 ? self::SCORE_WIN : self::SCORE_LOOSE;
            }

            echo sprintf(
                '{"a_side_point":%d, "b_side_point":%d,
                  "a_side_photo_path":"%s", "b_side_photo_path":"%s",
                  "score":%d, "result":%d, "hasSucceeded":true}',
                $a_side_point,
                $b_side_point,
                $a_side_coordinate->photo_path,
                $b_side_coordinate->photo_path,
                $score,
                $result
            );
        } else {
            return $this->redirect(['action' => 'battle']);
        }
    }

    /**
     * POST メソッドで画面遷移してきた場合にのみ利用可能
     * JS 側のデータを受け渡すために，現在は JS 上で form タグを動的に生成し，それを実行することで result 画面に遷移させている
     * バトルの結果を取得し，結果画面をレンダリングする
     *
     * @return \Cake\Network\Response|void
     */
    public function result()
    {
        if ($this->request->is('post')) {
            $json_data = json_decode($this->request->data('battle_info'));
            $score = $json_data->{"score"};
            $max_n_battle = $json_data->{"max_n_battle"};
            $battle_history = $json_data->{"battle_history"};
            $score_win = self::SCORE_WIN;

            /** @var User $user */
            $user = TableRegistry::get('Users')->get($this->Auth->user('id'));

            $previous_level = $user->getCoordinateLevel();
            self::incrementUserCoordinatePoint($user, $score);
            $current_level = $user->getCoordinateLevel();
            $point_to_next_level = $user->getPointToNextLevel();

            $this->set(compact(
                'score', 'max_n_battle', 'battle_history', 'score_win',
                'previous_level', 'current_level', 'point_to_next_level'
            ));
        } else {
            return $this->redirect(['action' => 'battle']);
        }
    }

    /**
     * @param User $user
     * @param int $score
     */
    protected function incrementUserCoordinatePoint(User $user, $score)
    {
        $user->coordinate_point = is_null($user->coordinate_point) ? 0 : $user->coordinate_point;
        $user->coordinate_point += $score;
        TableRegistry::get('Users')->save($user);
    }
}
