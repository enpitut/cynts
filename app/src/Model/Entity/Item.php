<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity.
 */
class Item extends Entity
{
    const ITEM_PHOTO_DIRECTORY_ROOT = 'items/';

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
        if (is_null($photos)) {
            $photos = [];
        }
        $photo_paths = [];
        foreach ($photos as $photo) {
            $photo_paths[] = self::ITEM_PHOTO_DIRECTORY_ROOT . $photo;
        }
        return $photo_paths;
    }

    /**
     * @return string[]
     */
    protected function _getSizeArray()
    {
        return json_decode($this->_properties['sizes']);
    }
}
