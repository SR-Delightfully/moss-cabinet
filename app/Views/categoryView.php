<?php
use App\Helpers\ViewHelper;
/** @var array $category */
/** @var array $products */
$page_title = $category['category_name'];
ViewHelper::loadHeader($page_title);
?>

<div class="category-products container">
    <h1><?= $category['category_name'] ?></h1>
    <p><?= $category['category_description'] ?></p>

    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <a class="product-card" href="/product/<?= $p['product_id'] ?>">
                <img src="/<?= $p['primary_image'] ?>" alt="<?= $p['product_name'] ?>">
                <h3><?= $p['product_name'] ?></h3>
                <p class="price">$<?= number_format($p['product_price'], 2) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
