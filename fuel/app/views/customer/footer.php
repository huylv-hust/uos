<footer>

    <div class="inner">

        <ul>
            <li><a href="rules">利用規約</a></li>
            <li><a href="https://oshigoto-n.jp/privacy" target="_blank">個人情報保護方針</a></li>
            <li><a href="<?php echo \Fuel\Core\Uri::base(); ?>customer/contact">お問い合わせ</a></li>
            <?php if (\Fuel\Core\Session::get('login_info')) { ?>
            <li><a href="<?php echo \Fuel\Core\Uri::base(); ?>customer/account">アカウント情報</a></li>
            <li><a href="<?php echo \Fuel\Core\Uri::base(); ?>customer/logout">ログアウト</a></li>
            <?php } ?>
        </ul>

        <p>Copyright© U.O.S CORP. All right reserved.</p>

    </div>

</footer>

