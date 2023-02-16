<?php if (!empty($flash->getMessage('error'))): ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <?php foreach ($flash->getMessage('error') as $mes): ?>
        <p><?= $this->e($mes) ?></p>
      <?php endforeach; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>
<?php endif; ?>
<?php if (!empty($flash->getMessage('info'))): ?>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
      <?php foreach ($flash->getMessage('info') as $mes): ?>
        <p><?= $this->e($mes) ?></p>
      <?php endforeach; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>
<?php endif; ?>