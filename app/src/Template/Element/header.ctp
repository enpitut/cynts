<header>
    <div id="header">
        <ul>
            <?php if ($this->Session->read('Auth.User')): ?>
                <li>
                    <a href="/users/view/<?= $this->Session->read('Auth.User.id') ?>">
                        User
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="/coordinatesbattle/battle">
                    Play
                </a>
            </li>
            <li>
                <a href="/rankings/view">
                    Ranking
                </a>
            </li>
            <li>
                <a href="/coordinates/create">
                    Post
                </a>
            </li>
        </ul>
    </div>
</header>
