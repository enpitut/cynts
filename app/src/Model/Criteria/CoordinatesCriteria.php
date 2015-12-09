<?php
namespace App\Model\Criteria;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Item;

/**
 * Class CoordinatesCriteria
 * @package App\Model\Criteria
 */
class CoordinatesCriteria {
    /**
     * 条件にあったコーデ群を取得するクエリを生成する
     * 条件は JSON 形式で指定する
     *
     * @param string $criteria_string
     * @param $options
     *
     * @return \Cake\ORM\Query $query
     */
    public static function createQueryFromJson(
        $criteria_string,
        $options = ['contain' => ['Users', 'Items', 'Favorites']]
    )
    {
        if ($criteria_string === "{}") {
            return $query = TableRegistry::get('Coordinates')->find(
                'all',
                $options
            );
        }

        $criteria_json = json_decode($criteria_string, true);

        /**
         * Coordinates に Coordinates_items と Items を内部結合して，
         * coordinate_id でまとめる
         *
         * 条件に合わせて，どのようにまとめるかを having 句として記述していく
         *
         * SQL:
         * SELECT * FROM Coordinates
         *   INNER JOIN coordinates_items ON coordinates.id = coordinates_items.coordinate_id
         *   INNER JOIN items ON coordinates_items.item_id = items.id
         *   GROUP BY coordinate_id
         *   HAVING ( hoge AND fuga AND ...) // hoge や fuga を以下で追記し，絞り込んでいく
         */
        $query = TableRegistry::get('Coordinates')->find(
            'all',
            $options
        )
            ->innerJoin(
                'coordinates_items',
                'Coordinates.id = coordinates_items.coordinate_id'
            )
            ->innerJoin('items', 'coordinates_items.item_id = items.id')
            ->group(['coordinate_id']);
        $having_conditions = [];

        if (array_key_exists('price', $criteria_json)) {
            array_push(
                $having_conditions,
                CoordinatesCriteria::_createQueryMatchPriceCriteria($criteria_json["price"])
            );
        }

        if (array_key_exists('sex', $criteria_json)) {
            array_push(
                $having_conditions,
                CoordinatesCriteria::_createQueryMatchSexCriteria($criteria_json["sex"])
            );
        }

        if (array_key_exists('season', $criteria_json)) {
            array_push(
                $having_conditions,
                CoordinatesCriteria::_createQueryMatchSeasonCriteria($criteria_json["season"])
            );
        }

        $query->having($having_conditions);

        return $query;
    }

    /**
     * Coordinates の sex が条件に沿ったものをまとめる
     *
     * SQL:
     *   Coordinates.sex = :c0
     *   - :c0 0もしくは1
     *
     * @param string $sex_criteria 0 または 1
     *
     * @return \Cake\ORM\Query $query
     */
    private static function _createQueryMatchSexCriteria($sex_criteria)
    {
        if ((int)$sex_criteria === Item::SEX_MAN) {
            $criteria_query = TableRegistry::get('Coordinates')->find()->newExpr()->eq(
                'Coordinates.sex',
                Item::SEX_MAN
            );
        } else {
            $criteria_query = TableRegistry::get('Coordinates')->find()->newExpr()->eq(
                'Coordinates.sex',
                Item::SEX_WOMAN
            );
        }
        return $criteria_query;
    }

    /**
     * Coordinates に関わる Items の合計金額が，
     * 条件範囲内のものをグループとしてまとめる
     *
     * SQL:
     *   SUM(Items.price) BETWEEN :c0 AND :c1
     *   - :c0 最小価格
     *   - :c1 最大価格
     *
     * @param string $price_criteria 形式は "最小価格,最大価格"
     *
     * @return \Cake\ORM\Query $criteria_query
     */
    private static function _createQueryMatchPriceCriteria($price_criteria)
    {
        $price_scopes = explode(',', $price_criteria);
        $criteria_query = TableRegistry::get('Coordinates')->find()->newExpr()->between(
            TableRegistry::get('Coordinates')->find()->func()->sum('items.price'),
            $price_scopes[0],
            $price_scopes[1]
        );
        return $criteria_query;
    }

    /**
     * coordinates.season は 4bit の bit 列を string 型で保存している．
     * MySQL の仕様で，bitwise and 演算子は入力を10進数として，その論理積を取る．
     * coordinates.season に保存されている値と，この関数で生成する $expression は2進数であるため，
     * MySQL の CONV 関数で2進数から10進数に変換している．
     *
     * また，cake の ORM が bitwise and 演算子をサポートしていないため，クエリをベタ書きしている．
     * $expression はここで生成された値であるため，ユーザーが任意のクエリを発行できるわけではないが，要注意．
     *
     * @param string $season_criteria 形式は4bitのビット列  例) "1010"
     * @return \Cake\ORM\Query $criteria_query
     */
    private static function _createQueryMatchSeasonCriteria($season_criteria)
    {
        $expression = '';
        foreach (str_split($season_criteria) as $season_flag) {
            $expression .= $season_flag === '1' ? '1' : '0';
        }

        $criteria_query = TableRegistry::get('Coordinates')->find()->newExpr()
            ->add(
                ["CONV(Coordinates.season, 2, 10) & CONV($expression, 2, 10)"]
            );
        return $criteria_query;
    }
}

