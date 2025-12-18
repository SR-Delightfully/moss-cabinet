<?php

use App\Helpers\LocalizationHelper;

$currentPath = $_SERVER['REQUEST_URI'] ?? '';

function is_active_path(string $path, string $currentPath): bool
{
    $normalized = '/' . ltrim($path, '/');
    return str_starts_with($currentPath, $normalized);
}
?>

<aside id="admin-side-bar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="admin-menu-tab">
                <strong class="small text-muted">
                    <?= LocalizationHelper::get('navbar_content.admin') ?>
                </strong>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link" href="#dashboard">
                    <?= LocalizationHelper::get('admin_sidebar.dashboard') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <span class="text-uppercase text-muted small">
                    <?= LocalizationHelper::get('admin_sidebar.management') ?>
                </span>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link" href="#users">
                    <?= LocalizationHelper::get('admin_sidebar.users') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link" href="#products">
                    <?= LocalizationHelper::get('admin_sidebar.products') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link small" href="#create-product">
                    <?= LocalizationHelper::get('admin_sidebar.create_product') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link" href="#categories">
                    <?= LocalizationHelper::get('admin_sidebar.categories') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link small" href="#create-category">
                    <?= LocalizationHelper::get('admin_sidebar.create_category') ?>
                </a>
            </li>

        </ul>
    </div>
</aside>

<script>
const sidebarLinks = document.querySelectorAll('#admin-side-bar .nav-link');

window.addEventListener('scroll', () => {
    // let fromTop = window.scrollY + 100; 
    sidebarLinks.forEach(link => {
        const section = document.querySelector(link.hash);
        if (section && section.offsetTop <= fromTop && section.offsetTop + section.offsetHeight > fromTop) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
</script>
