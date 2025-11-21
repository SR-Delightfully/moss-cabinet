<?php
use App\Helpers\ViewHelper;
/** @var array $product  // product row with fields
 *  @var array $images   // array of product images
 */
$page_title = $product['product_name'] ?? 'Product';
ViewHelper::loadHeader($page_title);
?>

<div class="product-view container">
    <div class="product-gallery">
        <?php if (!empty($images)): ?>
            <img class="primary-image" src="/<?= $images[0]['image_file_path']; ?>" alt="<?= $product['product_name']; ?>">
            
            <div class="thumbnail-row">
                <?php foreach ($images as $img): ?>
                    <img class="thumbnail" src="/<?= $img['image_file_path']; ?>" alt="Thumbnail">
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No images available.</p>
        <?php endif; ?>
    </div>

    <div class="product-info">
        <h1><?= $product['product_name'] ?></h1>
        <p class="price">$<?= number_format($product['product_price'], 2) ?></p>

        <p class="description">
            <?= nl2br($product['product_description']); ?>
        </p>

        <div class="product-actions">
            <form method="POST" action="/wishlist/add">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <button class="btn btn-secondary">♡ Add to Wishlist</button>
            </form>

            <form method="POST" action="/cart/add">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <button class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
