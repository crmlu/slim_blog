<?php $this->layout('main', ['title' => 'Blog posts']) ?>

<h1>Blog posts</h1>
<?php if (!empty($articles)): ?>
    <?php foreach ($articles as $item): ?>
        <div>
        <h2><?=$this->e($item->title)?></h2>
        <p><?=$this->e($item->content)?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
