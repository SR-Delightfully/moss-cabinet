<?php
use App\Helpers\UserContext;

$currentUser = UserContext::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en" data-theme="lights-on">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/00-Global-Styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Bilbo+Swash+Caps&family=Bonheur+Royale&family=Corinthia:wght@400;700&family=Eagle+Lake&family=Edu+NSW+ACT+Cursive:wght@400..700&family=Manufacturing+Consent&family=Moon+Dance&family=Playwrite+NL:wght@100..400&family=Qwigley&display=swap" rel="stylesheet">
</head>

<body>
    <header id="top-bar">
        <nav id="nav-bar" class="display-flex-row"> 
            <a id="brand" class="bilbo-swash-caps-regular" href="home"><h1>M<i class="corinthis-bold">oss</i> C<i class="corinthis-bold">abinet</i></h1></a>
            <img class="sparkle-icon" src="https://svgsilh.com/svg/35893.svg">
            <div id="nav-bar-content" class="display-flex-row">
                <ul id="nav-tabs" class="display-flex-row border-2">
                    <li class="nav-tab"><a href="about">W<i>ho</i> A<i>re</i> W<i>e</i></a></li>
                    <li class="nav-tab"><a href="shops">O<i>ur</i> C<i>ollections</i></a></li>
                    <li class="nav-tab"><a href="products">O<i>ur</i> P<i>roducts</i></a></li>
                </ul>
                <div id="nav-bar-user" class=" display-flex-col">
                <?php if ($currentUser): ?>
                    <h4>Merry meet, <?= htmlspecialchars($currentUser['user_fname']) ?> <?= htmlspecialchars($currentUser['user_lname']) ?>!</h4>
                    <button class="dropdown-toggle" id="drop-down">User dropdown ➤</button>
                    <ul class="user-dropdown">
                        <li><a href="profile">Profile</a></li>
                        <li><a href="wishlist">Wishlist</a></li>
                        <li><a href="cart">Cart</a></li>
                        <li><a href="orders">Orders</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li><a href="logout.php">Sign Out</a></li>
                    </ul>

                    <?php if (!empty($currentUser['user_pfp_src'])): ?>
                        <a href="profile.php?user=<?= urlencode($currentUser['user_name']) ?>">
                        <img id="pfp" src="<?= htmlspecialchars($currentUser['user_pfp_src']) ?>" alt="pfp" />
                        </a>
                    <?php endif; ?>
                 <?php else: ?>
                    <h5>Merry meet, Anonymous one!</h5>
                    <button class="dropdown-toggle" id="drop-down">User dropdown</button>
                    <ul class="user-dropdown">
                        <li><a href="login.php">Login</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    </ul>
                <?php endif; ?>
            </div>    
        </nav>
</header>
