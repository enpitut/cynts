<html>
<head>
    <?= $this->Html->css('users/signup.css') ?>
    <?= $this->element('eachpage_header') ?>
</head>
<body>

<div class="big">Unichronicle へようこそ</div>
<p> アカウントを作成する</p>

<?= $this->Form->create($user, ['novalidate' => true]) ?>
<table border="0" align="center">
    <tr valign="baseline">
        <td>ユーザ名:</td>
        <td>
            <?= $this->Form->input(
                'name',
                ['label' => false]
            ) ?>
        </td>
    </tr>

    <tr valign="baseline">
        <td>メールアドレス:</td>
        <td>
            <?= $this->Form->input(
                'mail',
                ['label' => false]
            ) ?>
        </td>
    </tr>

    <tr valign="baseline">
        <td>パスワード:</td>
        <td>
            <?= $this->Form->input(
                'password',
                [
                    'label' => false,
                    'type' => 'password',
                ]
            ) ?>
        </td>
    </tr>

    <tr valign="baseline">
        <td>パスワード（確認）:</td>
        <td>
            <?= $this->Form->input(
                'retype_password',
                [
                    'label' => false,
                    'type' => 'password',
                ]
            ) ?>
        </td>
    </tr>
</table>

<p>
    <?php
    echo $this->Form->button('登録',
        [
            'type' => 'submit',
        ]);
    ?>
</p>

<?= $this->Form->end() ?>

アカウントをお持ちの方は<a href="/users/login">こちら</a>．

</body>
</html>
