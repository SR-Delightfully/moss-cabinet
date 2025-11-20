<?php

use App\Helpers\ViewHelper;
$page_title = 'Welcome to Moss Cabinet!';
ViewHelper::loadHeader($page_title);
?>

<p>Hello sign up page!</p>

<div id="signup-form">
    <div class="lang-switcher">
        <a href="">EN</a>
        <a href="">FR</a> 
    </div>
     <div class="form-section">
    <form method="POST" action="/signup">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>

      <div class="form-subsection">
        <span>
          <label for="first-name">First Name:</label>
          <input type="text" name="first-name" id="first-name" required>
        </span>
        <span>
          <label for="last-name">Last Name:</label>
          <input type="text" name="last-name" id="last-name" required>
        </span>
      </div>

      <label for="email">Email Address:</label>
      <input type="text" name="email" id="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" name="confirm-password" id="confirm-password" required>
      <a href="#">Already have an account? Sign in</a>

      <div>
        <button type="submit">Sign Up</button>
      </div>
    </form>
  </div>
</div>