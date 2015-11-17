<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Coordinate Entity.
 */
class Coordinate extends Entity
{

    const COORDINATE_PHOTO_DIRECTORY_ROOT = 'coordinates/';

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
     * @return string
     */
    protected function _getPhotoPath()
    {
        return self::COORDINATE_PHOTO_DIRECTORY_ROOT . $this->_properties['photo'];
    }

    protected function _getPrice()
    {
        // もっとうまい持ってき方があるかも...?
        $coordinate_id = $this->_properties['id'];
        $coordinate_table = TableRegistry::get('Coordinates');
        $coordinate = $coordinate_table->get($coordinate_id, [
                'contain' => ['Items']
            ]
        );

        $coordinate_price = 0;
        foreach($coordinate->items as $item) {
            $coordinate_price += (int)$item->price;
        }
        return $coordinate_price;
    }

    /**
     * @return int
     */
    protected function _getSex()
    {
        $coordinate_id = $this->_properties['id'];
        $coordinate_table = TableRegistry::get('Coordinates');
        $coordinate = $coordinate_table->get($coordinate_id, [
                'contain' => ['Items']
            ]
        );

        // 女性物の Item が多ければ女性，男性物が多ければ男性と判断する
        // TODO: 本当は，投稿時に女性 or 男性を選択できるようにした方が良い
        $sexes_weight = [];
        foreach($coordinate->items as $item) {
            $sexes_weight[$item->sex]++;
        }
        return array_search(max($sexes_weight), $sexes_weight);
    }
}
