<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Welcome to Moss Cabinet!';
ViewHelper::loadHeader($page_title);
?>
<p>Hello sign in page!</p>