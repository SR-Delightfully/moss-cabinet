<?php
use App\Helpers\ViewHelper;
/** @var array $collections */
$page_title = "Our Collections";
ViewHelper::loadHeader($page_title);
?>

<div class="collections container">
    <h1>Our Collections</h1>

    <?php foreach ($collections as $collection): ?>
        <section class="collection-block">
            <h2><?= $collection['collection_name'] ?></h2>

            <div class="product-grid">
                <?php if (!empty($collection['products'])): ?>
                    <?php foreach ($collection['products'] as $p): ?>
                        <a class="product-card" href="/product/<?= $p['product_id'] ?>">
                            <img src="/<?= $p['primary_image'] ?>" alt="<?= $p['product_name'] ?>">
                            <h3><?= $p['product_name'] ?></h3>
                            <p class="price">$<?= number_format($p['product_price'], 2) ?></p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found in this collection.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
