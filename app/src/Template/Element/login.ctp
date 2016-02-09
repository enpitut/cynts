<div class="accountNavigation">
    <div class="navigation">
        <?php if (!($this->request->session()->read('Auth.User'))): ?>
            <a href="#" id="headerLoginForm">
                ログイン
            </a>
            |
            <?=
            $this->Html->link(
                '新規登録', [
                    'controller' => 'Users',
                    'action' => 'signup',
                ]
            );
            ?>
        <?php else: ?>
            <?= $this->Html->link(
                $this->request->session()->read('Auth.User.name'),
                [
                    'controller' => 'Users',
                    'action' => 'view',
                    $this->request->session()->read('Auth.User.id')
                ]
            ) ?>
            さん |
            <?= $this->Html->link(
                'ログアウト', [
                    'controller' => 'Users',
                    'action' => 'logout',
                ]
            ) ?>
        <?php endif; ?>
    </div>
</div>
<div class="loginWindow">
    <div class="formHolder">
        <?php if (!($this->request->session()->read('Auth.User'))): ?>
            <?= $this->Form->create(
                null,
                [
                    'url' => [
                        'controller' => 'Users', 'action' => 'login'
                    ]
                ]
            ) ?>
            <?= $this->Form->text(
                'mail', ['placeholder' => 'メールアドレス']
            ) ?>
            <?= $this->Form->password(
                'password', ['placeholder' => 'パスワード']
            ) ?>
            <?= $this->Form->submit(
                'ログイン'
            ) ?>
        <?php else: ?>
            <?= $this->Form->create(
                null,
                [
                    'url' => [
                        'controller' => 'Users', 'action' => 'logout'
                    ]
                ]
            ) ?>
            <?= $this->Form->button(
                'ログアウト', ['class' => 'logoutButton']
            ) ?>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->Html->script('headerLogin.js') ?>
