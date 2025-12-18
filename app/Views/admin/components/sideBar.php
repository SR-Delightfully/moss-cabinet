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
                <a class="nav-link <?= is_active_path('admin', $currentPath) ? 'active' : '' ?>"
                   href="/admin">
                    <?= LocalizationHelper::get('admin_sidebar.dashboard') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <span class="text-uppercase text-muted small">
                    <?= LocalizationHelper::get('admin_sidebar.management') ?>
                </span>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link <?= is_active_path('admin/users', $currentPath) ? 'active' : '' ?>"
                   href="/admin/users">
                    <?= LocalizationHelper::get('admin_sidebar.users') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link <?= is_active_path('admin/products', $currentPath) ? 'active' : '' ?>"
                   href="/admin/products">
                    <?= LocalizationHelper::get('admin_sidebar.products') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link small <?= is_active_path('admin/products/create', $currentPath) ? 'active' : '' ?>"
                   href="/admin/products/create">
                    <?= LocalizationHelper::get('admin_sidebar.create_product') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link <?= is_active_path('admin/categories', $currentPath) ? 'active' : '' ?>"
                   href="/admin/categories">
                    <?= LocalizationHelper::get('admin_sidebar.categories') ?>
                </a>
            </li>

            <li class="admin-menu-tab">
                <a class="nav-link small <?= is_active_path('admin/categories/create', $currentPath) ? 'active' : '' ?>"
                   href="/admin/categories/create">
                    <?= LocalizationHelper::get('admin_sidebar.create_category') ?>
                </a>
            </li>

        </ul>
    </div>
</aside>
