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
    <div class="square-deco-content ">
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
            <div class="square-deco-content ">      
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
    <div class="square-deco-content ">
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
    <section id="activity-panel" >
    <div class="square-deco-container container">
    <div class="square-deco-content ">
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
    </section>

    <section id="activity-panel">
        <div class="square-deco-container container">
    <div class="square-deco-content ">
            <div class="square-deco-container">
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

    <!-- TABLES -->
    <section id="database-tables" class="square-deco-container container">
    <div class="square-deco-content img-container">
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
    </div>
    <div class="square-deco-inner"></div>
    <div class="square-deco-square-left-top"></div>
    <div class="square-deco-square-left-bottom"></div>
    <div class="square-deco-square-right-top"></div>
    <div class="square-deco-square-right-bottom"></div>
    <div class="square-deco-tall"></div>
    <div class="square-deco-wide"></div>
    </section>
