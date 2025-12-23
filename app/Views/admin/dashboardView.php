<?php
/** @var array $summary */
/** @var array $charts */
/** @var array $recentOrders */
/** @var array $lowStock */
/** @var array $recentProducts */
/** @var array $tables */
?>

<!-- PAGE TITLE -->
<section id="admin-page-title" class="square-deco-container container">
    <div class="square-deco-content">
        <h1 id="dashboard" class="bilbo-swash-caps-regular fancy-title"><?= htmlspecialchars($page_title ?? 'Admin Dashboard') ?></h1>
    </div>
    <div class="square-deco-inner"></div>
    <div class="square-deco-square-left-top"></div>
    <div class="square-deco-square-left-bottom"></div>
    <div class="square-deco-square-right-top"></div>
    <div class="square-deco-square-right-bottom"></div>
    <div class="square-deco-tall"></div>
    <div class="square-deco-wide"></div>
</section>

<!-- SUMMARY CARDS -->
<?php foreach ($summary as $item): ?>
<section id="<?= htmlspecialchars($item['title']) ?>-summary" class="square-deco-container container">
    <div class="square-deco-content">      
        <h3><?= htmlspecialchars($item['title']) ?></h3>
        <p><?= htmlspecialchars($item['value']) ?></p>
    </div>
    <div class="square-deco-inner"></div>
    <div class="square-deco-square-left-top"></div>
    <div class="square-deco-square-left-bottom"></div>
    <div class="square-deco-square-right-top"></div>
    <div class="square-deco-square-right-bottom"></div>
    <div class="square-deco-tall"></div>
    <div class="square-deco-wide"></div>
</section>
<?php endforeach; ?>

<!-- KPI CHARTS -->
<section id="kpi-charts" class="square-deco-container container">
    <div class="square-deco-content">
        <?php foreach ($charts as $chart): ?>
            <?php if (!empty($chart['data'])): ?>
            <div class="square-deco-container">
                <h3><?= htmlspecialchars($chart['title']) ?></h3>
                <canvas id="<?= htmlspecialchars($chart['id']) ?>"></canvas>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="square-deco-inner"></div>
    <div class="square-deco-square-left-top"></div>
    <div class="square-deco-square-left-bottom"></div>
    <div class="square-deco-square-right-top"></div>
    <div class="square-deco-square-right-bottom"></div>
    <div class="square-deco-tall"></div>
    <div class="square-deco-wide"></div>
</section>

<!-- ACTIVITY PANEL -->
<section id="activity-panel">
    <div class="square-deco-container container">
        <div class="square-deco-content">
            <div class="square-deco-container">
                <h3 id="users-table">Recent Orders</h3>
                <?php if ($recentOrders): ?>
                <ul class="mini-activity-list">
                    <?php foreach ($recentOrders as $order): ?>
                    <li>
                        <strong>#<?= $order['order_id'] ?></strong>
                        <?= htmlspecialchars($order['user_name']) ?>
                        <span>$<?= number_format($order['order_total'], 2) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="admin-muted">No recent orders</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="square-deco-inner"></div>
        <div class="square-deco-square-left-top"></div>
        <div class="square-deco-square-left-bottom"></div>
        <div class="square-deco-square-right-top"></div>
        <div class="square-deco-square-right-bottom"></div>
        <div class="square-deco-tall"></div>
        <div class="square-deco-wide"></div>
    </div>

    <div class="square-deco-container container">
        <div class="square-deco-content">
            <div class="square-deco-container">
                <h3 id="low-stock">Low Stock Products</h3>
                <?php if ($lowStock): ?>
                <ul class="mini-activity-list">
                    <?php foreach ($lowStock as $product): ?>
                    <li>
                        <?= htmlspecialchars($product['product_name']) ?>
                        (<?= htmlspecialchars($product['category_name']) ?>)
                        <span>Stock: <?= $product['stock_quantity'] ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="admin-muted">All products are sufficiently stocked</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="square-deco-inner"></div>
        <div class="square-deco-square-left-top"></div>
        <div class="square-deco-square-left-bottom"></div>
        <div class="square-deco-square-right-top"></div>
        <div class="square-deco-square-right-bottom"></div>
        <div class="square-deco-tall"></div>
        <div class="square-deco-wide"></div>
    </div>
</section>

<!-- RECENT PRODUCTS -->
<section id="recent-products" class="cards-container wide">
    <ul>
        <?php if ($recentProducts): ?>
            <?php foreach ($recentProducts as $product): ?>
        <li>
            <div class="category-card square-deco-container container">
                <div class="square-deco-content">
                    <?= htmlspecialchars($product['product_name']) ?>
                    <span><?= htmlspecialchars($product['category_name']) ?></span>
                </div>
                <div class="square-deco-inner"></div>
                <div class="square-deco-square-left-top"></div>
                <div class="square-deco-square-left-bottom"></div>
                <div class="square-deco-square-right-top"></div>
                <div class="square-deco-square-right-bottom"></div>
                <div class="square-deco-tall" id="square-deco-container-tall"></div>
                <div class="square-deco-wide" id="square-deco-container-wide"></div>
            </div>
        </li>
            <?php endforeach; ?>
        <?php else: ?>
        <p class="admin-muted">No new products</p>
        <?php endif; ?>
    </ul>
</section>

