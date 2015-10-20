<header>
    <div id="header">
        <ul>
            <?php if ($this->request->session()->read('Auth.User')): ?>
                <li>
                    <?=
                    $this->Html->link(
                        'User',
                        array(
                            'controller' => 'Users',
                            'action' => 'view',
                            $this->request->session()->read('Auth.User.id')
                        )
                    );
                    ?>
                </li>
            <?php endif; ?>
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
        </ul>
    </div>
</header>
