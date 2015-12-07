<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity
{
    const LEVEL_METHOD_DIV = 10000;
    const LEVEL_METHOD_PLUS = 1;
    const LEVEL_METHOD_MULTI = 25;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Note that '*' is set to true, which allows all unspecified fields to be
     * mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * @param $password
     * @return bool|string
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * 普通に10回バトルすると coordinate_point 1000点くらい取れるイメージで
     * / 10000 は log の収束を遅める働き
     * + 1 は x = 1 の時に y = 0 を取るグラフを左に平行移動する働き : つまり (0, 0) を通る
     * * 25 は雰囲気で決めた
     *
     * かなりテキトーに決めたので，誰かいい関数考えて欲しい
     *
     * i.e.
     * point : level
     * 0 : 0
     * 1000 : 1
     * 2200 : 2
     * 3200 : 3
     * 4700 : 4
     * ...
     * 10000 : 7
     * 20000 : 12
     *
     * @see https://goo.gl/mXUJRz google graph
     *
     * @return float
     * @throws \Exception
     */
    public function getCoordinateLevel()
    {
        if (($this->_properties['coordinate_point'] <=> 0) === -1) {
            throw new \Exception('Invalid coordinate_point');
        }
        return floor(
            log(
                $this->_properties['coordinate_point'] / self::LEVEL_METHOD_DIV + self::LEVEL_METHOD_PLUS
            ) * self::LEVEL_METHOD_MULTI
        );
    }

    /**
     * @see \App\Model\Entity\User::getCoordinateLevel
     *
     * @return float
     */
    public function getPointToNextLevel()
    {
        $current_level = self::getCoordinateLevel();
        $min_point_of_next_level = (
                exp(
                    ($current_level + 1) / self::LEVEL_METHOD_MULTI
                ) - self::LEVEL_METHOD_PLUS
            ) * self::LEVEL_METHOD_DIV;
        return floor($min_point_of_next_level - $this->_properties['coordinate_point']);
    }
}