<!-- DATABASE TABLES -->
<section id="database-tables" class="square-deco-container container" style="overflow: visible;">
    <div class="square-deco-content img-container">

        <?php $toggle = true; ?>
        <?php foreach ($tables as $tableName => $rows): ?>
            <?php if (!empty($rows)): ?>
                <?php 
                    $tableKey = strtolower(str_replace(' ', '-', $tableName)) . '-table'; 
                    $toggle = !$toggle; // alternate layout
                ?>
                <div class="admin-crud-grid <?php echo $toggle ? 'layout-left-table' : 'layout-left-form'; ?>">

                    <!-- LEFT COLUMN -->
                    <div class="admin-table-column square-deco-container full-width-table">
                        <div class="square-deco-content table-scroll">
                            <h3 class="table-title"><?= htmlspecialchars($tableName) ?></h3>
                            <table class="table table-bordered table-striped table-hover full-width-table">
                                <thead>
                                    <tr>
                                        <?php foreach (array_keys($rows[0]) as $col): ?>
                                        <th><?= htmlspecialchars($col) ?></th>
                                        <?php endforeach; ?>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                    <tr data-id="<?= $row[array_key_first($row)] ?>">
                                        <?php foreach ($row as $cell): ?>
                                        <td><?= htmlspecialchars((string)$cell) ?></td>
                                        <?php endforeach; ?>
                                        <td class="actions-cell">
                                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                            <form method="post" action="/admin/crud/<?= strtolower($tableName) ?>/<?= $row[array_key_first($row)] ?>/delete" style="display:inline" onsubmit="return confirm('Delete this item?')">
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="square-deco-inner"></div>
                        <div class="square-deco-square-left-top"></div>
                        <div class="square-deco-square-left-bottom"></div>
                        <div class="square-deco-square-right-top"></div>
                        <div class="square-deco-square-right-bottom"></div>
                        <div class="square-deco-tall"></div>
                        <div class="square-deco-wide"></div>
                    </div>

                    <!-- RIGHT COLUMN: FORM -->
                    <div class="admin-form-column square-deco-container">
                        <div class="square-deco-content">
                            <!-- Floating Edit Form -->
                            <div class="edit-form-wrapper" id="<?= $tableKey ?>-form-wrapper">
                                <div class="square-deco-content edit-form-content">
                                    <button class="btn btn-sm btn-danger close-form">X</button>
                                    <h4>Edit <?= htmlspecialchars($tableName) ?></h4>
                                    <form method="post" class="edit-form"></form>
                                </div>
                                <div class="square-deco-inner"></div>
                                <div class="square-deco-square-left-top"></div>
                                <div class="square-deco-square-left-bottom"></div>
                                <div class="square-deco-square-right-top"></div>
                                <div class="square-deco-square-right-bottom"></div>
                                <div class="square-deco-tall"></div>
                                <div class="square-deco-wide"></div>
                            </div>

                            <!-- New Record Form -->
                            <div class="new-form-wrapper square-deco-container">
                                <div class="square-deco-content edit-form-content">
                                    <h4>New <?= htmlspecialchars($tableName) ?></h4>
                                    <form method="post" class="new-form">
                                        <?php 
                                        $excludedColumns = ['id', 'created_at', 'updated_at'];
                                        foreach(array_keys($rows[0]) as $col): 
                                            if(in_array($col, $excludedColumns)) continue;
                                        ?>
                                            <label><?= htmlspecialchars($col) ?></label>
                                            <input type="text" name="<?= htmlspecialchars($col) ?>">
                                        <?php endforeach; ?>
                                        <button class="btn btn-primary btn-sm" type="submit">Create</button>
                                    </form>
                                </div>
                                <div class="square-deco-inner"></div>
                                <div class="square-deco-square-left-top"></div>
                                <div class="square-deco-square-left-bottom"></div>
                                <div class="square-deco-square-right-top"></div>
                                <div class="square-deco-square-right-bottom"></div>
                                <div class="square-deco-tall"></div>
                                <div class="square-deco-wide"></div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>
</section>


<script>
document.querySelectorAll('.admin-table-column .edit-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        const grid = e.target.closest('.admin-crud-grid');
        const tableTitle = grid.querySelector('.table-title').textContent.trim();
        const tableKey = tableTitle.toLowerCase().replace(/\s+/g,'-') + '-table';
        const formWrapper = document.getElementById(tableKey + '-form-wrapper');
        const form = formWrapper.querySelector('form');

        // Highlight selected row
        grid.querySelectorAll('tr').forEach(r => r.classList.remove('selected-row'));
        row.classList.add('selected-row');

        // Clear previous inputs
        form.innerHTML = '';

        const headers = Array.from(grid.querySelectorAll('th'))
            .map(th => th.textContent.trim())
            .filter(h => h !== 'Actions');

        row.querySelectorAll('td').forEach((td, i) => {
            if(i < headers.length){
                form.innerHTML += `
                    <label>${headers[i]}</label>
                    <input type="text" name="${headers[i]}" value="${td.textContent.trim()}">
                `;
            }
        });

        const primaryKey = row.dataset.id;
        const tableName = tableTitle.toLowerCase().replace(/\s+/g,'');
        form.action = `/admin/crud/${tableName}/${primaryKey}/update`;

        form.innerHTML += `<button class="btn btn-primary btn-sm" type="submit">Save Changes</button>`;

        formWrapper.style.display = 'block';
    });
});

document.querySelectorAll('.close-form').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.target.closest('.edit-form-wrapper').style.display = 'none';
    });
});
</script>
