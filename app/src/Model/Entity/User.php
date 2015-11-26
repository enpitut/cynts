<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity
{
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
     * coordinte_point は普通に10回やると1000点くらい取れるイメージで
     * / 10000 は log の収束を遅める働き
     * + 1 は 0 の時に負の無限大を取るグラフを上に移動する働き
     * * 25 は雰囲気で決めた
     *
     * かなりテキトーに決めたので，誰かいい関数考えて欲しい
     *
     * i.e.
     * point : score
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
     */
    public function getCoordinateLevel()
    {
        return floor(log($this->_properties['coordinate_point'] / 10000 + 1) * 25);
    }
}
