<?php
use App\Helpers\ViewHelper;
use App\Helpers\LocalizationHelper;
use App\Helpers\UserContext;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

UserContext::init();

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'] ?? 'en';
LocalizationHelper::setLanguage($currentLang);

$page_title    = $page_title ?? 'Moss Cabinet';
$isNavBarShown = $isNavBarShown ?? true;

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$basePath   = rtrim($_SERVER['BASE_PATH'] ?? '', '/');

$normalizedPath = $basePath && str_starts_with($requestUri, $basePath)
    ? substr($requestUri, strlen($basePath))
    : $requestUri;

$isAdminRoute = str_starts_with($normalizedPath, '/admin');
$isAdminView  = UserContext::isAdmin() && $isAdminRoute;
?>

<?php
if ($isAdminView) {
    ViewHelper::loadAdminHeader($page_title);
} else {
    ViewHelper::loadHeader($page_title);
}
?>

<?php if ($isNavBarShown && !$isAdminView): ?>
    <?php ViewHelper::loadNavBar(); ?>
<?php endif; ?>

<div id="page-content">
    <?php require $contentView; ?>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
