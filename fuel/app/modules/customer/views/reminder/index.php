<h1>パスワードを忘れた方</h1>

<p class="comment">パスワードをお忘れの方は、ご登録メールアドレスをご入力ください。<br>ご登録メールアドレスに仮パスワードを発行いたします。</p>

<?php if (\Fuel\Core\Session::get_flash('error')) { ?>
    <div class="waiting">※ <?php echo \Fuel\Core\Session::get_flash('error'); ?></div>
<?php } ?>

<section>

    <div class="login-box">

        <form method="post" class="login">

            <ul>
                <li>
                    <p>メールアドレス</p>
                    <span class="red"><?php echo isset($validate['email']) ? $validate['email'] : ''; ?></span>
                    <?php echo Form::input('email', Input::post('email'), ['placeholder' => 'メールアドレスを入力してください', 'type' => 'text', 'class' => isset($validate['email']) ? 'error_box' : ''] )?>
                </li>
            </ul>

            <p class="btn">
                <input name="submit" value="入力内容を確認する" class="button" type="submit">
            </p>

        </form>

    </div>

</section>
