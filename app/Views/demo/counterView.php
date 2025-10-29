<?php

use App\Helpers\ViewHelper;

$page_title = 'Counter';
ViewHelper::loadHeader($page_title);
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1>Visit Counter</h1>
    <p>You have visited this page <strong><?= $counter ?></strong> times.</p>

    <form method="POST" action="reset">
        <button type="submit">Reset Counter</button>
    </form>
</body>

</html>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
