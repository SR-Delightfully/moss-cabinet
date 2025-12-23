<?php

use App\Helpers\ViewHelper;
use \App\Helpers\UserContext;

$page_title = 'Welcome to Moss Cabinet!';
$user = UserContext ::getCurrentUser();

$orders = [];

$user = UserContext ::getCurrentUser();

$orders = [];

ViewHelper  ::loadHeader($page_title);
?>
<p>Hello Profile page!</p>

<div id="user-info-wrapper">
    <div id="profile-current-values">

        <section class="square-deco-container container">
            <div class="square-deco-content ">
                <div id="profile-top">
                    <img id="profile-image" src="./assets/placeholder.jpeg" alt="Profile image">
                    <h3 id="user-name"><?= $user['user_username'] ?></h3>
                </div>

                <div class="profile-section">
                    <p>Name
                        : <?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_first_name']) : 'USER FIRST NAME' ?>
                        , <?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_last_name']) : 'USER LAST NAME' ?></p>
                    <p>Email
                        : <?= !empty($user['user_email']) ? htmlspecialchars($user['user_email']) : 'USER EMAIL' ?></p>
                </div>

                <form id="profile-form">
                    <h3>Update your information ? </h3>
                    <div id="profile-top">
                        <input type="image" src="" atl="New profile picture <?= $user['user_username']?> ? " placeholder="New profile picture <?= $user['user_username'] ?> ?">
                        <input type="text" id="username" placeholder="<?= $user['user_username'] ?>">
                    </div>

                    <input type="text" id="First Name"
                           placeholder="<?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_first_name']) : 'USER FIRST NAME' ?>">
                    <input type="text" id="Last Name"
                           placeholder="<?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_last_name']) : 'USER LAST NAME' ?>">
                    <input type="text" id="Email"
                           placeholder="<?= !empty($user['user_email']) ? htmlspecialchars($user['user_email']) : 'USER EMAIL' ?>">
                    <input type="password" id="Password" placeholder="Password">
                    <input type="password" id="Confirm Password" placeholder="Confirm Password">

                </form>
            </div>
            <div class="square-deco-inner"></div>
            <div class="square-deco-square-left-top"></div>
            <div class="square-deco-square-left-bottom"></div>
            <div class="square-deco-square-right-top"></div>
            <div class="square-deco-square-right-bottom"></div>
            <div class="square-deco-tall"></div>
            <div class="square-deco-wide"></div>
        </section>
    </div>

</div>

<div id="user-info-wrapper">
    <div id="profile-current-values">

        <section class="square-deco-container container">
            <div class="square-deco-content ">
                <div id="profile-top">
                    <img id="profile-image" src="./assets/placeholder.jpeg" alt="Profile image">
                    <h3 id="user-name"><?= $user['user_username'] ?></h3>
                </div>

                <div class="profile-section">
                    <p>Name
                        : <?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_first_name']) : 'USER FIRST NAME' ?>
                        , <?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_last_name']) : 'USER LAST NAME' ?></p>
                    <p>Email
                        : <?= !empty($user['user_email']) ? htmlspecialchars($user['user_email']) : 'USER EMAIL' ?></p>
                </div>

                <form id="profile-form">
                    <h3>Update your information ? </h3>
                    <div id="profile-top">
                        <input type="image" src="" atl="New profile picture <?= $user['user_username']?> ? " placeholder="New profile picture <?= $user['user_username'] ?> ?">
                        <input type="text" id="username" placeholder="<?= $user['user_username'] ?>">
                    </div>

                    <input type="text" id="First Name"
                           placeholder="<?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_first_name']) : 'USER FIRST NAME' ?>">
                    <input type="text" id="Last Name"
                           placeholder="<?= !empty($user['user_first_name']) ? htmlspecialchars($user['user_last_name']) : 'USER LAST NAME' ?>">
                    <input type="text" id="Email"
                           placeholder="<?= !empty($user['user_email']) ? htmlspecialchars($user['user_email']) : 'USER EMAIL' ?>">
                    <input type="password" id="Password" placeholder="Password">
                    <input type="password" id="Confirm Password" placeholder="Confirm Password">

                </form>
            </div>
            <div class="square-deco-inner"></div>
            <div class="square-deco-square-left-top"></div>
            <div class="square-deco-square-left-bottom"></div>
            <div class="square-deco-square-right-top"></div>
            <div class="square-deco-square-right-bottom"></div>
            <div class="square-deco-tall"></div>
            <div class="square-deco-wide"></div>
        </section>
    </div>

</div>


