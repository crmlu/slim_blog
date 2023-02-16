<?php $this->layout('main', ['title' => 'Login']); ?>

<?= $this->insert('_menu'); ?>
<?= $this->insert('_messages'); ?>
<form action="<?=$this->e($router->pathFor('post-login'))?>" method="post" class="form-signin">
    <h1 class="h3 mb-3 font-weight-normal">Login</h1>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" id="username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>
