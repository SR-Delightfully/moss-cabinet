<?php
use App\Helpers\ViewHelper;
/** @var array $wishlist_items */
$page_title = 'Your Wishlist';
ViewHelper::loadHeader($page_title);
?>

<div class="container wishlist-page">
    <h1>Your Wishlist</h1>

    <?php if (empty($wishlist_items)): ?>
        <p>Your wishlist is empty.</p>

    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($wishlist_items as $item): ?>
                <div class="product-card wishlist-card">
                    <img src="/<?= $item['primary_image'] ?>" alt="<?= $item['product_name'] ?>">

                    <h3><?= $item['product_name'] ?></h3>
                    <p class="price">$<?= number_format($item['product_price'], 2) ?></p>

                    <div class="wishlist-actions">

                        <form method="POST" action="/cart/add">
                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                            <button type="submit" class="btn">Add to Cart</button>
                        </form>

                        <form method="POST" action="/wishlist/remove">
                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
