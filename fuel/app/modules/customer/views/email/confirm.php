<ul class="navi">
    <!--<li><a href="">実績</a></li>-->
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/jobs">求人管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/persons">応募者管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/summary">サマリー</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/shops">店舗管理</a></li>
</ul>

<h1>メールアドレスをご確認ください</h1>

<section>
    <div class="page01-box">
        <form id="fm_confirm" method="post" class="h-adr" action="complete">
            <table class="page15">

                <!-- メールアドレス -->
                <tbody>
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
                        <?php echo $email?>
                        <input name="email" value="<?php echo $email ?>" type="hidden">
                        <input name="email_check" value="<?php echo $email_check ?>" type="hidden">
                    </td>
                </tr>
                </tbody>
            </table>

            <!-- 送信ボタン START -->
            <ul class="transmission">
                <li>
                    <input value="修正する" id="fm_btn_back" type="button">
                </li>
                <li>
                    <input value="登録する" id="fm_btn_confirm" type="button">
                    <input name="confirm" type="hidden" value="1">
                </li>
            </ul>
            <!-- 送信ボタン END -->

        </form>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#fm_btn_confirm').off('click').on('click', function () {
                $('#fm_confirm').submit();
                $(this).attr('disabled', true);
                $('#fm_btn_back').attr('disabled', true);
            }
        );
        $('#fm_btn_back').off('click').on('click', function () {
                $('#fm_confirm')
                    .attr('action', baseUrl + 'customer/email')
                    .submit();
            }
        )
    });
</script>
