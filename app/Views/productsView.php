<?php
use App\Helpers\ViewHelper;
/**
 * @var array $products   // array of all product rows
 * @var array $collections // array of collection names
 * @var array $categories  // array of category names
 */

$page_title = 'All Products';
ViewHelper::loadHeader($page_title);
?>

<div class="products-page container">
    <aside class="sidebar">
        <h3>Search & Filters</h3>
        
        <form method="GET" action="/products">
            <div class="filter-group">
                <label for="search_name">Search by Name:</label>
                <input type="text" name="search_name" id="search_name" value="<?= htmlspecialchars($_GET['search_name'] ?? '') ?>">
            </div>

            <div class="filter-group">
                <label for="collection">Filter by Collection:</label>
                <select name="collection" id="collection">
                    <option value="">All Collections</option>
                    <?php foreach ($collections as $col): ?>
                        <option value="<?= htmlspecialchars($col); ?>" <?= (($_GET['collection'] ?? '') === $col) ? 'selected' : '' ?>><?= htmlspecialchars($col); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="category">Filter by Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat); ?>" <?= (($_GET['category'] ?? '') === $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Filter by Price:</label>
                <input type="number" name="min_price" placeholder="Min" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
                <input type="number" name="max_price" placeholder="Max" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
            </div>

            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>
    </aside>

    <main class="product-list">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['image'])): ?>
                        <img src="/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
                    <?php endif; ?>
                    <h4><?= htmlspecialchars($product['product_name']); ?></h4>
                    <p class="price">$<?= number_format($product['product_price'], 2); ?></p>
                    <a href="/product/<?= $product['product_id']; ?>" class="btn btn-secondary">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </main>
</div>
