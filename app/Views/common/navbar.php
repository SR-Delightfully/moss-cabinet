<?php
use App\Helpers\LocalizationHelper;
use App\Helpers\UserContext;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ----------------------------
   INIT USER + LANGUAGE
----------------------------- */
UserContext::init();
$currentUser = UserContext::getCurrentUser();
$currentLang = $_SESSION['lang'] ?? 'en';
LocalizationHelper::setLanguage($currentLang);

/* ----------------------------
   THEME SESSION BOOTSTRAP
----------------------------- */
// Default theme logic (adjust if needed)
if (!isset($_SESSION['theme'])) {
    if ($currentUser) {
        // Example rule: admins default to lights-on
        $_SESSION['theme'] = UserContext::isAdmin()
            ? 'lights-on'
            : 'lights-off';
    } else {
        $_SESSION['theme'] = 'lights-off';
    }
}

// Handle AJAX theme update (no controller)
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['theme'])
    && in_array($_POST['theme'], ['lights-on', 'lights-off'], true)
) {
    $_SESSION['theme'] = $_POST['theme'];
    http_response_code(204);
    exit;
}

/* ----------------------------
   NAV TABS
----------------------------- */
$tabs = [
    'collections' => ['key' => 'collections'],
    'categories'  => ['key' => 'categories'],
    'products'    => ['key' => 'products'],
];

if (UserContext::isLoggedIn() && UserContext::isAdmin()) {
    $tabs = ['admin' => ['key' => 'admin']] + $tabs;
}

$isLightsOn = $_SESSION['theme'] === 'lights-on';
?>

<!-- <html data-theme="<?= htmlspecialchars($_SESSION['theme']) ?>"> -->

<nav id="nav-bar" class="display-flex-row">

    <a id="brand" class="bilbo-swash-caps-regular" href="home">
        <h1>
            M<i class="corinthis-bold">oss</i>
            C<i class="corinthis-bold">abinet</i>
        </h1>
    </a>

    <img
        id="theme-toggle"
        class="sparkle-icon"
        src="<?= $isLightsOn
            ? 'https://svgsilh.com/svg/35893.svg'
            : 'https://www.svgrepo.com/show/117298/crescent-moon-and-star.svg'
        ?>"
        alt="Theme toggle"
        title="<?= $isLightsOn ? 'Lights on' : 'Lights off' ?>"
    />

    <div id="nav-bar-content" class="display-flex-row">

        <ul id="tabs">
            <?php foreach ($tabs as $key => $tab): ?>
                <li id="<?= $key ?>" class="tab">
                    <a href="./<?= $tab['key'] ?>">
                        <span class="tab-label">
                            <?= LocalizationHelper::get("navbar_content." . $tab['key']) ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div id="nav-bar-user" class="display-flex-col">

            <?php if ($currentUser): ?>
                <h4>
                    Merry meet,
                    <?= htmlspecialchars($currentUser['user_first_name'] ?? 'Guest') ?>
                    <?= htmlspecialchars($currentUser['user_last_name'] ?? '') ?>!
                </h4>

                <button class="dropdown-toggle" id="drop-down">
                    User dropdown
                </button>

                <ul class="user-dropdown">
                    <li><a href="/profile"><?= LocalizationHelper::get("Profile") ?></a></li>
                    <li><a href="/wishlist"><?= LocalizationHelper::get("Wishlist") ?></a></li>
                    <li><a href="/cart"><?= LocalizationHelper::get("Cart") ?></a></li>
                    <li><a href="/orders"><?= LocalizationHelper::get("Orders") ?></a></li>
                    <li><a href="/settings"><?= LocalizationHelper::get("Settings") ?></a></li>
                    <li><a href="/sign-out"><?= LocalizationHelper::get("Sign out") ?></a></li>
                </ul>

                <?php if (!empty($currentUser['user_pfp_src'])): ?>
                    <a href="profile.php?user=<?= urlencode($currentUser['user_username']) ?>">
                        <img
                            id="pfp"
                            src="<?= htmlspecialchars($currentUser['user_pfp_src']) ?>"
                            alt="Profile picture"
                        />
                    </a>
                <?php endif; ?>

            <?php else: ?>
                <h5>Merry meet, Anonymous one!</h5>

                <button class="dropdown-toggle" id="drop-down">
                    User dropdown
                </button>

                <ul class="user-dropdown">
                    <li>
                        <a href="sign-in">
                            <?= LocalizationHelper::get("user_dropdown_content.signintext") ?>
                        </a>
                    </li>
                    <li>
                        <a href="sign-up">
                            <?= LocalizationHelper::get("user_dropdown_content.signouttext") ?>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

        </div>
    </div>
</nav>

<script>
(() => {
    const toggle = document.getElementById('theme-toggle');
    if (!toggle) return;

    const ICONS = {
        'lights-off': 'https://svgsilh.com/svg/35893.svg',
        'lights-on':  'https://www.svgrepo.com/show/117298/crescent-moon-and-star.svg'
    };

    function currentTheme() {
        return document.documentElement.dataset.theme;
    }

    function applyTheme(theme) {
        document.documentElement.dataset.theme = theme;
        toggle.src = ICONS[theme];
        toggle.title = theme === 'lights-on' ? 'Lights on' : 'Lights off';

        fetch(window.location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'theme=' + encodeURIComponent(theme)
        });
    }

    toggle.addEventListener('click', () => {
        applyTheme(
            currentTheme() === 'lights-on'
                ? 'lights-off'
                : 'lights-on'
        );
    });
})();
</script>
