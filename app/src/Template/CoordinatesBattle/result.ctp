<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<br>

<div id="centerposition">
    <p>あなたのおしゃれ度は...</p>
    <?php
    echo "<p><span class='result_score'>" . floor((100 * $score) / ($max_n_battle * $score_win)) . "</span><span class='max_score'> / 100</span></p>";
    ?>
    <?= "<p>コーディネートレベル : <span class='level'>$current_level</span></p>" ?>
    <?= "<p class='info'>次のレベルまで $point_to_next_level pt</p>" ?>
    <?php if ($previous_level !== $current_level): ?>
        <p class='info'>コーディネートレベルが上がりました!</p>
    <?php endif ?>
</div>

<ul class="battle_result">
    <?php
    foreach ($battle_history as $battle_result) {
        $selected = $battle_result->{"selected_side"} === "a" ? "a" : "b";
        $unselected = $selected === "a" ? "b" : "a";

        $a_side_coordinate_class
            = $b_side_coordinate_class = "result_coordinate_photo";
        ${$selected . "_side_coordinate_class"} .= " selected_coordinate_photo";

        // 1: 良いコーデを選択した
        // 0: 悪いコーデを選択した
        // -1: 引き分け
        if ($battle_result->{"result"} === 1) {
            ${$selected . "_side_p_class"} = "win_coordinate_string";
            ${$unselected . "_side_p_class"} = "loose_coordinate_string";
        } else {
            if ($battle_result->{"result"} === 0) {
                ${$selected . "_side_p_class"} = "loose_coordinate_string";
                ${$unselected . "_side_p_class"} = "win_coordinate_string";
            } else {
                $a_side_p_class = $b_side_p_class = "draw_coordinate_string";
            }
        }

        echo "<li>";
        $a_side_coordinate_image = $this->Html->image(
            $battle_result->{"a_side_coordinate_photo_path"},
            [
                'class' => $a_side_coordinate_class
            ]
        );
        echo $this->Html->link(
            $a_side_coordinate_image,
            [
                'controller' => 'Coordinates',
                'action' => 'view',
                $battle_result->{"a_side_coordinate_id"}
            ],
            [
                'target' => '_blank',
                'escape' => false
            ]
        );
        echo sprintf(
            '<p class="each_actual_point %s">point : %d</p>',
            $a_side_p_class, $battle_result->{"a_side_coordinate_point"}
        );
        echo "</li>";

        echo "<li>";
        $b_side_coordinate_image = $this->Html->image(
            $battle_result->{"b_side_coordinate_photo_path"},
            [
                'class' => $b_side_coordinate_class
            ]
        );
        echo $this->Html->link(
            $b_side_coordinate_image,
            [
                'controller' => 'Coordinates',
                'action' => 'view',
                $battle_result->{"b_side_coordinate_id"}
            ],
            [
                'target' => '_blank',
                'escape' => false
            ]
        );
        echo sprintf(
            '<p class="each_actual_point %s">point : %d</p>',
            $b_side_p_class, $battle_result->{"b_side_coordinate_point"}
        );
        echo "</li>";

        echo "<br>";
    }
    ?>
</ul>

<?= $this->element('footer') ?>

</body>
</html>
