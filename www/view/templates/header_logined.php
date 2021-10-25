<div class="header-box">
    <div class="title">
        <a href="./index.php">
            <img class="titlelogo" src="./image/logo.jpeg" alt="Baby Food Store">Baby Food Store
        </a>
    </div>
    <div class="headerright">
        <div class="userinfo">
    <p class="username">ユーザー名：<?php print (h($user['name'])); ?></p>
    <a class="nav-link" href="<?php print(ORDER_URL);?>">購入履歴</a>
    <a class="logout" href="<?php print(LOGOUT_URL);?>">ログアウト</a>
        </div>
        <div class="cartimage">
            <a href="./cart.php" class="cart"><img src="./image/cart.jpeg"></a>
        </div>
    </div>
</div>
<ul class="select_age">
    <a href="./age.php?age=0"><li class="age_list age_0">ごっくん期</li></a>
    <a href="./age.php?age=1"><li class="age_list age_1">もぐもぐ期</li></a>
    <a href="./age.php?age=2"><li class="age_list age_2">かみかみ期</li></a>
</ul>
