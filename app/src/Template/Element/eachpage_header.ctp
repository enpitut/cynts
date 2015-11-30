<div id="header_back">
    <div id="header_title">
        <?= $this->Html->css('header.css') ?>
        <?= $this->Html->css('chardinjs.css') ?>
        <?=
        $this->Html->link(
            'Unichronicle',
            array(
                'controller' => 'Pages',
                'action' => 'home',
            )
        );
        ?>

        <div id="help_button">
            <a href="#" data-toggle="chardinjs">
                <label class="fontawesome-question-sign" for="help"></label>
            </a>
        </div>
    </div>
    <?php
    if (!in_array($this->request->here, ['/users/login'])) {
        echo $this->element('header');
    }
    ?>
</div>
<?= $this->Html->script('chardinjs.min.js') ?>
<?= $this->Html->script('help.js', ['id' => 'help_script', 'controller' => $this->name, 'action' => $this->request->action]) ?>

