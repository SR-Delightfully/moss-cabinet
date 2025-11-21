<?php
use App\Helpers\ViewHelper;
/** @var array $cart_items */
/** @var float $cart_total */
$page_title = 'Checkout';
ViewHelper::loadHeader($page_title);
?>

<div class="container checkout-page">
    <h1>Checkout</h1>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty. Add items before checking out.</p>
        <?php return; ?>
    <?php endif; ?>

    <div class="checkout-grid">

        <!-- ===========================
             BILLING + SHIPPING FORM
             =========================== -->
        <form method="POST" action="/checkout/submit" class="checkout-form">

            <h2>Billing Information</h2>

            <label>
                Full Name<br>
                <input type="text" name="full_name" required>
            </label>

            <label>
                Email Address<br>
                <input type="email" name="email" required>
            </label>

            <h2>Shipping Address</h2>

            <label>
                Address Line 1<br>
                <input type="text" name="address_line_1" required>
            </label>

            <label>
                Address Line 2 (optional)<br>
                <input type="text" name="address_line_2">
            </label>

            <label>
                City<br>
                <input type="text" name="city" required>
            </label>

            <label>
                Postal Code<br>
                <input type="text" name="postal_code" required>
            </label>

            <label>
                Country<br>
                <input type="text" name="country" required>
            </label>

            <h2>Payment Method</h2>

            <label>
                <input type="radio" name="payment_method" value="credit_card" checked>
                Credit Card
            </label>

            <label>
                <input type="radio" name="payment_method" value="paypal">
                PayPal
            </label>

            <!-- A placeholder card input section -->
            <div class="payment-placeholder">
                <p>Payment details will be processed securely.</p>
            </div>

            <button type="submit" class="checkout-submit">Place Order</button>

        </form>


        <!-- ===========================
             ORDER SUMMARY
             =========================== -->
        <div class="order-summary">
            <h2>Order Summary</h2>

            <ul class="summary-items">
                <?php foreach ($cart_items as $item): ?>
                    <li class="summary-item">
                        <span><?= $item['product_name'] ?> (x<?= $item['item_quantity'] ?>)</span>
                        <strong>
                            $<?= number_format($item['product_price'] * $item['item_quantity'], 2) ?>
                        </strong>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="summary-total">
                <strong>Total:</strong>
                <span>$<?= number_format($cart_total, 2) ?></span>
            </div>
        </div>

    </div>
</div>
