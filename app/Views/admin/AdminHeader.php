<!DOCTYPE html>
<html lang="en" data-theme="lights-on">

<?php

use App\Helpers\UserContext;
use App\Helpers\LocalizationHelper;


// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set the language for translations
$lang = $_SESSION['lang'] ?? 'en';
\App\Helpers\LocalizationHelper::setLanguage($lang);

UserContext::init();
$currentUser = UserContext::getCurrentUser();

// get current request path for active highlight
$currentPath = $_SERVER['REQUEST_URI'] ?? '';

// helper to check active paths
function is_active_path(string $path, string $currentPath): bool {
    $normalized = '/' . ltrim($path, '/');
    return strpos($currentPath, $normalized) === 0;
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Admin Dashboard' ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/assets/css/00-Global-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/01-Authorization-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/02-Home-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/03-Checkout-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/04-Profile-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/05-Categories-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/06-Collections-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/07-Products-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/08-Product-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/09-Settings-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/11-NavBar-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/12-Footer-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/13-NavBar-Styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Bilbo+Swash+Caps&family=Bonheur+Royale&family=Corinthia:wght@400;700&family=Eagle+Lake&family=Edu+NSW+ACT+Cursive:wght@400..700&family=Manufacturing+Consent&family=Moon+Dance&family=Playwrite+NL:wght@100..400&family=Qwigley&display=swap" rel="stylesheet">
</head>

<body>

<?php if (UserContext::isLoggedIn() && UserContext::isAdmin()): ?>
<div class="container-fluid">
    <div class="row">
<!-- ADMIN SIDEBAR -->
<nav id="admin-sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="nav-item mb-2 px-3">
                <strong class="small text-muted">
                    <?= LocalizationHelper::get('navbar_content.admin') ?>
                </strong>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= is_active_path('admin', $currentPath) ? 'active' : '' ?>"
                   href="./admin/">
                    <?= LocalizationHelper::get('admin_sidebar.dashboard') ?>
                </a>
            </li>

            <li class="nav-item mt-3 px-3">
                <span class="text-uppercase text-muted small">
                    <?= LocalizationHelper::get('admin_sidebar.management') ?>
                </span>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= is_active_path('admin/users', $currentPath) ? 'active' : '' ?>"
                   href="./users">
                    <?= LocalizationHelper::get('admin_sidebar.users') ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= is_active_path('admin/products', $currentPath) ? 'active' : '' ?>"
                   href="./products">
                    <?= LocalizationHelper::get('admin_sidebar.products') ?>
                </a>
            </li>

            <li class="nav-item ms-3">
                <a class="nav-link small <?= is_active_path('admin/products/create', $currentPath) ? 'active' : '' ?>"
                   href="./products/create">
                    <?= LocalizationHelper::get('admin_sidebar.create_product') ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= is_active_path('admin/categories', $currentPath) ? 'active' : '' ?>"
                   href="./categories">
                    <?= LocalizationHelper::get('admin_sidebar.categories') ?>
                </a>
            </li>

            <li class="nav-item ms-3">
                <a class="nav-link small <?= is_active_path('admin/categories/create', $currentPath) ? 'active' : '' ?>"
                   href="./categories/create">
                    <?= LocalizationHelper::get('admin_sidebar.create_category') ?>
                </a>
            </li>

        </ul>
    </div>
</nav>

<?php endif; ?>
