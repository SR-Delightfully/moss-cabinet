<?php

use App\Helpers\LocalizationHelper;
use App\Helpers\UserContext;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize session and current user
UserContext ::init();
$currentUser = UserContext ::getCurrentUser();
$currentLang = $_SESSION['lang'] ?? 'en';

// Set language
LocalizationHelper ::setLanguage($currentLang);

// Define tabs
$column1 = [
    'collections' => ['key' => 'collections'],
    'categories' => ['key' => 'categories'],
    'products' => ['key' => 'products'],
];
$column2 = [
    "profile" => ['key' => 'Profile'],
    "wishlist" => ['key' => 'WishList'],
    "cart" => ['key' => 'Cart'],
    "order" => ['key' => 'Orders'],
    "settings" => ['key' => 'Settings'],
];

$tabs = $column1 + $column2;

if (UserContext ::isLoggedIn() && UserContext ::isAdmin()) {
    $tabs = ['admin' => ['key' => 'admin']] + $tabs;
}

// Add admin panel tab if user is admin
if (UserContext ::isLoggedIn() && UserContext ::isAdmin()) {
    $tabs = ['admin' => ['key' => 'admin']] + $tabs;
}
?>

</nav>
</body>

<footer id="footer-bar">
    <div id="footer-content" class="display-flex-row">
        <div id="footer-column-A">
            <ul id="tabs">
                <?php foreach ($column1 as $key => $tab): ?>
                    <li id="<?= $key ?>" class="tab">
                        <a href="./<?= $tab['key'] ?>">
                            <span class="tab-label"><?= LocalizationHelper ::get("navbar_content." . $tab['key']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>

        </div>
        <div id="footer-column-B">
            <?php foreach ($column2 as $key => $tab): ?>
                <li id="<?= $key ?>" class="tab">
                    <a href="./<?= $tab['key'] ?>">
                        <span class="tab-label"><?= LocalizationHelper ::get("user_dropdown_content." . $tab['key']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>

        </div>
    </div>
</footer>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggle = document.getElementById("drop-down");
        const menu = document.querySelector(".user-dropdown");

        toggle.addEventListener("click", () => {
            menu.classList.toggle("open");
        });
    });
</script>
</html>