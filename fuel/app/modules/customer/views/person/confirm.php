<h1>応募者確認</h1>
<section>
    <div class="page01-box">
        <form id="fm_confilm" method="post" class="h-adr" action="<?php echo \Fuel\Core\Uri::base()?>customer/personcomplete?person_id=<?php echo \Fuel\Core\Input::get('person_id')?>">
            <input type="hidden" value="<?php echo $json_data?>" name="json_data" />
            <table class="page15">
                <!-- メールアドレス -->
                <tbody>
                <tr>
                    <th>
                        <p>掲載プラン</p>
                    </th>
                    <td>採用課金</td>
                </tr>
                <tr>
                    <th>
                        <p>応募日時</p>
                    </th>
                    <td>
                        <?php echo $application_time_d.' '.$application_time_h.':'.$application_time_m?>
                    </td>
                </tr>
                <tr>
                    <th><p>応募対象求人</p>
                    </th>
                    <td><?php echo $shop_name?></td>
                </tr>
                <tr>
                    <th><p>氏名</p>
                    </th>
                    <td><?php echo $person_name?></td>
                </tr>
                <tr>
                    <th><p>かな</p>
                    </th>
                    <td><?php echo $person_kana?></td>
                </tr>
                <tr>
                    <th><p>生年月日</p>
                    </th>
                    <td><?php echo $birthday_y.'-'.$birthday_m.'-'.$birthday_d?></td>
                </tr>
                <tr>
                    <th>
                        <p>性別</p>
                    </th>
                    <td>
                       <?php echo $gender == 1 ? '男性' : '女性'?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>郵便番号</p>
                    </th>
                    <td>
                        <?php
                            if($zipcode1)
                                echo $zipcode1.'-'.$zipcode2
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>都道府県</p>
                    </th>
                    <td>
                        <?php if($prefecture_id) echo Constants::$addr1[$prefecture_id] ?>
                    </td>
                </tr>
                <tr>
                    <th><p>市区町村</p>
                    </th>
                    <td><?php echo $city?></td>
                </tr>
                <tr>
                    <th><p>以降の住所</p>
                    </th>
                    <td><?php echo $town?></td>
                </tr>
                <tr>
                    <th>
                        <p>電話番号（携帯）</p>
                    </th>
                    <td>
                        <?php
                        if($mobile1)
                            echo $mobile1.'-'.$mobile2.'-'.$mobile3
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>電話番号（固定）</p>
                    </th>
                    <td>
                        <?php
                        if($tel1)
                            echo $tel1.'-'.$tel2.'-'.$tel3
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>メールアドレス1</p>
                    </th>
                    <td>
                        <?php echo $mail_addr1?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>メールアドレス2</p>
                    </th>
                    <td>
                        <?php echo $mail_addr2?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>現在職種</p>
                    </th>
                    <td>
                        <?php echo Constants::$occupation_now[$occupation_now]?>
                    </td>
                </tr>
                <tr>
                    <th><p>その他備考</p>
                    </th>
                    <td>
                        <?php echo $note?>
                    </td>
                </tr>
                </tbody>
            </table>
            <ul class="transmission">
                <li>
                    <input value="修正する" id="fm_btn_back" type="button">
                </li
                <li>
                    <input value="保存" id="fm_btn_confirm" type="submit">
                </li>
            </ul>
        </form>
    </div>
</section>
<script type="application/javascript">
    $("#fm_btn_confirm").on('click', function (){
        $("#fm_confilm").submit();
        $("#fm_btn_confirm").prop('disabled',true);
        $("#fm_btn_back").prop('disabled',true);
        return true;
    });
    $("#fm_btn_back").on('click', function () {
        $("#fm_btn_confirm").prop('disabled',true);
        window.location.href = '<?php echo \Fuel\Core\Uri::base().'customer/person?back=true'; if($person_id) echo '&person_id='.$person_id?>';
    })
</script>
