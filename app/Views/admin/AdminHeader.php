<?php
use App\Helpers\UserContext;
use App\Helpers\LocalizationHelper;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$lang = $_SESSION['lang'] ?? 'en';
LocalizationHelper::setLanguage($lang);

UserContext::init();

// Only allow admins
if (!UserContext::isAdmin()) {
    exit('Access denied.');
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="lights-off">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title ?? 'Admin') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">

    <!-- Global & Admin Styles -->
    <link rel="stylesheet" href="./public/assets/css/00-Global-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/11-Navbar-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/12-Footer-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/13-Admin-styles.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Bilbo+Swash+Caps&family=Bonheur+Royale&display=swap" rel="stylesheet">
</head>
<body>

<div id="admin-layout">

    <!-- Top bar -->
    <div id="admin-top-bar">
        <?php require __DIR__ . '/components/topbar.php'; ?>
    </div>

    <!-- Sidebar -->
    <?php require __DIR__ . '/components/sidebar.php'; ?>

    <!-- Main content -->
    <div id="admin-side-content">
        <?= $adminContent ?? '' ?>
    </div>

</div>

<?php
use App\Helpers\ViewHelper;
ViewHelper::loadJsScripts();
?>
</body>
</html>
