<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Products';
ViewHelper::loadHeader($page_title);
?>
<div id="products-page" class="page center border-2 div-style-1">
    <div class="v-card-wrapper">
        <div class="v-card-outer">
            <div class="v-card-inner">
                <div class="v-card-front">
                    <h3>Lorem ipsum dolor sit amet</h3>
                </div>

                <div class="v-card-back">
                    <img src="placeholder.jpeg" class="v-card-image">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p><br>this is the back of the card<br>this is the back of the card<br>this is the back of the card<br>this is the back of the card<br>this is the back of the card</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="products-page" class="page center border-2 div-style-1">
    <div class="h-card-wrapper">
        <div class="h-card-outer">
            <div class="h-card-inner">
                <div class="h-card-front">
                    <h3>Lorem ipsum dolor sit amet</h3>
                </div>

                <div class="h-card-back">
                    <img src="placeholder.jpeg" class="h-card-image">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p><br>this is the back of the card<br>this is the back of the card<br>this is the back of the card<br>this is the back of the card<br>this is the back of the card</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
