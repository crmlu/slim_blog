<?php $this->layout('main', ['title' => 'Login']); ?>

<a href="<?=$this->e($router->pathFor('home'))?>">Blog</a>
<?= $this->insert('_messages'); ?>
<h1>Login</h1>
<form action="<?=$this->e($router->pathFor('post-login'))?>" method="post">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" name="username" class="form-control" id="username">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
