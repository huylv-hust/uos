<h1>ログイン</h1>

<section>

    <p class="comment">メールアドレスと、パスワードを入力して「ログイン」ボタンを押してください。</p>

    <?php if (\Fuel\Core\Session::get_flash('error')) { ?>
        <div class="waiting">※ <?php echo \Fuel\Core\Session::get_flash('error'); ?></div>
    <?php } ?>

    <div class="login-box">

        <form method="post" class="login" action="">

            <ul>
                <li>
                    <p>メールアドレス</p>
                    <span class="red"><?php echo isset($validate['email']) ? $validate['email'] : ''; ?></span>
                    <input class="<?php echo isset($validate['email']) ? 'error_box' : ''; ?>" name="email" value="<?php echo \Fuel\Core\Input::post('email')?>" placeholder="" type="text">
                </li>
                <li>
                    <p>パスワード</p>
                    <span class="red"><?php echo isset($validate['password']) ? $validate['password'] : ''; ?></span>
                    <input  class="<?php echo isset($validate['password']) ? 'error_box' : ''; ?>" name="password" value="" placeholder="" type="password"></li>
            </ul>

            <p class="password"><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/reminder'?>">パスワードを忘れた方</a></p>

            <p class="btn">
                <input name="submit" value="ログイン" class="button" type="submit">
            </p>

        </form>

    </div>

    <ul class="info-text">
        <li><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/contact'?>">初めてご利用の方はこちら</a></li>
    </ul>

</section>

