<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('users/login.css') ?>
</head>
<body>
<?= $this->element('eachpage_header') ?>

<div class="align">
    <div class="siteContainer">
        <?php if (!empty($this->request->session()->read('Flash'))): ?>
            <div class="messageBox">
                <label class="fontawesome-remove-sign" for="message error"><span
                        class="hidden">times-circle</span></label>
                <?= $this->Flash->render('flash') ?>
                <?= $this->Flash->render('auth') ?>
            </div>
        <?php endif; ?>
        <div class="loginForm">
            <?= $this->Form->create(
                null,
                ['url' => ['controller' => 'Users', 'action' => 'login']]
            ) ?>
            <div class="formField">
                <label class="fontawesome-user" for="mail"><span
                        class="hidden">Username</span></label>
                <?= $this->Form->text(
                    'mail', [
                        'placeholder' => 'メールアドレス',
                    ]
                ) ?>
            </div>
            <div class="formField">
                <label class="fontawesome-lock" for="password"><span
                        class="hidden">Password</span></label>
                <?= $this->Form->password(
                    'password', [
                        'placeholder' => 'パスワード',
                    ]
                ) ?>
            </div>
            <?= $this->Form->submit('ログイン') ?>
            <?= $this->Form->end() ?>

            <div class="passwordRequestLink">
                <?=
                $this->Html->link(
                    'パスワードを忘れた',
                    array(
                        'controller' => 'users',
                        'action' => '#',
                    )
                );
                ?>
            </div>
            <div class="signupLink">
                <?=
                $this->Html->link(
                    '登録',
                    array(
                        'controller' => 'users',
                        'action' => 'signup',
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
