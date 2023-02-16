<?php $this->layout('main', ['title' => 'Blog posts']) ?>

<?= $this->insert('_menu'); ?>
<?= $this->insert('_messages'); ?>

<h1>Blog posts</h1>
<?php if (!empty($articles)): ?>
    <div class="row">
        <div class="col-md-8 blog-main">
            <?php foreach ($articles as $item): ?>
                <div class="blog-post">
                    <h3 class="blog-post-title"><?=$this->e($item['title'])?></h3>
                    <p><?=$this->e($item['content'])?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
