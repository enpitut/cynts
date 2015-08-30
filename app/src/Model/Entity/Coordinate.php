<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coordinate Entity.
 */
class Coordinate extends Entity
{
    const COORDINATES_DIRECTORY_ROOT = "coordinates/";
//    const ITEM_ORDER = ['tops', 'outer', 'bottoms', 'shoes'];
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
    
    function cmp($a, $b) {
        if ($a[1] == $b[1]) return 0;
        return ($a[1] < $b[1]) ? -1 : 1;
    }

    public function sortCategory($coordinate){
        foreach ($coordinate->items as $items) {
            $category = $items->category;
        }
        
        $sortedItems = array_multisort($category, $coordinate->items);
        return $sortedItems;
    }
}
