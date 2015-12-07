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

    const CATEGORY_T_SHIRT = 1;
    const CATEGORY_SHIRT = 2;
    const CATEGORY_PANTS = 3;
    const CATEGORY_JACKET = 4;
    const CATEGORY_SHOES = 5;
    const CATEGORY_SKIRT = 6;
    const CATEGORY_CARDIGAN = 7;

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
            Item::SEX_MAN => '男',
            Item::SEX_WOMAN => '女',
        ];
    }

    /**
     * @return array
     */
    public static function getCategories()
    {
        return [
            Item::CATEGORY_T_SHIRT => 'Tシャツ',
            Item::CATEGORY_SHIRT => 'シャツ',
            Item::CATEGORY_PANTS => 'パンツ',
            Item::CATEGORY_JACKET => 'ジャケット',
            Item::CATEGORY_SHOES => 'シューズ',
            Item::CATEGORY_SKIRT => 'スカート',
            Item::CATEGORY_CARDIGAN => 'カーデイガン',
        ];
    }

    /**
     * @return array
     */
    public static function getColors()
    {
        return [
            Item::COLOR_WHITE => '白',
            Item::COLOR_BLACK => '黒',
            Item::COLOR_RED => '赤',
            Item::COLOR_ORANGE => 'オレンジ',
            Item::COLOR_DARK_GREEN => '深緑',
            Item::COLOR_BLUE => '青',
            Item::COLOR_NAVY => '濃青',
            Item::COLOR_GRAY => 'グレー',
            Item::COLOR_BROWN => '茶',
            Item::COLOR_GREEN => '緑',
            Item::COLOR_PINK => 'ピンク',
            Item::COLOR_BEIGE => '灰黄',
            Item::COLOR_YELLOW => '黄色',
            Item::COLOR_OLIVE => '薄緑',
            Item::COLOR_OFF_WHITE => 'クリーム',
            Item::COLOR_WINE => 'ワイン',
        ];
    }
}
