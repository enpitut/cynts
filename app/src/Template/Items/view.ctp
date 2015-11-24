<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Shops'), ['controller' => 'Shops', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shop'), ['controller' => 'Shops', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="items view large-10 medium-9 columns">
    <h2><?= h($item->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($item->name) ?></p>
            <h6 class="subheader"><?= __('Shop') ?></h6>
            <p><?= $item->has('shop') ? $this->Html->link($item->shop->name, ['controller' => 'Shops', 'action' => 'view', $item->shop->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Color') ?></h6>
            <p><?= h($item->color) ?></p>
            <h6 class="subheader"><?= __('Sizes') ?></h6>
            <p><?= h($item->sizes) ?></p>
            <h6 class="subheader"><?= __('Category') ?></h6>
            <p><?= h($item->category) ?></p>
            <h6 class="subheader"><?= __('Purchase_url') ?></h6>
            <p><a target='_blank' href="<?= $item->purchase_url ?>"><?= $item->purchase_url ?></a></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($item->id) ?></p>
            <h6 class="subheader"><?= __('Price') ?></h6>
            <p><?= $this->Number->format($item->price) ?></p>
            <h6 class="subheader"><?= __('Sex') ?></h6>
            <p><?= $this->Number->format($item->sex) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($item->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($item->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($item->updated_at) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Photos') ?></h6>
            <?= $this->Text->autoParagraph(h($item->photos)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <?= $this->Text->autoParagraph(h($item->description)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Coordinates') ?></h4>
    <?php if (!empty($item->coordinates)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Photo') ?></th>
            <th><?= __('N Like') ?></th>
            <th><?= __('N Unlike') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($item->coordinates as $coordinates): ?>
        <tr>
            <td><?= h($coordinates->id) ?></td>
            <td><?= h($coordinates->user_id) ?></td>
            <td><?= h($coordinates->photo) ?></td>
            <td><?= h($coordinates->n_like) ?></td>
            <td><?= h($coordinates->n_unlike) ?></td>
            <td><?= h($coordinates->status) ?></td>
            <td><?= h($coordinates->created_at) ?></td>
            <td><?= h($coordinates->updated_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Coordinates', 'action' => 'view', $coordinates->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Coordinates', 'action' => 'edit', $coordinates->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Coordinates', 'action' => 'delete', $coordinates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coordinates->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
