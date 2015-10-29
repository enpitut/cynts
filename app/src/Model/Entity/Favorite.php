<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Favorite Entity.
 */
class Favorite extends Entity
{

    // const FAVORITE_PHOTO_DIRECTORY_ROOT = 'favorite/';

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
    // protected function _getPhotoPath()
    // {
    //     return self::FAVORITE_PHOTO_DIRECTORY_ROOT . $this->_properties['photo'];
    // }
}
