<?php

use App\Helpers\ViewHelper;

$page_title = 'Flash Demo';
ViewHelper::loadHeader($page_title);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Flash Demo') ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($title ?? 'Flash Demo') ?></h1>

        <!-- Flash Messages Display Area -->
        <div class="mb-4">
            <?= App\Helpers\FlashMessage::render() ?>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Test Flash Messages</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Click the buttons below to test different types of flash messages:</p>

                <div class="d-grid gap-2">
                    <form method="POST" action="flash/success">
                        <button type="submit" class="btn btn-success w-100">
                            Show Success Message
                        </button>
                    </form>

                    <form method="POST" action="flash/error">
                        <button type="submit" class="btn btn-danger w-100">
                            Show Error Message
                        </button>
                    </form>

                    <form method="POST" action="flash/info">
                        <button type="submit" class="btn btn-info w-100">
                            Show Info Message
                        </button>
                    </form>

                    <form method="POST" action="flash/warning">
                        <button type="submit" class="btn btn-warning w-100">
                            Show Warning Message
                        </button>
                    </form>

                    <form method="POST" action="flash/multiple">
                        <button type="submit" class="btn btn-primary w-100">
                            Show Multiple Messages
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4" role="alert">
            <strong>Note:</strong> Flash messages appear once and then disappear. Refresh the page to clear any visible messages.
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
