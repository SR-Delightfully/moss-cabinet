<?php
use App\Helpers\ViewHelper;
/** @var array $cart_items */
/** @var float $cart_total */
$page_title = 'Your Cart';
ViewHelper::loadHeader($page_title);
?>

<div class="container cart-page">
    <h1>Your Cart</h1>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td class="cart-product">
                        <img src="/<?= $item['primary_image'] ?>" alt="<?= $item['product_name'] ?>">
                        <a href="/product/<?= $item['product_id'] ?>">
                            <?= $item['product_name'] ?>
                        </a>
                    </td>

                    <td>$<?= number_format($item['product_price'], 2) ?></td>

                    <td>
                        <form method="POST" action="/cart/update" class="cart-qty-form">
                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                            <input type="number" name="quantity" value="<?= $item['item_quantity'] ?>" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </td>

                    <td>
                        $<?= number_format($item['product_price'] * $item['item_quantity'], 2) ?>
                    </td>

                    <td>
                        <form method="POST" action="/cart/remove">
                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <p><strong>Cart Total:</strong> $<?= number_format($cart_total, 2) ?></p>
            <a href="/checkout" class="checkout-btn">Proceed to Checkout</a>
        </div>

    <?php endif; ?>
</div>
