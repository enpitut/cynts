<?php
$one_digit = (int)substr($rank, -1);
switch ($one_digit) {
    case 1:
        echo '<span class="rank rank_1st">' . $rank . 'st</span>';
        break;
    case 2:
        echo '<span class="rank rank_2nd">' . $rank . 'nd</span>';
        break;
    case 3:
        echo '<span class="rank rank_3rd">' . $rank . 'rd</span>';
        break;
    default:
        echo '<span class="rank">' . $rank . 'th</span>';
        break;
}
