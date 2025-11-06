<?php

use App\Helpers\ViewHelper;
use App\Controllers\DashboardController;
use App\Helpers\SessionManager;
use App\Middleware\ExceptionMiddleware;
use App\MiddleWare\SessionMiddleware;

//TODO: set the page title dynamically based on the view being rendered in the controller.
// $page_title = 'Products list';
$page_title = $data["page_title"];
$products = $data["categories"];

//TODO: We need to load an admin-specific header.
ViewHelper::loadAdminHeader($page_title);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Share
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Export
                </button>
            </div>
            <button
                type="button"
                class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi" aria-hidden="true">
                    <use xlink:href="#calendar3"></use>
                </svg>
                This week
            </button>
        </div>
    </div>
    <h2>Product Listing</h2>
    <div class="table-responsive small">
        <h4> <?php echo SessionManager::get('username') ?> </h4>
        <table table-striped>
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock Qty</th>
                <th>Created At</th>
            </thead>
            <tbody>
                <?php foreach ($data["products"] as $key => $prod): ?>
                    <tr>
                        <td><?= $hs($prod['id']) ?></td>

                        <td><?= $prod["name"] ?></td>
                        <td><?= $prod["description"] ?></td>
                        <td><?= $prod["price"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
        </p>
    </div>
</main>

<?php

ViewHelper::loadJsScripts();
//TODO: We need to load an admin-specific footer.
ViewHelper::loadAdminFooter();
?>
