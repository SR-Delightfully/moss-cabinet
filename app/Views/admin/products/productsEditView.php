<?php

use App\Helpers\ViewHelper;


//TODO: set the page title dynamically based on the view being rendered in the controller.
// $page_title = 'Products list';
$page_title = $data["page_title"];
$products = $data["products"];

//TODO: We need to load an admin-specific header.
ViewHelper::loadAdminHeader($page_title);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<h2>Edit Products:</h2>
</main>

<?php

ViewHelper::loadJsScripts();
//TODO: We need to load an admin-specific footer.
ViewHelper::loadAdminFooter();
?>
