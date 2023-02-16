<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?= $this->e($router->pathFor('home')) ?>">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav mr-auto">
                <?php //unauthorized user ?>
                <?php if (empty($_SESSION['username'])): ?>
                    <li class="nav-item <?= ($router->pathFor('login') == $cur_uri) ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= $this->e($router->pathFor('login')) ?>">Login</a>
                    </li>
                <?php //loggedin user ?>
                <?php else:?>
                    <li class="nav-item <?= ($router->pathFor('articles') == $cur_uri) ? 'active' : '' ?> ?>">
                        <a class="nav-link" href="<?= $this->e($router->pathFor('articles')) ?>">Edit posts</a>
                    </li>
                    <li class="nav-item <?= ($router->pathFor('logout') == $cur_uri) ? 'active' : '' ?> ?>">
                        <a class="nav-link" href="<?= $this->e($router->pathFor('logout')) ?>">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
