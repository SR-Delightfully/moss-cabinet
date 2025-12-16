<?php
use App\Helpers\ViewHelper;

/**
 * @var array|null $product         // product row (if editing)
 * @var array $categories           // all categories
 * @var array $collections          // all collections
 * @var array $images               // existing images (if editing)
 */

$isEdit = isset($product);
$page_title = $isEdit ? "Edit Product: {$product['product_name']}" : "Create Product";

ViewHelper::loadHeader($page_title);
?>

<div class="container product-form-wrapper">
    <h1><?= $isEdit ? "Edit Product" : "Add New Product" ?></h1>

    <form method="POST"
          action="<?= $isEdit ? '/admin/products/update' : '/admin/products/store' ?>"
          enctype="multipart/form-data"
          class="product-form">

        <?php if ($isEdit): ?>
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
        <?php endif; ?>

        <!-- PRODUCT NAME -->
        <label>Product Name</label>
        <input type="text"
               name="product_name"
               required
               value="<?= $isEdit ? htmlspecialchars($product['product_name']) : '' ?>">

        <!-- DESCRIPTION -->
        <label>Description</label>
        <textarea name="product_description" rows="6"><?= $isEdit ? htmlspecialchars($product['product_description']) : '' ?></textarea>

        <!-- PRICE -->
        <label>Price ($)</label>
        <input type="number"
               step="0.01"
               name="product_price"
               required
               value="<?= $isEdit ? $product['product_price'] : '' ?>">

        <!-- STOCK -->
        <label>Stock Quantity</label>
        <input type="number"
               name="product_stock_quantity"
               value="<?= $isEdit ? $product['product_stock_quantity'] : 0 ?>">

        <!-- CATEGORY -->
        <label>Category</label>
        <select name="category_id">
            <option value="">-- None --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"
                    <?= $isEdit && $product['category_id'] == $cat['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- COLLECTION -->
        <label>Collection</label>
        <select name="collection_id">
            <option value="">-- None --</option>
            <?php foreach ($collections as $col): ?>
                <option value="<?= $col['collection_id'] ?>"
                    <?= $isEdit && $product['collection_id'] == $col['collection_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($col['collection_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- IMAGE UPLOAD -->
        <label>Upload Images</label>
        <input type="file" name="images[]" multiple accept="image/*">

        <!-- EXISTING IMAGES -->
        <?php if ($isEdit && !empty($images)): ?>
            <div class="existing-images">
                <p>Existing Images</p>
                <?php foreach ($images as $img): ?>
                    <div class="img-item">
                        <img src="/<?= $img['image_file_path'] ?>" alt="">
                        <label>
                            <input type="checkbox" name="delete_images[]" value="<?= $img['product_image_id'] ?>">
                            Delete
                        </label>
                        <label>
                            <input type="radio"
                                   name="primary_image"
                                   value="<?= $img['product_image_id'] ?>"
                                   <?= $img['is_primary'] ? 'checked' : '' ?>>
                            Primary
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <button class="btn btn-primary">
            <?= $isEdit ? "Update Product" : "Create Product" ?>
        </button>
    </form>
</div>

<style>
.product-form-wrapper { max-width: 700px; margin: 2rem auto; }
.product-form label { display: block; margin-top: 1rem; font-weight: 600; }
.product-form input, .product-form textarea, .product-form select {
    width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;
}
.existing-images { margin-top: 1rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.existing-images img { width: 100%; border-radius: 8px; }
.img-item { display: flex; flex-direction: column; gap: .5rem; }
</style>
