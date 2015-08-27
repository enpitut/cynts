<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Coordinates Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="coordinatesItems index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('coordinate_id') ?></th>
            <th><?= $this->Paginator->sort('item_id') ?></th>
            <th><?= $this->Paginator->sort('color') ?></th>
            <th><?= $this->Paginator->sort('size') ?></th>
            <th><?= $this->Paginator->sort('status') ?></th>
            <th><?= $this->Paginator->sort('created_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($coordinatesItems as $coordinatesItem): ?>
        <tr>
            <td><?= $this->Number->format($coordinatesItem->id) ?></td>
            <td>
                <?= $coordinatesItem->has('coordinate') ? $this->Html->link($coordinatesItem->coordinate->id, ['controller' => 'Coordinates', 'action' => 'view', $coordinatesItem->coordinate->id]) : '' ?>
            </td>
            <td>
                <?= $coordinatesItem->has('item') ? $this->Html->link($coordinatesItem->item->name, ['controller' => 'Items', 'action' => 'view', $coordinatesItem->item->id]) : '' ?>
            </td>
            <td><?= h($coordinatesItem->color) ?></td>
            <td><?= h($coordinatesItem->size) ?></td>
            <td><?= $this->Number->format($coordinatesItem->status) ?></td>
            <td><?= h($coordinatesItem->created_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $coordinatesItem->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $coordinatesItem->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coordinatesItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coordinatesItem->id)]) ?>
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
