<main>
    <div id="topicPath">
        <ul>
            <li class="home"><a href="<?php echo \Fuel\Core\Uri::base(); ?>">HOME</a></li>
            <li>応募フォーム</li>
        </ul>
    </div>
    <div id="page_form" class="sty_form">
        <div class="section box_full">
            <h2 class="tit_main">応募フォーム</h2>
            <div class="step_box container">
                <ul class="box">
                    <li class="step1">
							<span>
								各項目を入力
							</span>
                    </li>
                    <li class="step2 selected">
							<span>
								入力内容の確認
							</span>
                    </li>
                    <li class="step3">
							<span>
								応募完了
							</span>
                    </li>
                </ul>
            </div><!-- /.container -->

            <div class="container">
                <div id="destination" class="case box">
                    <div class="sty_line sty_green">
                        <span class="tit_line">応募先の求人情報</span>
                        <table class="tb_styform">
                            <tr>
                                <th>応募先企業</th>
                                <td><?php echo $data['company_name'] ?></td>
                            </tr>
                            <tr>
                                <th>職務内容</th>
                                <td><?php echo $data['job_name'] ?></td>
                            </tr>
                        </table>
                    </div><!-- /.sty_line -->
                </div><!-- /#destination -->
                <?php
                if (Session::get_flash('error')) { ?>
                    <span class="error" style="font-size:30px;text-align:center"><?php echo Session::get_flash('error'); ?></span>
                <?php } ?>
                <form class="form-inline" method="POST" action="" id="confirm">
                    <input type="hidden" name="job_id" value="<?php echo $data['job_id']; ?>">
                    <div class="case box">
                        <div class="sty_line tb_styform_warp">
                            <span class="tit_line">基本情報</span>
                            <table class="tb_styform form_gray">
                                <tr>
                                    <th>氏名(全角)</th>
                                    <td>
                                        <?php echo $data['person_name']; ?>
                                        <input type="hidden" name="person_name" value="<?php echo $data['person_name']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>氏名(ふりがな)</th>
                                    <td>
                                        <?php echo $data['person_kana']; ?>
                                        <input type="hidden" name="person_kana" value="<?php echo $data['person_kana']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>生年月日</th>
                                    <td>
										<span class="sp_box">
                                            <em><?php echo date('Y', strtotime($data['birthday'])); ?>年</em>
                                            <em><?php echo date('m', strtotime($data['birthday'])); ?>月</em>
                                            <em><?php echo date('d', strtotime($data['birthday'])); ?>日</em>
                                        </span>
                                        <input type="hidden" name="year" value="<?php  echo date('Y', strtotime($data['birthday'])); ?>">
                                        <input type="hidden" name="month" value="<?php  echo date('m', strtotime($data['birthday'])); ?>">
                                        <input type="hidden" name="day" value="<?php  echo date('d', strtotime($data['birthday'])); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>性別</th>
                                    <td>
                                        <?php echo $data['gender'] == 1 ? '男性' : '女性'; ?>
                                        <input type="hidden" name="gender" value="<?php echo $data['gender']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>住所</th>
                                    <td>
                                        <table>
                                            <tr>
                                                <th>郵便番号（半角数字）</th>
                                                <td>
                                                    <?php echo substr($data['zipcode'], 0, 3) . '-' . substr($data['zipcode'], 3, 4); ?>
                                                    <input type="hidden" name="zipcode1" value="<?php echo substr($data['zipcode'], 0, 3); ?>">
                                                    <input type="hidden" name="zipcode2" value="<?php echo substr($data['zipcode'], 3, 4); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>都道府県</th>
                                                <td>
                                                    <?php echo Constants::$addr1[$data['prefecture_id']] ?>
                                                    <input name="prefecture_id" value="<?php echo $data['prefecture_id'] ?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>市区町村</th>
                                                <td>
                                                    <?php echo $data['city'] ?>
                                                    <input name="city" value="<?php echo $data['city'] ?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>以降の住所</th>
                                                <td>
                                                    <?php echo $data['town'] ?>
                                                    <input name="town" value="<?php echo $data['town'] ?>" type="hidden">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>固定電話番号(市外局番から半角数字) 	</th>
                                    <td>
                                        <?php
                                        echo isset($data['tel']) ? $data['tel'] : '' ;
                                        $tel = isset($data['tel']) ? explode('-', $data['tel']) : '';
                                        ?>
                                        <input name="tel1" value="<?php echo isset($tel[0]) ? $tel[0] : ''?>" type="hidden">
                                        <input name="tel2" value="<?php echo isset($tel[1]) ? $tel[1] : ''?>" type="hidden">
                                        <input name="tel3" value="<?php echo isset($tel[2]) ? $tel[2] : ''?>" type="hidden">
                                    </td>
                                </tr>
                                <tr>
                                    <th>携帯電話番号(半角数字)</th>
                                    <td>
                                        <?php
                                        echo isset($data['mobile']) ? $data['mobile'] : '' ;
                                        $mobile = isset($data['mobile']) ? explode('-', $data['mobile']) : '';
                                        ?>
                                        <input name="mobile1" value="<?php echo isset($mobile[0]) ? $mobile[0] : ''?>" type="hidden">
                                        <input name="mobile2" value="<?php echo isset($mobile[1]) ? $mobile[1] : ''?>" type="hidden">
                                        <input name="mobile3" value="<?php echo isset($mobile[2]) ? $mobile[2] : ''?>" type="hidden">
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールアドレス1(半角英数字)</th>
                                    <td>
                                        <?php echo $data['mail_addr1']; ?>
                                        <input type="hidden" name="mail_addr1" value="<?php echo $data['mail_addr1']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールアドレス2(半角英数字)</th>
                                    <td>
                                        <?php echo $data['mail_addr2']; ?>
                                        <input type="hidden" name="mail_addr2" value="<?php echo $data['mail_addr2']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>現在の職業</th>
                                    <td>
                                        <?php echo Constants::$occupation_now[$data['occupation_now']]; ?>
                                        <input type="hidden" name="occupation_now" value="<?php echo $data['occupation_now']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>その他備考</th>
                                    <td style="word-break: break-all">
                                        <?php echo nl2br($data['note']); ?>
                                        <textarea name="note" style="display: none"><?php echo $data['note']; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div><!-- /.sty_line -->
                    </div>
                    <!-- /.case -->
                </form>
            </div><!-- /.container -->

            <div class="f_contact box_full container">
                <div class="box">
                    <button type="button" class="submit-btn" id="contact_l_btn">
                        <img class="imghover" src="<?php echo \Uri::base(); ?>assets/common_img/btn_contact06.png" alt="入力内容を修正する" style="opacity: 1;">
                    </button>
                    <button type="button" class="submit-btn" id="contact_r_btn">
                        <img class="imghover" src="<?php echo \Uri::base(); ?>assets/common_img/btn_contact04.png" alt="応募する" style="opacity: 1;">
                    </button>
                    <p>
                        ※応募完了メールをお送りします。<br class="sp">
                        ドメイン設定をされている方は｢@oshigoto-n.jp｣を<br class="sp">
                        受信可能にお願いします。
                    </p>
                </div><!-- /.f_contact -->
            </div>

        </div>
        <!-- /.section -->
    </div><!-- /#page_form -->
</main>
<!--/main-->
<script>
    $(document).ready(function () {
        $('#contact_r_btn').click(function () {
            $(this).attr('disabled', true);
            $('#contact_l_btn').attr('disabled', true);
            $('#confirm').submit();
        });
        $('#contact_l_btn').click(function () {
            $(this).attr('disabled', true);
            $('#contact_r_btn').attr('disabled', true);
            $('#confirm').attr('action', '<?php echo \Fuel\Core\Uri::base(); ?>customer/form').submit();
        })
    });
</script>
<style>
    @media screen and (min-width: 768px) {
        #confirm th.title-name {
            width: 240px !important;
        }
    }
</style>
