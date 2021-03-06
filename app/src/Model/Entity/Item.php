<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity.
 */
class Item extends Entity
{
    const ITEM_PHOTO_DIRECTORY_ROOT = 'items/';

    const SEX_MAN = 0;
    const SEX_WOMAN = 1;
    const SEX_UNISEX = 2;  // Union of man and woman

    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;
    const COLOR_RED = 3;
    const COLOR_ORANGE = 4;
    const COLOR_DARK_GREEN = 5;
    const COLOR_BLUE = 6;
    const COLOR_NAVY = 7;
    const COLOR_GRAY = 8;
    const COLOR_BROWN = 9;
    const COLOR_GREEN = 10;
    const COLOR_PINK = 11;
    const COLOR_BEIGE = 12;
    const COLOR_YELLOW = 13;
    const COLOR_OLIVE = 14;
    const COLOR_OFF_WHITE = 15;
    const COLOR_WINE = 16;
    const COLOR_DARK_GRAY = 17;
    const COLOR_LIGHT_BLUE = 18;
    const COLOR_LIGHT_GRAY = 19;
    const COLOR_NATURAL = 20;
    const COLOR_KHAKI = 21;
    const COLOR_PURPLE = 22;

    const CATEGORY_T_SHIRT = 1;
    const CATEGORY_SHIRT = 2;
    const CATEGORY_PANTS = 3;
    const CATEGORY_JACKET = 4;
    const CATEGORY_SHOES = 5;
    const CATEGORY_SKIRT = 6;
    const CATEGORY_CARDIGAN = 7;
    const CATEGORY_SWEATER = 8;

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

    /**
     * 定数としては Item::SEX_UNISEX も存在するが，このリストは検索条件であるため，ここには含めない
     *
     * @return array
     */
    public static function getSexes()
    {
        return [
            Item::SEX_MAN => 'men',
            Item::SEX_WOMAN => 'women',
        ];
    }

    /**
     * @return array
     */
    public static function getCategories()
    {
        return [
            Item::CATEGORY_T_SHIRT => 'T-shirt',
            Item::CATEGORY_SHIRT => 'Shirt',
            Item::CATEGORY_PANTS => 'Pants',
            Item::CATEGORY_JACKET => 'Jacket',
            Item::CATEGORY_SHOES => 'Shoes',
            Item::CATEGORY_SKIRT => 'Skirt',
            Item::CATEGORY_CARDIGAN => 'Cardigan',
            Item::CATEGORY_SWEATER => 'Sweater',
        ];
    }

    /**
     * @return array
     */
    public static function getColors()
    {
        return [
            Item::COLOR_WHITE => 'WHITE',
            Item::COLOR_BLACK => 'BLACK',
            Item::COLOR_RED => 'RED',
            Item::COLOR_ORANGE => 'ORANGE',
            Item::COLOR_DARK_GREEN => 'DARK_GREEN',
            Item::COLOR_BLUE => 'BLUE',
            Item::COLOR_NAVY => 'NAVY',
            Item::COLOR_GRAY => 'GRAY',
            Item::COLOR_BROWN => 'BROWN',
            Item::COLOR_GREEN => 'GREEN',
            Item::COLOR_PINK => 'PINK',
            Item::COLOR_BEIGE => 'BEIGE',
            Item::COLOR_YELLOW => 'YELLOW',
            Item::COLOR_OLIVE => 'OLIVE',
            Item::COLOR_OFF_WHITE => 'OFF_WHITE',
            Item::COLOR_WINE => 'WINE',
            Item::COLOR_DARK_GRAY => 'DARK_GRAY',
            Item::COLOR_LIGHT_BLUE => 'LIGHT_BLUE',
            Item::COLOR_LIGHT_GRAY => 'LIGHT_GRAY',
            Item::COLOR_NATURAL => 'NATURAL',
            Item::COLOR_KHAKI  => 'KHAKI',
            Item::COLOR_PURPLE  => 'PURPLE',
        ];
    }
}
