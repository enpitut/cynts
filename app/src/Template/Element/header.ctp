<header>
    <div id="headerLoginForm">
        <?php if ((($this->request->here === '/pages/home')
            || ($this->request->here === '/')
        )
        ): ?>
            <?php if (!($this->request->session()->read('Auth.User'))): ?>
                <?= $this->Form->create(
                    null,
                    ['url' => ['controller' => 'Users', 'action' => 'login']]
                ) ?>
                <?= $this->Form->text(
                    'mail', [
                        'class' => 'mailForm', 'placeholder' => 'メールアドレス',
                    ]
                ) ?>
                <?= $this->Form->password(
                    'password', [
                        'class' => 'passwordForm', 'placeholder' => 'パスワード',
                    ]
                ) ?>
                <?= $this->Form->submit(
                    'ログイン', [
                        'class' => 'loginButton',
                    ]
                ) ?>
            <?php else: ?>
                <?= $this->Form->create(
                    null,
                    ['url' => ['controller' => 'Users', 'action' => 'logout']]
                ) ?>
                <?= $this->Form->button(
                    'ログアウト', ['class' => 'logoutButton']
                ) ?>
                <?= $this->Form->end() ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div id="header">
        <ul>
            <?php if ($this->Session->read('Auth.User')): ?>
                <li>
                    <?=
                    $this->Html->link(
                        'User',
                        array(
                            'controller' => 'Users',
                            'action' => 'view',
                            $this->Session->read('Auth.User.id')
                        )
                    );
                    ?>
                </li>
            <?php elseif (($this->request->here !== '/pages/home')
                && ($this->request->here !== '/')
            ): ?>
                <li>
                    <?=
                    $this->Html->link(
                        'Login',
                        array(
                            'controller' => 'Users',
                            'action' => 'login',
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
