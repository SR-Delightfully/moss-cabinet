<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Welcome to Moss Cabinet!';
ViewHelper ::loadHeader($page_title);
?>
<div class="components-full-page-wrapper">
    <div id="signup-form">
        <div class="form-section" id="signup-form-section">
            <form method="POST" action="./sign-up">
                <div class="form-subsection">
              <span>
                  <input type="text" class="form-input" name="first_name" id="first-name" placeholder="First Name"
                         required>
                  <label class="form-label" for="first-name">First Name:</label>
              </span>
                    <span>
                  <input class="form-input" type="text" name="last_name" id="last-name" placeholder="Last Name"
                         required>
                  <label class="form-label" for="last-name">Last Name:</label>
              </span>
                </div>

                <input class="form-input" type="text" name="email" id="email" placeholder="Email" required>
                <label class="form-label" for="email">Email Address:</label>

                <input class="form-input" type="password" name="password" id="password" placeholder="Password" required>
                <label class="form-label" for="password">Password:</label>

                <input class="form-input" type="password" name="confirm_password" id="confirm-password"
                       placeholder="Confirm Password" required>
                <label class="form-label" for="confirm-password">Confirm Password:</label>

                <div class="form-button-sections">
                    <button class="form-button" type="submit">Sign Up</button>
                    <a href="./sign-in">Already have an account? Sign in</a>
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