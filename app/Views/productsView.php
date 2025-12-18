<?php

use App\Helpers\ViewHelper;

$data = $data ?? [];
$products = $data['products'] ?? [];
$collections = $data['collections'] ?? [];
$categories = $data['categories'] ?? [];

$page_title = 'All Products';
ViewHelper ::loadHeader($page_title);
?>

<div class="products-page container">
    <form class="search-bar-form" id="search-bar" method="GET" action="products">
        <input class="search-bar-input" type="text" name="search" placeholder="Search...">
        <button class="search-bar-button" type="submit"><img id="search-icon" src="/assets/images/search.svg" alt="star"
                                                             height="22rem" style="vertical-align: middle"></button>
    </form>


    <form class="search-bar-form" id="search-bar" method="GET" action="products">
        <div class="filter-group">
            <select name="collection" id="collection">
                <option value="">All Collections</option>
                <?php foreach ($collections as $col): ?>
                    <option value="<?= htmlspecialchars($col); ?>" <?= (($_GET['collection'] ?? '') === $col) ? 'selected' : '' ?>><?= htmlspecialchars($col); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <select name="category" id="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat); ?>" <?= (($_GET['category'] ?? '') === $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <main class="product-list">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['primary_image'])): ?>
                        <img src="/<?= htmlspecialchars($product['primary_image']); ?>"
                             alt="<?= htmlspecialchars($product['product_name']); ?>">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                    <h4><?= htmlspecialchars($product['product_name']); ?></h4>
                    <p class="price">$<?= number_format((float)$product['product_price'], 2); ?></p>
                    <a href="/products/<?= $product['product_id']; ?>" class="btn btn-secondary">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </main>
</div>
