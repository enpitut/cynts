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
