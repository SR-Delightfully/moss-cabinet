<?php

use App\Helpers\ViewHelper;

/** @var array $categories */
$page_title = "Shop by Category";
ViewHelper ::loadHeader($page_title);

$categories = $data['categories'] ?? [];
$title = $data['title'] ?? '';
$message = $data['message'] ?? '';
?>

<form class="search-bar-form" id="search-bar" method="GET" action="categories">
    <input class="search-bar-input" type="text" name="search" placeholder="Search...">
    <button class="search-bar-button" type="submit"><img id="search-icon" src="/assets/images/search.svg" alt="star"
                                                         height="22rem" style="vertical-align: middle"></button>
</form>


<!--<section class="square-deco-container container">-->
<!--    <div class="square-deco-content ">-->
<!---->
<!--    </div>-->
<!--</section>-->
<!--<div class="square-deco-inner"></div>-->
<!--<div class="square-deco-square-left-top"></div>-->
<!--<div class="square-deco-square-left-bottom"></div>-->
<!--<div class="square-deco-square-right-top"></div>-->
<!--<div class="square-deco-square-right-bottom"></div>-->
<!--<div class="square-deco-tall"></div>-->
<!--<div class="square-deco-wide"></div>-->

<div class="collections container">
    <h1>Search Categories !</h1>
    <?php foreach ($categories as $category): ?>
        <section class="collection-block">
            <h2><?= $category['category_name'] ?></h2>
            <div class="product-grid">
                <?php if (!empty($category['products'])): ?>
                    <?php foreach ($category['products'] as $p): ?>
                        <a class="product-card" href="/product/<?= $p['product_id'] ?>">
                            <img src="/<?= $p['primary_image'] ?>" alt="<?= $p['product_name'] ?>">
                            <h3><?= $p['product_name'] ?></h3>
                            <p class="price">$<?= number_format($p['product_price'], 2) ?></p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
