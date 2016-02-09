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

    <script>
    var help_button = ' <div id="help_button">'
        + '<a id="modal_open">'
        + '<label class="fontawesome-question-sign" for="help"></label>'
        + '</a>'
        + '</div>';
    </script>
    
    <?php
    if (!in_array($this->request->here, ['/users/login'])) {
        echo $this->element('header');
    }
    ?>
</div>
<?php
    $page_data = [];
    $page_data["controller"] = is_null($this->name) ? "pages": $this->name;
    $page_data["action"] = is_null($this->request->action) ? "home" : $this->request->action;
    $page_data["page"] = strtolower($page_data["controller"])."_".strtolower($page_data["action"]);
?>

<?= $this->Html->script('help.js', [
    'id' => 'help_script',
    'controller' => $page_data["controller"],
    'action' => $page_data["action"],
    'isVisited' => $this->request->session()->read("Visited.".$page_data["page"])
]) ?>
