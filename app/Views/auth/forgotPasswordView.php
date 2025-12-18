<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Welcome to Moss Cabinet!';
?>

<div class="components-full-page-wrapper">
    <div id="forgot-password-form">
        <div class="form-section">
            <form method="POST" action="./sign-in">
                
                <input class="form-input" type="text" name="email-or-username" placeholder="Email or Username" id="email-or-username" required>
                <label class="form-label" for="email-or-username">Email Address or Username</label>

                <input class="form-input" type="password" name="password" placeholder="Password" id="password" required>
                <label class="form-label" for="password">Password</label>

                <input class="form-input" type="password" name="password-confirm" placeholder="Password" id="password" required>
                <label class="form-label" for="password-confirm">Password</label>

                <div class="form-button-sections">
                    <button class="form-button" type="submit">Change Password</button>
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