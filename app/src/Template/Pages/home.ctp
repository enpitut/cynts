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
        <?= $this -> Html -> charset() ?>
        <title><?= $cakeDescription ?></title>
        <?= $this -> Html -> css('base.css') ?>
    </head>
    <body class="home">
            <script>
              /*
               $(function(){
               $('#fader > :gt(0)').hide();
               setInterval(function(){
               $('#fader > :first-child').fadeOut(1000).next().fadeIn(1000).end().appendTo('#fader');}, 5000);
               });
               */
              (function($) {
                $(function() {
                  $('#centermenu ul li').hover(function() {
                    var menuNumber = $('#centermenu ul li').index(this);
                    var showCaption = menuNumber + 1;
                    if (showCaption !== 2)
                      $('#fader li:nth-child(' + 2 + ')').stop(true, true).fadeOut("fast")
                    $('#fader li:nth-child(' + showCaption + ')').stop(true, true).fadeIn("normal")
                  }, function() {
                    var menuNumber = $('#centermenu ul li').index(this);
                    var showCaption = menuNumber + 1;
                    $('#fader li:nth-child(' + showCaption + ')').stop(true, true).fadeOut("fast")
                  })
                });
              })(jQuery);
            </script>
        <div id="topcolumn">
            <?= $this -> element('header') ?>
            <div id="title">
                Unichronicle
            </div>
            <div id="fader">
                <li class="battleCaption">
                    <img src="/img/view/description1.png" width="45%" style="float:left; margin: 0 30px 0 0">
                    2択で自分の好きなコーディネートを選ぶだけ！
                    <br>
                    ゲームをしながら色々なコーディネートが見れる！
                </li>
                <li class="rankingCaption">
                    初めて来た人はまずコーディネートランキングへ。
                    <br>
                    ランキング1位はみんなが好きなコーディネート。
                    <br>
                    服をあまり買ったことない人は、ランキング1位の服をまとめて買っちゃおう！
                </li>
                <li class="postCaption">
                    自分が組み合わせたコーディネートを勝ち抜きバトルにエントリー！
                    <br>
                    みんなが好きになるコーディネートを作ってみよう。
                    <br>
                    <br>
                    組み合わせは無限大！
                </li>
            </div>
        </div>

        <div id="maincolumn">
            <div id="centermenu">
                <ul>
                    <li>
                        <?= $this -> Html -> image('view/menu1.png', array('height' => '160px', 'url' => array('controller' => 'coordinates', 'action' => 'battle'))) ?>
                        <br>
                        好きなコーディネートを選ぶ
                    </li>
                    <li>
                        <?= $this -> Html -> image('view/menu2.png', array('height' => '160px', 'url' => array('controller' => 'rankings', 'action' => 'view'))) ?>
                        <br>
                        コーディネートランキングを見る
                    </li>
                    <li>
                        <?= $this -> Html -> image('view/menu3.png', array('height' => '160px', )) ?>
                        <br>
                        オリジナルコーディネートを投稿する
                    </li>
                </ul>
            </div>

            <?= $this -> element('footer') ?>

            <script>
        var fit_topcolumn = function() {
          var topcolumn = $('#topcolumn');
          var fader = $('#fader');
          topcolumn.height(topcolumn.width() / 1440.0 * 564);
          fader.height(fader.width() * 0.4);
        };

        var timer = false;

        $(window).resize(function() {
          if (timer !== false) {
            clearTimeout(timer);
          }
          timer = setTimeout(function() {
            fit_topcolumn();
          }, 100);
        });

        fit_topcolumn();
            </script>

    </body>
</html>
