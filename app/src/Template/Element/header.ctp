<header>
    <?= $this->Html->css('header.css') ?>
    <?= $this->Html->css('help.css') ?>
    <div id="header">
        <ul>
            <li>
                <?=
                $this->Html->link(
                    'Play',
                    array(
                        'controller' => 'CoordinatesBattle',
                        'action' => 'battle',
                    )
                );
                ?>
            </li>
            <li>
                <?=
                $this->Html->link(
                    'Ranking',
                    array(
                        'controller' => 'Rankings',
                        'action' => 'view',
                    )
                );
                ?>
            </li>
            <li>
                <?=
                $this->Html->link(
                    'Post',
                    array(
                        'controller' => 'Coordinates',
                        'action' => 'create',
                    )
                );
                ?>
            </li>
            <li>
                <a id="modal_open">Help</a>
            </li>
        </ul>
    </div>
    <?php
    if (!in_array($this->request->here, ['/users/signup'])) {
        echo $this->element('login');
    }
    ?>
    <?= $this->Html->script('help.js', ['id' => 'help_script', 'controller' => $this->name, 'action' => $this->request->action]) ?>
</header>
