<div style="width: 100%; height: 100px; margin: 0 auto; background-image: url('/img/view/header.png');">
<?= $this->Html->image('/img/view/header.png'); ?>
<div id="header_title">
  <?=
  $this->Html->link(
      'Unichronicle',
      array('controller' => 'pages',
            'action' => 'home',
      )
  );
  ?>
</div>
<?= $this->element('header') ?>
</div>
