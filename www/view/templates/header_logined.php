<div class="header-box">
    <div class="title">
        <a href="./top.php">
            <img class="titlelogo" src="./image/logo.jpeg" alt="Baby Food Store">Baby Food Store
        </a>
    </div>
    <div class="headerright">
        <div class="userinfo">
            <p class="username">ユーザー名：<?php print htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?></p>
            <a class="logout" href="./logout.php">ログアウト</a>
        </div>
        <div class="cartimage">
            <a href="./cart.php" class="cart"><img src="./image/cart.jpeg"></a>
        </div>
    </div>
</div>