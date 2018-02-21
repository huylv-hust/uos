<h1>お問い合わせ確認</h1>
<section>
    <div class="page01-box">
        <form id="fm_confirm" method="post" class="h-adr" action="">
            <table class="page15">
                <input type="hidden" name="hidden" value="back">
                <!-- メールアドレス -->
                <tbody>

                <!-- 会社名 -->
                <tr>
                    <th><p>御社名</p>
                    </th>
                    <td>
                        <?php echo $data['company_name'] ?>
                        <input name="company_name" value="<?php echo $data['company_name'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 会社名かな -->
                <tr>
                    <th><p>御社名かな</p>
                    </th>
                    <td>
                        <?php echo $data['company_kana'] ?>
                        <input name="company_kana" value="<?php echo $data['company_kana'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 郵便番号 -->
                <tr>
                    <th><p>郵便番号</p>
                    </th>
                    <td>
                        <?php echo $data['zipcode1'] ?>-<?php echo $data['zipcode2'] ?>
                        <input name="zipcode1" value="<?php echo $data['zipcode1'] ?>" type="hidden">
                        <input name="zipcode2" value="<?php echo $data['zipcode2'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 都道府県 -->
                <tr>
                    <th><p>都道府県</p>
                    </th>
                    <td>
                        <?php echo Constants::$addr1[$data['prefecture_id']] ?>
                        <input name="prefecture_id" value="<?php echo $data['prefecture_id'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 市区町村 -->
                <tr>
                    <th><p>市区町村</p>
                    </th>
                    <td>
                        <?php echo $data['city'] ?>
                        <input name="city" value="<?php echo $data['city'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 以降の住所 -->
                <tr>
                    <th><p>以降の住所</p>
                    </th>
                    <td>
                        <?php echo $data['town'] ?>
                        <input name="town" value="<?php echo $data['town'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 電話番号 -->
                <tr>
                    <th><p>お電話番号</p>
                    </th>
                    <td>
                        <?php echo $data['tel1'] ?>-<?php echo $data['tel2'] ?>-<?php echo $data['tel3'] ?>
                        <input name="tel1" value="<?php echo $data['tel1'] ?>" type="hidden">
                        <input name="tel2" value="<?php echo $data['tel2'] ?>" type="hidden">
                        <input name="tel3" value="<?php echo $data['tel3'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 担当者氏名 -->
                <tr>
                    <th><p>ご担当者様氏名</p>
                    </th>
                    <td>
                        <?php echo $data['staff_name'] ?>
                        <input name="staff_name" value="<?php echo $data['staff_name'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 担当者氏名かな -->
                <tr>
                    <th><p>ご担当者様氏名かな</p>
                    </th>
                    <td>
                        <?php echo $data['staff_kana'] ?>
                        <input name="staff_kana" value="<?php echo $data['staff_kana'] ?>" type="hidden">
                    </td>
                </tr>

                <tr>
                    <th><p>ご担当者様メールアドレス</p>
                    </th>
                    <td>
                        <?php echo $data['email'] ?>
                        <input name="email" value="<?php echo $data['email'] ?>" type="hidden">
                    </td>

                </tr>

                <tr>
                    <th><p>お問い合わせ内容</p>
                    </th>
                    <td>
                        <?php echo nl2br($data['comment']) ?>
                        <input name="comment" value="<?php echo $data['comment'] ?>" type="hidden">
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
                    <input value="送信する" id="fm_btn_confirm" type="button">
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
                $('#fm_confirm').attr('action', baseUrl + 'customer/contact').submit();
            }
        )
    });
</script>
