<?php
/** @var array $summary */
/** @var array $charts */
/** @var array $recentOrders */
/** @var array $lowStock */
/** @var array $recentProducts */
/** @var array $tables */
?>

<main id="admin-side-content">

    <!-- PAGE TITLE -->
    <h1 id="dashboard" class="admin-page-title"><?= htmlspecialchars($page_title ?? 'Admin Dashboard') ?></h1>

    <!-- SUMMARY CARDS -->
    <section id="summary-cards">
        <ul>
            <?php foreach ($summary as $item): ?>
            <li>
                <div class="square-deco-container">
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                    <p><?= htmlspecialchars($item['value']) ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- KPI CHARTS -->
    <section id="kpi-charts">
        <?php foreach ($charts as $chart): ?>
            <?php if (!empty($chart['data'])): ?>
            <div class="square-deco-container">
                <h3><?= htmlspecialchars($chart['title']) ?></h3>
                <canvas id="<?= htmlspecialchars($chart['id']) ?>"></canvas>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>

    <!-- ACTIVITY PANEL -->
    <section id="activity-panel">
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
    </section>

    <!-- RECENT PRODUCTS -->
    <section id="recent-products">
        <h3 id="products-table">Recently Added Products</h3>
        <?php if ($recentProducts): ?>
            <ul class="mini-activity-list">
                <?php foreach ($recentProducts as $product): ?>
                <li>
                    <?= htmlspecialchars($product['product_name']) ?>
                    <span><?= htmlspecialchars($product['category_name']) ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="admin-muted">No new products</p>
        <?php endif; ?>
    </section>

    <!-- TABLES -->
    <?php foreach ($tables as $tableName => $rows): ?>
        <?php if (!empty($rows)): ?>
            <?php $tableId = strtolower(str_replace(' ', '-', $tableName)) . '-table'; ?>
            <h3 id="<?= $tableId ?>" class="table-title"><?= htmlspecialchars($tableName) ?></h3>
            <table class="table table-bordered table-striped table-hover">
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
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?= htmlspecialchars((string)$cell) ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a href="#<?= $tableId ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="#<?= $tableId ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endforeach; ?>

</main>

<?php if ($charts): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php foreach ($charts as $chart): ?>
<?php if (!empty($chart['data'])): ?>
new Chart(
    document.getElementById('<?= $chart['id'] ?>'),
    {
        type: '<?= $chart['type'] ?>',
        data: {
            labels: <?= json_encode(array_keys($chart['data'])) ?>,
            datasets: [{
                label: <?= json_encode($chart['label']) ?>,
                data: <?= json_encode(array_values($chart['data'])) ?>,
                backgroundColor: 'rgba(32,178,170,0.45)',
                borderColor: 'rgba(32,178,170,1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    }
);
<?php endif; ?>
<?php endforeach; ?>
</script>
<?php endif; ?>
