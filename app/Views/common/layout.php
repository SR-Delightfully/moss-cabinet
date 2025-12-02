<?php
use App\Helpers\ViewHelper;
use App\Helpers\LocalizationHelper;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'] ?? 'en';
LocalizationHelper::setLanguage($currentLang);

$page_title = $page_title ?? 'Moss Cabinet';
$isNavBarShown = $isNavBarShown ?? true;
?>

<?php ViewHelper::loadHeader($page_title); ?>

<?php if ($isNavBarShown): ?>
    <?php ViewHelper::loadNavBar(); ?>
<?php endif; ?>

<div id="page-content">
    <?php require $contentView; ?>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
