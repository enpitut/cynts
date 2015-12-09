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

        <div id="help_button">
            <a id="modal_open">
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
<?php


?>

<?= $this->Html->script('help.js', [
    'id' => 'help_script',
    'controller' => $page_data["controller"],
    'action' => $page_data["action"],
    'isVisited' => $this->request->session()->read("Visit.".$page_data["page"])
]) ?>
