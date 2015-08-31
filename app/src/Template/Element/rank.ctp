<?php
$one_digit = (int)substr($rank, -1);
switch ($one_digit) {
    case 1:
        $class = 'rank';
        if ($rank === 1) {
            $class = 'rank rank_1st';
        }
        echo "<span class='$class'>" . $rank . 'st</span>';
        break;
    case 2:
        $class = 'rank';
        if ($rank === 2) {
            $class = 'rank rank_2nd';
        }
        echo "<span class='$class'>" . $rank . 'nd</span>';
        break;
    case 3:
        $class = 'rank';
        if ($rank === 3) {
            $class = 'rank rank_3rd';
        }
        echo "<span class='$class'>" . $rank . 'rd</span>';
        break;
    default:
        echo '<span class="rank">' . $rank . 'th</span>';
        break;
}
