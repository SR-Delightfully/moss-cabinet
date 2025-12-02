<?php

use App\Helpers\ViewHelper;

$page_title = $page_title ?? ($data['title'] ?? 'Admin Dashboard');

ViewHelper::loadAdminHeader($page_title);

$tables = $tables ?? []; 
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= htmlspecialchars($page_title) ?></h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button
                type="button"
                class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi" aria-hidden="true">
                    <use xlink:href="#calendar3"></use>
                </svg>
                This week
            </button>
        </div>
    </div>

    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

    <h2>Section title</h2>
<?php if (!empty($tables)): ?>
    <?php foreach ($tables as $tableName => $rows): ?>
        <h3 class="mt-4 mb-2"><?= htmlspecialchars($tableName) ?></h3>

        <?php if (!empty($rows)): ?>
            <div class="table-responsive small">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($rows[0]) as $column): ?>
                                <th><?= htmlspecialchars($column) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?= htmlspecialchars((string)$cell) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No data in this table.</p>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif; ?>

    <div class="table-responsive small">
        <table id="example-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Header</th>
                    <th scope="col">Header</th>
                    <th scope="col">Header</th>
                    <th scope="col">Header</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>1,001</td>
                    <td>random</td>
                    <td>data</td>
                    <td>placeholder</td>
                    <td>text</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</main>

<?php

ViewHelper::loadJsScripts();

ViewHelper::loadAdminFooter();

?>
