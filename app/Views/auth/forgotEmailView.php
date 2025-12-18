<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Welcome to Moss Cabinet!';
?>

<div class="components-full-page-wrapper">
    <div id="forgot-password-form">
        <div class="form-section">
            <form method="POST" action="./sign-in">
                <input class="form-input" type="text" name="email" placeholder="Email" id="email" required>
                <label class="form-label" for="username">Username</label>

                <input class="form-input" type="password" name="email" placeholder="Password" id="password" required>
                <label class="form-label" for="password">Email</label>

                <input class="form-input" type="password" name="email-confirm" placeholder="Password" id="password" required>
                <label class="form-label" for="email-confirm">Email Confirm</label>

                <div class="form-button-sections">
                    <button class="form-button" type="submit">Change Email</button>
                    <br>
                    <a href="./sign-in">Ready to sign in?</a> <br>
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