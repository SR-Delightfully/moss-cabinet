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
                    <a href="./forgot-email">Forgot Email?</a> <br>


                <input class="form-input" type="password" name="password" placeholder="Password" id="password" required>
                <label class="form-label" for="password">Password</label>
                    <a href="./forgot-password">Forgot Password?</a> <br>


                <div class="form-button-sections">
                    <button class="form-button" type="submit">Sign In</button>
                    <br>
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
