<ul class="navi">
    <!--<li><a href="">実績</a></li>-->
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/jobs">求人管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/persons">応募者管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/summary">サマリー</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/shops">店舗管理</a></li>
</ul>

<h1>メールアドレス変更</h1>

<section>
    <div class="complete-03">
        <h2>メールを送信しました</h2>

        <p>
            メールアドレスの変更申請がありましたので一旦ログアウトしてください。<br>
            入力された新しいメールアドレスに、確認用ＵＲＬをお送りしますので、クリックして再度ログインしてください。<br>
            1時間たってもメールが届かない場合は間違い等が考えられますので、再度ログインし変更手続きを行ってください。
        </p>

        <ul>
            <li><a href="<?php echo \Fuel\Core\Uri::base() ?>/customer/logout">ログアウト</a></li>
        </ul>
    </div>
</section>
