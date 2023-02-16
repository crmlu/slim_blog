<?php $this->layout('main', ['title' => $page_title]); ?>

<h1><?= $page_title ?></h1>
<?= $this->insert('_messages'); ?>
<?php if (!empty($create_link)): ?>
    <a href="<?=$this->e($router->pathFor('get-create-article'))?>">Write new post</a>
<?php endif; ?>
<?php if (!empty($items)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <?php foreach ($columns as $column): ?>
                    <th scope="col"><?= $column['name'] ?></th>
                <?php endforeach; ?>
                    <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>   
            <tr>
                <?php foreach ($columns as $column): ?> 
                <td><?= $item[$column['column']] ?></td>
                <?php endforeach; ?>
                <td>
                    <a href="<?=$this->e($router->pathFor('get-update-article', ['id' => $item['id']]))?>">Edit</a>
                    <a href="<?=$this->e($router->pathFor('delete-article', ['id' => $item['id']]))?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
