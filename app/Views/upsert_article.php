<?php $this->layout('base', ['title' => $page_title]); ?>

    <?= $this->insert('_menu'); ?>
    <?= $this->insert('_messages'); ?>
    <?php 
        if (!empty($item['id'])): 
            $path = $router->pathFor('get-update-article', ['id' => $item['id']]);
        else:
            $path = $router->pathFor('get-create-article');
        endif; 
    ?>
    <div class="container">
        <h1><?= $page_title ?></h1>
        <form method="post" action="<?=$this->e($path)?>" enctype="multipart/form-data">
            <?php if (!empty($item['id'])): ?>
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" type="text" class="form-control" id="title"
                    placeholder="title" value="<?= (!empty($item) ? $item['title'] : '') ?>" maxlength="1000">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <?php if (!empty($item['image'])): ?>
                    <img src="<?= $router->pathFor('uploads',
                        ['id' => $item['file_id'],
                        'name' => $item['file_name']
                        ])?>" alt="" width="100">
                <?php endif; ?>
                <input name="image" type="file" class="form-control" id="image" accept=".png, .jpeg, .jpg">
            </div>
            <div class="form-group">
                <label for="content">Post</label>
                <textarea name="content" class="form-control" id="content" rows="3"><?= (!empty($item) ? $item['content'] : '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
