<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Home';
ViewHelper::loadHeader($page_title);
?>

<h1>Slim Framework-based MVC Application</h1>
<p>This is a simple MVC application built with Slim Framework.</p>

<p>This app uses a simple and effective way to pass the container to the controller given the small scope of the application and the fact that this application is to be used in a classroom setting where students are not yet familiar with the Dependency Inversion Principle.</p>

<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos. </p>
<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos. </p>


<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>