<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Welcome to Moss Cabinet!';
?>

<div class="components-full-page-wrapper">
    <div id="signin-form">
        <div class="form-section">
            <form method="POST" action="./sign-in">
                <input class="form-input" type="text" name="email" placeholder="Email" id="email" required>
                <label class="form-label" for="email">Email Address</label>

                <input class="form-input" type="password" name="Password" placeholder="Password" id="password" required>
                <label class="form-label" for="password">Password</label>

                <div class="form-button-sections">
                    <button class="form-button" type="submit">Sign In</button>
                    <br>
                    <a href="#">Forgot Password?</a> <br>
                    <a href="./sign-up">Don't have an account?</a>

                    <?= FlashMessage ::render() ?>
                    <div class="lang-switcher">
                        <a href="">EN</a>
                        <a href="">FR</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>