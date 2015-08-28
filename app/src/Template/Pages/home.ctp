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
<title>
<?= $cakeDescription ?>
</title>
<?= $this->Html->css('base.css') ?>  
</head>

<body class="home">
<div id="topcolumn">

<?= $this->element('header') ?>

<script>
$(function(){
    $('#fader > :gt(0)').hide();
    setInterval(function(){
        $('#fader > :first-child').fadeOut(1000).next().fadeIn(1000).end().appendTo('#fader');}, 5000);
    });
</script>
<div id="title">
<div style="font-size: 64px; margin: 150px 0 25px 0;">Unichronicle</div>
</div>
<div id="fader">
<div>
<div style="font-size: 32px; margin: 0 0 25px 0;">もうダサいなんて言わせない</div>
<br />
<div style="width: 800px;">
何を着ればいいか分からない問題を解決したい、おしゃれしないけど、ダサいのは嫌な大学生向けの服選びの楽しさを理解させ、小奇麗にするオンラインコーディネートバトルサービスです。
</div>
</div>
<div>
<div style="width: 800px;">
ここにコーデバトルの説明文とかが入ります
</div>
</div>
<div>
<div style="width: 800px;">
<img src="https://camo.githubusercontent.com/c635a8cf40b8bf8dacd31e2aca4d0f466caef8b2/68747470733a2f2f692e6779617a6f2e636f6d2f66656663363665616434313262316534353637393738346631653566363663342e706e67" />
</div>
</div>
</div>

</div>

<div id="maincolumn">
<div id="centermenu">
<ul>
<li><?= $this->Html->image('view/menu1.png', array('height' => '160px')) ?><br />好きなコーディネートを選ぶ</li>
<li><?= $this->Html->image('view/menu2.png', array('height' => '160px')) ?><br />コーディネートランキングを見る</li>
<li><?= $this->Html->image('view/menu3.png', array('height' => '160px')) ?><br />オリジナルコーディネートを投稿する</li>
</ul>
</div>

<?= $this->element('footer') ?>

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
