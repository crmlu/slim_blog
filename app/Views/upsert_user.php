<?php $this->layout('base', ['title' => $page_title]); ?>

    <?= $this->insert('_menu'); ?>
    <?= $this->insert('_messages'); ?>
    <?php 
        if (!empty($item['id'])): 
            $path = $router->pathFor('get-update-user', ['id' => $item['id']]);
        else:
            $path = $router->pathFor('get-create-user');
        endif; 
    ?>
    <div class="container">
        <h1><?= $page_title ?></h1>
        <form method="post" action="<?=$this->e($path)?>">
            <?php if (!empty($item['id'])): ?>
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="name"
                    placeholder="name" value="<?= (!empty($item) ? $item['name'] : '') ?>" maxlength="100">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input name="username" type="text" class="form-control" id="username"
                    placeholder="username" value="<?= (!empty($item) ? $item['username'] : '') ?>" maxlength="100">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="email" class="form-control" id="email"
                    placeholder="email" value="<?= (!empty($item) ? $item['email'] : '') ?>" maxlength="100">
            </div>
            <?php if (!empty($item['id'])): ?>
                <div class="form-group">
                    <label for="current_password">Current password</label>
                    <input name="current_password" type="password" class="form-control" id="current_password">
                    <small id="passwordHelp" class="form-text text-danger">Fill in only if you want to change the password</small>
                </div>
                <div class="form-group">
                    <label for="password">New password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="password2">Repeat new password</label>
                    <input name="password2" type="password" class="form-control" id="password2">
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="password2">Repeat password</label>
                    <input name="password2" type="password" class="form-control" id="password2">
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
