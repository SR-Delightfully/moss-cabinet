<?php
use App\Helpers\ViewHelper;
/** @var array $categories */
$page_title = "Shop by Category";
ViewHelper::loadHeader($page_title);
?>

<div class="categories container">
    <h1>Shop by Category</h1>

    <div class="category-grid">
        <?php foreach ($categories as $cat): ?>
            <a class="category-card" href="/category/<?= $cat['category_id'] ?>">
                <div class="category-content">
                    <h2><?= $cat['category_name'] ?></h2>
                    <p><?= $cat['category_description'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
