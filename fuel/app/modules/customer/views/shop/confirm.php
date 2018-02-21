<h1>店舗確認</h1>
<section>
    <div class="page01-box">
        <form id="fm_confilm" method="post" class="h-adr" action="<?php echo \Fuel\Core\Uri::base()?>customer/shopcomplete">
            <input type="hidden" value="<?php echo $json_data?>" name="json_data" />
            <table class="page15">
                <!-- メールアドレス -->
                <tbody>
                <tr>
                    <th>
                        <p>店舗名</p>
                    </th>
                    <td><?php echo $shop_name?></td>
                </tr>

                <!-- 会社名 -->
                <tr>
                    <th><p>店舗名かな</p>
                    </th>
                    <td><?php echo $shop_kana?></td>
                </tr>

                <!-- 会社名かな -->
                <tr>
                    <th><p>都道府県</p>
                    </th>
                    <td><?php echo Constants::$addr1[$prefecture_id]?></td>
                </tr>

                <!-- 郵便番号 -->
                <tr>
                    <th><p>市区町村</p>
                    </th>
                    <td><?php echo $city?></td>
                </tr>

                <!-- 都道府県 -->
                <tr>
                    <th><p>以降の住所</p>
                    </th>
                    <td><?php echo $town?></td>
                </tr>

                <!-- 市区町村 -->
                <tr>
                    <th><p>アクセス</p>
                    </th>
                    <td><?php echo $access?></td>
                </tr>

                <!-- 以降の住所 -->
                <tr>
                    <th>
                        <p>最寄り駅</p>
                    </th>
                    <td>
                        <?php for ($i=0;$i<3;$i++) { ?>
                            <div>
                                <?php echo $station_company[$i] ?>
                                <?php echo $station_line[$i] ?><?php echo strlen($station_line[$i]) ? '線' : '' ?>
                                <?php echo $station_name[$i] ?><?php echo strlen($station_name[$i]) ? '駅' : '' ?>
                                <?php echo $station_time[$i] ?><?php echo strlen($station_time[$i]) ? '分' : '' ?>
                            </div>
                        <?php } ?>
                    </td>
                </tr>

                <tr class="hide">
                    <th><p>目印情報</p>
                    </th>
                    <td><?php echo $mark_info?></td>
                </tr>

                <!-- FAX番号 -->
                <tr>
                    <th><p>備考</p>
                    </th>
                    <td><?php echo $note?></td>
                </tr>
                </tbody>
            </table>

            <!-- 送信ボタン START -->
            <ul class="transmission">
                <li>
                    <input value="修正する" id="fm_btn_back" type="button">
                </li
                <li>
                    <input value="登録する" id="fm_btn_confirm" type="button">
                </li>
            </ul>
            <!-- 送信ボタン END -->
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
        window.location.href = '<?php echo \Fuel\Core\Uri::base().'customer/shop?back=true'; if($shop_id) echo '&shop_id='.$shop_id?>';
    })
</script>
