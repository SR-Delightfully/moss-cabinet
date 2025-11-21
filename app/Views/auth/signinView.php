<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Welcome to Moss Cabinet!';
ViewHelper::loadHeader($page_title);
?>

<p>Hello sign in page!</p>

<div id="signin-form">
    <?= FlashMessage::render() ?>
    <div class="lang-switcher">
        <a href="">EN</a>
        <a href="">FR</a> 
    </div>
    <div class="form-section">
        <form method="POST" action="./sign-in">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <a href="#">Forgot Password?</a>

            <div>
                <button type="submit">Sign In</button>
                <a href="./sign-up">Don't have an account?</a>
            </div>
        </form>
    </div>
</div>