<h1>申込フォーム確認</h1>
<section>
    <div class="page01-box">
        <form id="fm_confirm" method="post" class="h-adr" action="">
            <table class="page15">

                <!-- メールアドレス -->
                <tbody>
                <tr>
                    <th><p>メールアドレス</p>
                    </th>
                    <td>
                        <?php echo $data['email'] ?>
                        <input name="email" value="<?php echo $data['email'] ?>" type="hidden">
                    </td>

                </tr>

                <!-- 会社名 -->
                <tr>
                    <th><p>会社名</p>
                    </th>
                    <td>
                        <?php echo $data['company_name'] ?>
                        <input name="company_name" value="<?php echo $data['company_name'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 会社名かな -->
                <tr>
                    <th><p>会社名かな</p>
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
                    <th><p>電話番号</p>
                    </th>
                    <td>
                        <?php echo $data['tel1'] ?>-<?php echo $data['tel2'] ?>-<?php echo $data['tel3'] ?>
                        <input name="tel1" value="<?php echo $data['tel1'] ?>" type="hidden">
                        <input name="tel2" value="<?php echo $data['tel2'] ?>" type="hidden">
                        <input name="tel3" value="<?php echo $data['tel3'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- FAX番号 -->
                <tr>
                    <th><p>FAX</p>
                    </th>
                    <td>
                        <?php echo $data['fax1'] ?>-<?php echo $data['fax2'] ?>-<?php echo $data['fax3'] ?>
                        <input name="fax1" value="<?php echo $data['fax1'] ?>" type="hidden">
                        <input name="fax2" value="<?php echo $data['fax2'] ?>" type="hidden">
                        <input name="fax3" value="<?php echo $data['fax3'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 代表者氏名 -->
                <tr>
                    <th><p>代表者氏名</p>
                    </th>
                    <td>
                        <?php echo $data['president_name'] ?>
                        <input name="president_name" value="<?php echo $data['president_name'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 代表者氏名かな -->
                <tr>
                    <th><p>代表者氏名かな</p>
                    </th>
                    <td>
                        <?php echo $data['president_kana'] ?>
                        <input name="president_kana" value="<?php echo $data['president_kana'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 担当者氏名 -->
                <tr>
                    <th><p>担当者氏名</p>
                    </th>
                    <td>
                        <?php echo $data['staff_name'] ?>
                        <input name="staff_name" value="<?php echo $data['staff_name'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- 担当者氏名かな -->
                <tr>
                    <th><p>担当者氏名かな</p>
                    </th>
                    <td>
                        <?php echo $data['staff_kana'] ?>
                        <input name="staff_kana" value="<?php echo $data['staff_kana'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- パスワード -->
                <tr>
                    <th><p>パスワード</p>
                    </th>
                    <td>
                        <?php echo preg_replace('/[a-zA-Z0-9]/', '●', $data['password']); ?>
                        <input name="password" value="<?php echo $data['password'] ?>" type="hidden">
                    </td>
                </tr>

                <!-- パスワード確認 -->
                <tr>
                    <th><p>パスワード確認</p>
                    </th>
                    <td>
                        <?php echo preg_replace('/[a-zA-Z0-9]/', '●', $data['password']); ?>
                        <input name="password_check" value="<?php echo $data['password_check'] ?>" type="hidden">
                    </td>
                </tr>
                </tbody>
            </table>

            <input name="agree" value="<?php echo $data['agree'] ?>" type="hidden">

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
                $('#fm_confirm').attr('action', baseUrl + 'customer/entry').submit();
            }
        )
    });
</script>
