<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?= $this->e($router->pathFor('home')) ?>">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav mr-auto">
                <?php //unauthorized user ?>
                <?php if (empty($_SESSION['user'])): ?>
                    <li class="nav-item <?= ($router->pathFor('login') == $cur_uri) ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= $this->e($router->pathFor('login')) ?>">Login</a>
                    </li>
                <?php //loggedin user ?>
                <?php else:?>
                    <li class="nav-item <?= ($router->pathFor('articles') == $cur_uri) ? 'active' : '' ?> ?>">
                        <a class="nav-link" href="<?= $this->e($router->pathFor('articles')) ?>">Posts</a>
                    </li>
                    <li class="nav-item <?= ($router->pathFor('users') == $cur_uri) ? 'active' : '' ?> ?>">
                        <a class="nav-link" href="<?= $this->e($router->pathFor('users')) ?>">Users</a>
                    </li>
                    <li class="nav-item dropdown 
                        <?= ($router->pathFor('get-update-user', ['id' => $_SESSION['user']]) == $cur_uri) ? 'active' : '' ?> ?>">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <?= $this->e($_SESSION['username']) ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                                href="<?= $this->e($router->pathFor('get-update-user', ['id' => $_SESSION['user']])) ?>">
                                My profile
                            </a>
                            <a class="dropdown-item" href="<?= $this->e($router->pathFor('logout')) ?>">
                                Logout
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
