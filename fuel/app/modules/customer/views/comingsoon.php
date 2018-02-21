<?php if (\Fuel\Core\Session::get('login_info')) { ?>
<ul class="navi">
    <li><a href="<?php echo Uri::base() . 'customer/jobs'; ?>">求人管理</a></li>
    <li><a href="<?php echo Uri::base() . 'customer/persons'; ?>">応募者管理</a></li>
    <li><a href="<?php echo Uri::base() . 'customer/summary'; ?>">サマリー</a></li>
    <li><a href="<?php echo Uri::base() . 'customer/shops'; ?>">店舗管理</a></li>
</ul>
<?php } ?>

<h1>準備中です</h1>

<section>
    <div class="complete-01">
        <h2>本ページは準備中です</h2>
    </div>
</section>
