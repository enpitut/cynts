<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Shop'), ['action' => 'edit', $shop->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Shop'), ['action' => 'delete', $shop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shop->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shops'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shop'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="shops view large-10 medium-9 columns">
    <h2><?= h($shop->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($shop->name) ?></p>
            <h6 class="subheader"><?= __('Url') ?></h6>
            <p><?= h($shop->url) ?></p>
            <h6 class="subheader"><?= __('Address') ?></h6>
            <p><?= h($shop->address) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($shop->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($shop->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($shop->updated_at) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Photos') ?></h6>
            <?= $this->Text->autoParagraph(h($shop->photos)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Items') ?></h4>
    <?php if (!empty($shop->items)): ?>
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
        <?php foreach ($shop->items as $items): ?>
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
