<html>

<head>

<?= $this->Html->css('sign.css') ?>
<?= $this->element('eachpage_header') ?>

<?php
use \App\Model\Table\UsersTable
?>

</head>


<body>

<div class="big"> Welcome to Unichronicle! </div>
<p> Please enter your information. <p>
<table border="0" align="center">
<tr></tr>

<?= $this->Form->create($user, array('novalidate'=>'novalidate')) ?>

<tr><td>

<tr valign="baseline"><td>username:</td>
<td><?= $this->Form->input('name',
    [
        'label' => false,
    ]
) ?></td></tr>

<tr valign="baseline"><td>mail:</td>
<td><?= $this->Form->input('mail',
    [
        'label' => false,  
    ]
) ?></td></tr>

<tr valign="baseline"><td>password:</td>
<td><?= $this->Form->input('password',
    [
        'label' => false,
    ]
) ?></td></tr>

<tr valign="baseline"><td>retype password:</td>
<td><?= $this->Form->input('retype_password',
    [
        'label' => false,
        'type' => 'password',
    ]
) ?></td></tr>

<!--
<tr valign="baseline"><td>sex:<br />
<td><?= $this->Form->select('sex',
        array('0' => 'male',
            '1' => 'female',
            '2' => 'neutral'),
        array('empty' => 'select')
    )
?></td></tr>
-->
</td>
</table>

<p><?php 

    echo $this->Form->button('Sign up',
    [
        'type'=>'submit',
    ]);

?></p>

<?= $this->Form->end() ?>
</form>
</table>

If you have a Unichronicle account,
<a href="/users/login">
    click here
</a>.

</body>
</html>
