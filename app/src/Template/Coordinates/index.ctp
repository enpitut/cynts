<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Coordinate'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Favorites'), ['controller' => 'Favorites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Favorite'), ['controller' => 'Favorites', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="coordinates index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('n_like') ?></th>
            <th><?= $this->Paginator->sort('n_unlike') ?></th>
            <th><?= $this->Paginator->sort('status') ?></th>
            <th><?= $this->Paginator->sort('created_at') ?></th>
            <th><?= $this->Paginator->sort('updated_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($coordinates as $coordinate): ?>
        <tr>
            <td><?= $this->Number->format($coordinate->id) ?></td>
            <td>
                <?= $coordinate->has('user') ? $this->Html->link($coordinate->user->name, ['controller' => 'Users', 'action' => 'view', $coordinate->user->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($coordinate->n_like) ?></td>
            <td><?= $this->Number->format($coordinate->n_unlike) ?></td>
            <td><?= $this->Number->format($coordinate->status) ?></td>
            <td><?= h($coordinate->created_at) ?></td>
            <td><?= h($coordinate->updated_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $coordinate->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $coordinate->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coordinate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coordinate->id)]) ?>
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
