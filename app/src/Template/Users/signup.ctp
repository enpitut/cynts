<html>

<head>

<?= $this->Html->css('sign.css') ?>
<?= $this->element('eachpage_header') ?>
<?php
use \App\Model\Table\UsersTable
?>

</head>

<body>


<script type="text/javascript">

function hide_display(){     document.write("hide_displayしてるよ");
    check_result = document.getElementsByName('attention_name').id; 
    if(check_result == false) {
    //フォーム表示
        document.getElementById('attention').style = "display";
    } else {
    //フォーム非表示
        document.getElementById('attention').style = "display.none";
    }
}
//オンロードさせ、リロード時に選択を保持
//window.onload = entryChange1;


</script>

<?php echo $this->Form->error('name'); ?>

<div class="big"> Welcome to Unichronicle! </div>
<p> Please enter your information. <p>

<?= $this->Form->create() ?>

<table border="0" align="center">
<tr><td>

<tr><td>username:</td>
<td><?= $this->Form->input('name',
    array('label' => false,
    )
) ?></td></tr>

<tr><td>mail:</td>
<td><?= $this->Form->input('mail',
    array('label' => false,
    )
) ?></td></tr>

<tr><td>password:</td>
<td><?= $this->Form->input('password',
    array('label' => false,
    )
) ?></td></tr>

<tr><td>retype password:</td>
<td><?= $this->Form->input('passwd',
    array('label' => false,
    )
) ?></td></tr>

<!--
sex:<br />
<?= $this->Form->select('sex',
        array('0' => 'male',
            '1' => 'female',
            '2' => 'neutral'),
        array('empty' => 'select')
    )
?>
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
