<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Favorite'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="favorites index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('coordinate_id') ?></th>
            <th><?= $this->Paginator->sort('status') ?></th>
            <th><?= $this->Paginator->sort('created_at') ?></th>
            <th><?= $this->Paginator->sort('updated_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($favorites as $favorite): ?>
        <tr>
            <td><?= $this->Number->format($favorite->id) ?></td>
            <td>
                <?= $favorite->has('user') ? $this->Html->link($favorite->user->name, ['controller' => 'Users', 'action' => 'view', $favorite->user->id]) : '' ?>
            </td>
            <td>
                <?= $favorite->has('coordinate') ? $this->Html->link($favorite->coordinate->id, ['controller' => 'Coordinates', 'action' => 'view', $favorite->coordinate->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($favorite->status) ?></td>
            <td><?= h($favorite->created_at) ?></td>
            <td><?= h($favorite->updated_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $favorite->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $favorite->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $favorite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $favorite->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
