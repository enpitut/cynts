<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Favorites'), ['controller' => 'Favorites', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Favorite'), ['controller' => 'Favorites', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="users view large-10 medium-9 columns">
    <h2><?= h($user->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($user->name) ?></p>
            <h6 class="subheader"><?= __('Mail') ?></h6>
            <p><?= h($user->mail) ?></p>
            <h6 class="subheader"><?= __('Password') ?></h6>
            <p><?= h($user->password) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($user->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($user->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($user->updated_at) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Coordinates') ?></h4>
    <?php if (!empty($user->coordinates)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Photos') ?></th>
            <th><?= __('N Like') ?></th>
            <th><?= __('N Unlike') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->coordinates as $coordinates): ?>
        <tr>
            <td><?= h($coordinates->id) ?></td>
            <td><?= h($coordinates->user_id) ?></td>
            <td><?= h($coordinates->photos) ?></td>
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
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Favorites') ?></h4>
    <?php if (!empty($user->favorites)): ?>
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
        <?php foreach ($user->favorites as $favorites): ?>
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
