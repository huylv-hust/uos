<main role="main">

    <ul class="navi">
        <!--<li><a href="">実績</a></li>-->
        <li><a href="<?php echo \Fuel\Core\Uri::base() ?>customer/jobs">求人管理</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base() ?>customer/persons">応募者管理</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base() ?>customer/summary">サマリー</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base() ?>customer/shops">店舗管理</a></li>
    </ul>

    <h1>パスワード変更</h1>


    <?php if (\Fuel\Core\Session::get_flash('error')) { ?>
        <div class="waiting">※ <?php echo \Fuel\Core\Session::get_flash('error'); ?></div>
    <?php } ?>

    <section>
        <div class="page01-box">
            <form id="fm_action" method="post" class="h-adr" action="">
                <table>

                    <!-- パスワード -->
                    <tbody>
                    <tr>
                        <th><p>パスワード</p>
                        </th>
                        <td>
                            <span
                                class="red"><?php echo isset($validate['password']) ? $validate['password'] : ''; ?></span>
                            <?php echo Form::input('password', Input::post('password'), ['placeholder' => 'パスワードを入力してください', 'type' => 'password', 'maxlength' => '50', 'class' => isset($validate['password']) ? 'wth_50 error_box' : 'wth_50']) ?>
                            <p class="atn">※英数8文字以上</p>
                        </td>
                    </tr>

                    <!-- パスワード確認 -->
                    <tr>
                        <th><p>パスワード確認</p>
                        </th>
                        <td>
                            <span
                                class="red"><?php echo isset($validate['password_check']) ? $validate['password_check'] : ''; ?></span>
                            <?php echo Form::input('password_check', Input::post('password_check'), ['placeholder' => '確認のため再度入力してください', 'type' => 'password', 'maxlength' => '50', 'class' => isset($validate['password_check']) ? 'wth_50 error_box' : 'wth_50']) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- 送信ボタン START -->
                <ul class="transmission">
                    <li>
                        <input value="登録する" id="fm_btn_confirm" type="submit">
                    </li>
                </ul>
                <!-- 送信ボタン END -->

            </form>
        </div>
    </section>
</main>
