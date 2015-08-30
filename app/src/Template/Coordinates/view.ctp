<!--
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Coordinate'), ['action' => 'edit', $coordinate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Coordinate'), ['action' => 'delete', $coordinate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coordinate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Coordinates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Coordinate'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Favorites'), ['controller' => 'Favorites', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Favorite'), ['controller' => 'Favorites', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="coordinates view large-10 medium-9 columns">
    <h2><?= h($coordinate->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $coordinate->has('user') ? $this->Html->link($coordinate->user->name, ['controller' => 'Users', 'action' => 'view', $coordinate->user->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($coordinate->id) ?></p>
            <h6 class="subheader"><?= __('N Like') ?></h6>
            <p><?= $this->Number->format($coordinate->n_like) ?></p>
            <h6 class="subheader"><?= __('N Unlike') ?></h6>
            <p><?= $this->Number->format($coordinate->n_unlike) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($coordinate->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($coordinate->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($coordinate->updated_at) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Photos') ?></h6>
            <?= $this->Text->autoParagraph(h($coordinate->photos)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Total Price') ?></h6>
            <?= h($total_price) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Favorites') ?></h4>
    <?php if (!empty($coordinate->favorites)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Coordinate Id') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($coordinate->favorites as $favorites): ?>
        <tr>
            <td><?= h($favorites->id) ?></td>
            <td><?= h($favorites->user_id) ?></td>
            <td><?= h($favorites->coordinate_id) ?></td>
            <td><?= h($favorites->status) ?></td>
            <td><?= h($favorites->created_at) ?></td>
            <td><?= h($favorites->updated_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Favorites', 'action' => 'view', $favorites->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Favorites', 'action' => 'edit', $favorites->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Favorites', 'action' => 'delete', $favorites->id], ['confirm' => __('Are you sure you want to delete # {0}?', $favorites->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Items') ?></h4>
    <?php if (!empty($coordinate->items)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Name') ?></th>
            <th><?= __('Shop Id') ?></th>
            <th><?= __('Colors') ?></th>
            <th><?= __('Sizes') ?></th>
            <th><?= __('Category') ?></th>
            <th><?= __('Price') ?></th>
            <th><?= __('Photos') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Sex') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($coordinate->items as $items): ?>
        <tr>
            <td><?= h($items->id) ?></td>
            <td><?= h($items->name) ?></td>
            <td><?= h($items->shop_id) ?></td>
            <td><?= h($items->colors) ?></td>
            <td><?= h($items->sizes) ?></td>
            <td><?= h($items->category) ?></td>
            <td><?= h($items->price) ?></td>
            <td><?= h($items->photos) ?></td>
            <td><?= h($items->description) ?></td>
            <td><?= h($items->sex) ?></td>
            <td><?= h($items->status) ?></td>
            <td><?= h($items->created_at) ?></td>
            <td><?= h($items->updated_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
-->

<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.1.0/velocity.js"></script>
<script>
    var coordinate_id;
    var push_enable = true;
</script>
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('battle.css') ?>
</head>
<body>
    
<?= $this->Html->image('/img/view/header.png'); ?>
<?= $this->element('header') ?>

<div id="centermessage">
  <p>コーディネートの詳細</p>
</div>

<div id="battlecolumn">
<ul>
<?php
$photo_id = 0;
echo $this->Html->image($coordinate->photos,
        array(
            'id' => $coordinate->id
        ));
