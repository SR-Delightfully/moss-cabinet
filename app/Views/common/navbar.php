<?php
use App\Helpers\LocalizationHelper;
use App\Helpers\UserContext;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize session and current user
UserContext::init();
$currentUser = UserContext::getCurrentUser();
$currentLang = $_SESSION['lang'] ?? 'en';

// Set language
LocalizationHelper::setLanguage($currentLang);

// Define tabs
$tabs = [
    'collections' => ['key' => 'collections'],
    'categories'  => ['key' => 'categories'],
    'products'    => ['key' => 'products'],
];

// Add admin panel tab if user is admin
if (UserContext::isLoggedIn() && UserContext::isAdmin()) {
    $tabs = ['admin' => ['key' => 'admin']] + $tabs;
}
?>

<nav id="nav-bar" class="display-flex-row">
    <a id="brand" class="bilbo-swash-caps-regular" href="home">
        <h1>M<i class="corinthis-bold">oss</i> C<i class="corinthis-bold">abinet</i></h1>
    </a>
    <img class="sparkle-icon" src="https://svgsilh.com/svg/35893.svg">

    <div id="nav-bar-content" class="display-flex-row">
        <ul id="tabs">
            <?php foreach ($tabs as $key => $tab): ?>
                <li id="<?= $key ?>" class="tab">
                    <a href="./<?= $tab['key'] ?>">
                        <span class="tab-label"><?= LocalizationHelper::get("navbar_content." . $tab['key']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div id="nav-bar-user" class="display-flex-col">
            <?php if ($currentUser): ?>
                <h4>Merry meet, <?= htmlspecialchars($currentUser['user_first_name'] ?? 'Guest') ?> <?= htmlspecialchars($currentUser['user_last_name'] ?? '') ?>!</h4>
                <button class="dropdown-toggle" id="drop-down">User dropdown ➤</button>
                <ul class="user-dropdown">
                    <li><a href="profile"><?= LocalizationHelper::get("user_dropdown_content.option1") ?></a></li>
                    <li><a href="wishlist"><?= LocalizationHelper::get("user_dropdown_content.option2") ?></a></li>
                    <li><a href="cart"><?= LocalizationHelper::get("user_dropdown_content.option3") ?></a></li>
                    <li><a href="orders"><?= LocalizationHelper::get("user_dropdown_content.option4") ?></a></li>
                    <li><a href="settings"><?= LocalizationHelper::get("user_dropdown_content.option5") ?></a></li>
                    <li><a href="sign-out"><?= LocalizationHelper::get("user_dropdown_content.option6") ?></a></li>
                </ul>

                <?php if (!empty($currentUser['user_pfp_src'])): ?>
                    <a href="profile.php?user=<?= urlencode($currentUser['user_username']) ?>">
                        <img id="pfp" src="<?= htmlspecialchars($currentUser['user_pfp_src']) ?>" alt="pfp" />
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <h5>Merry meet, Anonymous one!</h5>
                <button class="dropdown-toggle" id="drop-down">User dropdown</button>
                <ul class="user-dropdown">
                    <li><a href="sign-in"><?= LocalizationHelper::get("user_dropdown_content.anon1") ?></a></li>
                    <li><a href="sign-up"><?= LocalizationHelper::get("user_dropdown_content.anon2") ?></a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
