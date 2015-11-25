<div
    style="width: 100%; height: 100px; margin: 0 auto; background-image: url('/img/view/header.png');">
    <div id="header_title">
        <?= $this->Html->css('header.css') ?>
        <?=
        $this->Html->link(
            'Unichronicle',
            array(
                'controller' => 'pages',
                'action' => 'home',
            )
        );
        ?>
    </div>
    <?php
    if (!in_array($this->request->here, ['/users/login'])) {
        echo $this->element('header');
    }
    ?>
</div>
