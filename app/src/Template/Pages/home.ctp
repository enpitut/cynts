<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$cakeDescription = 'Unichronicle もうダサいなんて言わせない';
?>
<!DOCTYPE html>
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <?= $this->Html->charset() ?>
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('header.css') ?>
</head>
<body class="home">
<script>
    (function ($) {
        $(function () {
            $('#centerMenu ul li').hover(function () {
                $('#fader li:nth-child(' + 1 + ')').stop(true, true).fadeOut("fast");
                var menuNumber = $('#centerMenu ul li').index(this);
                var showCaption = menuNumber + 2;
                $('#fader li:nth-child(' + showCaption + ')').stop(true, true).fadeIn("normal");
            }, function () {
                var menuNumber = $('#centerMenu ul li').index(this);
                var showCaption = menuNumber + 2;
                $('#fader li:nth-child(' + showCaption + ')').stop(true, true).fadeOut("fast");
                $('#fader li:nth-child(' + 1 + ')').stop(true, true).fadeIn("normal");
            })
        });
    })(jQuery);
</script>
<div id="topColumn">
    <?= $this->element('header') ?>
    <div id="title">
        Unichronicle
    </div>
    <div id="fader">
        <li class="homeCaption">
            <div class="homeCaptionTitle">
                もうダサいなんて言わせない
            </div>
            <div class="homeCaptionDescription">
                今の自分より少しだけおしゃれに。
                <br>
                ゲーム感覚でおしゃれを知ろう。
            </div>
            <br>
        </li>
        <li class="battleCaption">
            <img src="/img/view/description1.png" width="45%"
                 style="float:left; margin: 0 30px 0 0">
            2択で自分の好きなコーディネートを選ぶだけ。
            <br>
            ゲームをしながら色々なコーディネートが見れる。
        </li>
        <li class="rankingCaption">
            初めて来た人はまずコーディネートランキングへ。
            <br>
            ランキング1位はみんなが好きなコーディネート。
            <br>
            服をあまり買ったことない人は、ランキング1位の服をまとめ買い。
        </li>
        <li class="postCaption">
            自分が組み合わせたコーディネートを勝ち抜きバトルにエントリー。
            <br>
            みんなが好きになるコーディネートを作ってみよう。
            <br>
            <br>
            組み合わせは無限大。
        </li>
    </div>
</div>

<div id="mainColumn">
    <div id="centerMenu">
        <ul>
            <li>
                <?= $this->Html->image(
                    'view/menu1.png', array(
                        'height' => '160px', 'url' => array(
                            'controller' => 'CoordinatesBattle',
                            'action' => 'battle'
                        )
                    )
                ) ?>
                <br>
                好きなコーディネートを選ぶ
            </li>
            <li>
                <?= $this->Html->image(
                    'view/menu2.png', array(
                        'height' => '160px', 'url' => array(
                            'controller' => 'Rankings', 'action' => 'view'
                        )
                    )
                ) ?>
                <br>
                コーディネートランキングを見る
            </li>
            <li>
                <?= $this->Html->image(
                    'view/menu3.png', array(
                        'height' => '160px', 'url' => array(
                            'controller' => 'Coordinates', 'action' => 'create'
                        )
                    )
                ) ?>
                <br>
                オリジナルコーディネートを投稿する
            </li>
        </ul>
    </div>

    <?= $this->element('footer') ?>

    <script>
        var fitTopColumn = function () {
            var topColumn = $('#topColumn');
            var fader = $('#fader');
            topColumn.height(topColumn.width() / 1440.0 * 564);
            fader.height(fader.width() * 0.4);
        };

        var timer = false;

        $(window).resize(function () {
            if (timer !== false) {
                clearTimeout(timer);
            }
            timer = setTimeout(function () {
                fitTopColumn();
            }, 100);
        });

        fitTopColumn();
    </script>

</body>
</html>
