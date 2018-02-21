<ul class="navi">
    <!--<li><a href="">実績</a></li>-->
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/jobs">求人管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/persons">応募者管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/summary">サマリー</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/shops">店舗管理</a></li>
</ul>

<h1>メールアドレス変更</h1>

<?php if (\Fuel\Core\Session::get_flash('error')) { ?>
    <div class="waiting">※ <?php echo \Fuel\Core\Session::get_flash('error'); ?></div>
<?php } ?>

<section>
    <div class="page01-box">
        <form id="fm_action" method="post" class="h-adr" action="<?php echo \Fuel\Core\Uri::base() ?>customer/email/confirm">
            <table>
                <tr>
                    <th>
                        <p>現在のメールアドレス</p>
                    </th>
                    <td>
                        <?php echo $current_email ?>
                    </td>
                </tr>

                <tr>
                    <th>
                        <p>変更後メールアドレス</p>
                    </th>
                    <td>
                        <span class="red"><?php echo isset($validate['email']) ? $validate['email'] : ''; ?></span>
                        <?php echo Form::input('email', Input::post('email'), ['placeholder' => 'メールアドレスを入力してください', 'type' => 'text', 'maxlength' => '767', 'class' => isset($validate['email']) ? 'error_box' : ''] )?>
                    </td>
                </tr>

                <tr>
                    <th>
                        <p>メールアドレス確認</p>
                    </th>
                    <td>
                        <span class="red"><?php echo isset($validate['email_check']) ? $validate['email_check'] : ''; ?></span>
                        <?php echo Form::input('email_check', Input::post('email_check'), ['placeholder' => '確認のため再度入力してください', 'type' => 'text', 'maxlength' => '767', 'class' => isset($validate['email_check']) ? 'error_box' : ''] )?>
                    </td>
                </tr>

            </table>


            <!-- 送信ボタン START -->
            <ul class="transmission">
                <li>
                    <input type="submit" value="確認" id="fm_btn_confirm">
                </li>
            </ul>
            <!-- 送信ボタン END -->

        </form>
    </div>
</section>
