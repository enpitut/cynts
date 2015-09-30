
<h1>Login</h1>
<?= $this->Form->create() ?>
<?= $this->Form->input('mail') ?>
<?= $this->Form->input('password') ?>
<?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>
<?php
 echo $this->Html->link('新規作成','users/signup');


echo $this->Session->flash('auth');
echo $this->Form->create('User',array('url','login'));
echo $this->Form->input('User.username',array('label'=>'ユーザ名'));
echo $this->Form->input('User.password',array('type'=>'password','label'=>'パスワード'));
echo $this->Form->end('ログイン');
echo $this->Html->link('新規作成','useradd');

?>