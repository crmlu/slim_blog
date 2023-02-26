<?php $this->layout('base', ['title' => $page_title]); ?>

<?= $this->insert('_menu'); ?>
<h1><?= $page_title ?></h1>
<?= $this->insert('_messages'); ?>

<?php if (!empty($create_link)): ?>
    <a class="btn btn-sm btn-success" role="button" href="<?=$this->e($router->pathFor($create_path))?>">
        <?= $this->e($create_title) ?>
    </a>
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
                    <a class="btn btn-sm btn-primary" role="button" href="<?=$this->e($router->pathFor($edit_path, ['id' => $item['id']]))?>">Edit</a>
                    <a class="btn btn-sm btn-warning" role="button" href="<?=$this->e($router->pathFor($delete_path, ['id' => $item['id']]))?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
