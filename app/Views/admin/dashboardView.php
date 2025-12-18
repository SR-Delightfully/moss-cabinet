<?php
/** @var array $tables */
?>

<main class="p-4">
    <h1 class="mb-4"><?= htmlspecialchars($page_title ?? 'Admin Dashboard') ?></h1>

    <?php foreach ($tables as $tableName => $rows): ?>
        <?php if (!empty($rows)): ?>
            <h3 class="mt-5"><?= htmlspecialchars($tableName) ?></h3>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <?php foreach (array_keys($rows[0]) as $col): ?>
                        <th><?= htmlspecialchars($col) ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?= htmlspecialchars((string)$cell) ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a href="/admin/<?= strtolower($tableName) ?>/edit/<?= $row[array_keys($row)[0]] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="/admin/<?= strtolower($tableName) ?>/delete/<?= $row[array_keys($row)[0]] ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endforeach; ?>
</main>
