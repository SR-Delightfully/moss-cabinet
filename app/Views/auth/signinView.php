<?php

use App\Helpers\ViewHelper;
$page_title = 'Welcome to Moss Cabinet!';
ViewHelper::loadHeader($page_title);
?>

<p>Hello sign in page!</p>
<div id="signin-form">
    <div class="lang-switcher">
        <a href="">EN</a>
        <a href="">FR</a> 
    </div>
     <div class="form-section">
    <form method="POST" action="">
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