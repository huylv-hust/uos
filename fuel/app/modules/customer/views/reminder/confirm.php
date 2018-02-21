<h1>メールアドレスをご確認ください</h1>
<section>
    <div class="page01-box">
        <form id="fm_confirm" method="post" class="h-adr" action="">
            <table class="page15">

                <!-- メールアドレス -->
                <tbody>
                <tr>
                    <th>
                        <p>メールアドレス</p>
                    </th>
                    <td>
                        <?php echo $email?>
                        <input name="email" value="<?php echo $email ?>" type="hidden">
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
                    <input value="パスワード再発行" id="fm_btn_confirm" type="button">
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
                $('#fm_confirm').attr('action', baseUrl + 'customer/reminder').submit();
                $(this).attr('disabled', true);
                $('#fm_btn_back').attr('disabled', true);
            }
        )
    });
</script>
