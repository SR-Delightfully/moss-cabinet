<section id="summary-cards" class="cards-container wide">
    <ul>
        <?php foreach ($summary as $item): ?>
        <li>
            <div class="square-deco-container container">
                <div class="square-deco-content text-center">
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="fs-3 fw-bold"><?= htmlspecialchars($item['value']) ?></p>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>

<section id="kpi-charts" class="cards-container wide">
    <ul>
        <?php foreach ($charts as $chart): ?>
        <?php if (!empty($chart['data'])): ?>
        <li>
            <div class="square-deco-container container">
                <div class="square-deco-content">
                    <h3><?= htmlspecialchars($chart['title']) ?></h3>
                    <canvas id="<?= htmlspecialchars($chart['id']) ?>"></canvas>
                </div>
            </div>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</section>

<section class="cards-container wide">
    <ul>
        <li>
            <div class="square-deco-container container">
                <div class="square-deco-content">
                    <h3>Recent Orders</h3>
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
        </li>

        <li>
            <div class="square-deco-container container">
                <div class="square-deco-content">
                    <h3>Low Stock Products</h3>
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
        </li>

        <li>
            <div class="square-deco-container container">
                <div class="square-deco-content">
                    <h3>Recently Added Products</h3>
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
                </div>
            </div>
        </li>
    </ul>
</section>

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
