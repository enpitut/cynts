<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;

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
            $like_coordinate_id = filter_input(INPUT_POST, 'liked_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            $dislike_coordinate_id = filter_input(INPUT_POST, 'disliked_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            if ($like_coordinate_id === NULL || $like_coordinate_id === false
                || $dislike_coordinate_id === NULL || $dislike_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo '{"hasSucceeded": false}';
                exit;
            }

            $like_coordinate = $this->Coordinates->get($like_coordinate_id);
            $like_coordinate->n_like = $like_coordinate->n_like + 1;
            $this->Coordinates->save($like_coordinate);

            $dislike_coordinate = $this->Coordinates->get($dislike_coordinate_id);
            $dislike_coordinate->n_unlike = $dislike_coordinate->n_unlike + 1;
            $this->Coordinates->save($dislike_coordinate);

            $duplicated_flg = false;
            $n_loop = 0;
            while (true) {
                $coordinates = $this->Coordinates->find(
                    'all',
                    [
                        'order' => 'rand()',
                        'limit' => 1
                    ]
                );

                foreach ($coordinates as $coordinate) {
                    if ($like_coordinate_id == $coordinate->id ||
                        $dislike_coordinate_id == $coordinate->id
                    ) {
                        continue;
                    }
                    echo sprintf(
                        '{"id":%d, "url":"%s", "hasSucceeded":true}',
                        $coordinate->id,
                        $coordinate->photo_path
                    );
                    $duplicated_flg = true;
                }

                if ($duplicated_flg) {
                    break;
                }

                // セーフティブレーク
                if (++$n_loop > 20) {
                    break;
                }
            }
        } else {
            return $this->redirect(['action' => 'battle']);
        }
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
                echo '{"hasSucceeded": false}';
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
            $a_side_coordinate_id = filter_input(INPUT_POST, 'a_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            $b_side_coordinate_id = filter_input(INPUT_POST, 'b_side_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            $like_coordinate_id = filter_input(INPUT_POST, 'liked_coordinate_id', FILTER_SANITIZE_NUMBER_INT);
            if ($a_side_coordinate_id === NULL || $a_side_coordinate_id === false
                || $b_side_coordinate_id === NULL || $b_side_coordinate_id === false
                || $like_coordinate_id === NULL || $like_coordinate_id === false
            ) {
                error_log('Illegal value type');
                echo '{"hasSucceeded": false}';
                exit;
            }

            $a_side_coordinate = $this->Coordinates->find()->where(
                [
                    'Coordinates.id' => $a_side_coordinate_id,
                ]
            )->first();
            $b_side_coordinate = $this->Coordinates->find()->where(
                [
                    'Coordinates.id' => $b_side_coordinate_id,
                ]
            )->first();

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
                $winner = $a_side_point > $b_side_point ? $a_side_coordinate_id : $b_side_coordinate_id;
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
     * JavaScript から呼ばれる関数
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

            self::incrementUserCoordinatePoint($score);

            $this->set(compact('score', 'max_n_battle', 'battle_history', 'score_win'));
        } else {
            return $this->redirect(['action' => 'battle']);
        }
    }

    /**
     * @param int $score
     */
    protected function incrementUserCoordinatePoint($score)
    {
        $UserRegistry = TableRegistry::get('Users');
        $user = $UserRegistry->get($this->Auth->user('id'));
        $user->coordinate_point = is_null($user->coordinate_point) ? 0 : $user->coordinate_point;
        $user->coordinate_point += $score;
        $UserRegistry->save($user);
    }
}
