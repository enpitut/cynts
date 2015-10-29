<html>

<head>

<?= $this->Html->css('users/signup.css') ?>
<?= $this->element('eachpage_header') ?>

<?php
use \App\Model\Table\UsersTable
?>

</head>


<body>

<div class="big"> Unichronicle へようこそ </div>
<p> アカウントを作成する <p>
<table border="0" align="center">
<tr></tr>

<?= $this->Form->create($user, array('novalidate'=>'novalidate')) ?>

<tr><td>

<tr valign="baseline"><td>ユーザ名:</td>
<td><?= $this->Form->input('name',
    [
        'label' => false,
    ]
) ?></td></tr>

<tr valign="baseline"><td>メールアドレス:</td>
<td><?= $this->Form->input('mail',
    [
        'label' => false,  
    ]
) ?></td></tr>

<tr valign="baseline"><td>パスワード:</td>
<td><?= $this->Form->input('password',
    [
        'label' => false,
        'type' => 'password',
    ]
) ?></td></tr>

<tr valign="baseline"><td>パスワード（確認）:</td>
<td><?= $this->Form->input('retype_password',
    [
        'label' => false,
        'type' => 'password',
    ]
) ?></td></tr>

</td>
</table>

<p><?php 

    echo $this->Form->button('登録',
    [
        'type'=>'submit',
    ]);

?></p>

<?= $this->Form->end() ?>
</form>
</table>

アカウントをお持ちの方は
<a href="/users/login">
    こちら
</a>．

</body>
</html>
