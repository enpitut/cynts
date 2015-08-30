<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shop Entity.
 */
class Shop extends Entity
{
    const SHOP_PHOTO_DIRECTORY_ROOT = 'shops/';

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
     * @return string[]
     */
    protected function _getPhotoPaths()
    {
        $photos = json_decode($this->_properties['photos']);
        $photo_paths = [];
        foreach ($photos as $photo) {
            $photo_paths[] = self::SHOP_PHOTO_DIRECTORY_ROOT . $photo;
        }
        return $photo_paths;
    }
}
