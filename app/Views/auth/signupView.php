<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Welcome to Moss Cabinet!';
ViewHelper::loadHeader($page_title);
?>

<p>Hello sign up page!</p>

<div id="signup-form">
    <?= FlashMessage::render() ?>
    <div class="lang-switcher">
        <a href="">EN</a>
        <a href="">FR</a> 
    </div>
    <div class="form-section">
      <form method="POST" action="./sign-up">
          <div class="form-subsection">
              <span>
                  <label for="first-name">First Name:</label>
                  <input type="text" name="first_name" id="first-name" required>
              </span>
              <span>
                  <label for="last-name">Last Name:</label>
                  <input type="text" name="last_name" id="last-name" required>
              </span>
          </div>

          <label for="email">Email Address:</label>
          <input type="text" name="email" id="email" required>

          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required>

          <label for="confirm-password">Confirm Password:</label>
          <input type="password" name="confirm_password" id="confirm-password" required>

          <a href="./sign-in">Already have an account? Sign in</a>

          <div>
              <button type="submit">Sign Up</button>
          </div>
      </form>

    </div>
</div>
