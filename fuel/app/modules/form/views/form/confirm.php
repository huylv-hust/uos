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
									<td><?php echo $post_company_name ?></td>
								</tr>
								<tr>
									<th>職務内容</th>
									<td><?php echo $job_category ?></td>
								</tr>
							</table>
						</div><!-- /.sty_line -->
					</div><!-- /#destination -->
					<?php
						if(Session::get_flash('error'))
						{
							?>
							<span class="error" style="font-size:30px;text-align:center">
								<?php echo Session::get_flash('error');?>
							</span>
						<?php
						} ?>
					<form class="form-inline" method="POST" action="" id="confirm">

					<div class="case box">
						<div class="sty_line tb_styform_warp">
							<span class="tit_line">基本情報</span>
							<table class="tb_styform form_gray">
								<tr>
									<th>氏名(全角)</th>
									<td><?php if(isset($name)) echo $name ;?></td>
								<input type="hidden" name="name" value ="<?php if(isset($name)) echo $name ;?>">
								</tr>
								<tr>
									<th>氏名(ふりがな)</th>
									<td><?php if(isset($name_kana)) echo $name_kana ;?></td>
								<input type="hidden" name="name_kana" value ="<?php if(isset($name_kana)) echo $name_kana ;?>">
								</tr>
								<tr>
									<th>生年月日</th>
									<td>
										<span class="sp_box"><em><?php if(isset($year)) echo $year ;?>年</em>
										</span><em><?php if(isset($month)) echo $month ;?>月</em><em><?php if(isset($day)) echo $day ;?>日</em>
										<input type="hidden" name="year" value ="<?php if(isset($year)) echo $year ;?>">
										<input type="hidden" name="month" value ="<?php if(isset($month)) echo $month ;?>">
										<input type="hidden" name="day" value ="<?php if(isset($day)) echo $day ;?>">
									</td>
								</tr>
								<tr>
									<th>性別</th>
									<td>
										<?php
											if(isset($gender))
											{
												if($gender == 0)
												{
													echo "男性";
												}
												else
												{
													echo "女性";
												}
											}
										?>
									</td>
									<input type="hidden" name="gender" value ="<?php if(isset($gender)) echo $gender ;?>">
								</tr>
								<tr>
									<th>住所</th>
									<td>
										<table>
											<tr>
												<th>郵便番号（半角数字）</th>
												<td>
													<?php if(isset($zipcode1) && isset($zipcode2)) echo $zipcode1.'-'.$zipcode2 ;?>
												</td>
												<input type="hidden" name="zipcode1" value ="<?php if(isset($zipcode1)) echo $zipcode1 ;?>">
												<input type="hidden" name="zipcode2" value ="<?php if(isset($zipcode2)) echo $zipcode2 ;?>">

											</tr>
											<tr>
												<th>都道府県</th>
												<td>
													<?php if(isset($addr1)) echo \Constants::$addr1[$addr1] ;?>
												</td>
												<input type="hidden" name="addr1" value ="<?php if(isset($addr1)) echo $addr1 ;?>">
											</tr>
											<tr>
												<th>市区町村</th>
												<td><?php if(isset($addr2)) echo $addr2 ;?></td>
												<input type="hidden" name="addr2" value ="<?php if(isset($addr2)) echo $addr2 ;?>">
											</tr>
											<tr>
												<th>以降の住所</th>
												<td><?php if(isset($addr3)) echo $addr3 ;?></td>
												<input type="hidden" name="addr3" value ="<?php if(isset($addr3)) echo $addr3 ;?>">
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<input type="hidden" name="tel_1" value="<?php if(isset($tel_1)) echo $tel_1 ;?>">
									<input type="hidden" name="tel_2" value="<?php if(isset($tel_2)) echo $tel_2 ;?>">
									<input type="hidden" name="tel_3" value="<?php if(isset($tel_3)) echo $tel_3 ;?>">
									<input type="hidden" name="mobile_1" value="<?php if(isset($mobile_1)) echo $mobile_1 ;?>">
									<input type="hidden" name="mobile_2" value="<?php if(isset($mobile_2)) echo $mobile_2 ;?>">
									<input type="hidden" name="mobile_3" value="<?php if(isset($mobile_3)) echo $mobile_3 ;?>">
									<th class="title-name">固定電話番号(市外局番から半角数字)</th>
									<td><?php if(isset($tel)) echo $tel ;?></td>
									<input type="hidden" name="tel" value ="<?php if(isset($tel)) echo $tel ;?>">
								</tr>
								<tr>
									<th>携帯電話番号(半角数字)</th>
									<td><?php if(isset($mobile)) echo $mobile ;?></td>
									<input type="hidden" name="mobile" value ="<?php if(isset($mobile)) echo $mobile ;?>">
								</tr>
								<tr>
									<th>メールアドレス1(半角英数字)</th>
									<td><?php if(isset($mail_addr1)) echo $mail_addr1 ;?></td>
									<input type="hidden" name="mail_addr1" value ="<?php if(isset($mail_addr1)) echo $mail_addr1 ;?>">
								</tr>
								<tr>
									<th>メールアドレス2(半角英数字)</th>
									<td><?php if(isset($mail_addr2)) echo $mail_addr2 ;?></td>
									<input type="hidden" name="mail_addr2" value ="<?php if(isset($mail_addr2)) echo $mail_addr2 ;?>">
								</tr>
								<tr>
									<th>現在の職業</th>
									<td><?php if(isset($occupation_now)) echo Constants::$occupation_now[$occupation_now] ;?></td>
									<input type="hidden" name="occupation_now" value ="<?php if(isset($occupation_now))  echo $occupation_now ;?>">
								</tr>
								<tr>
									<th>その他備考</th>
									<td style="word-break: break-all"><?php if(isset($notes)) echo nl2br($notes);?></td>
									<textarea name="notes" style="display: none"><?php if(isset($notes)) echo $notes ;?></textarea>
								</tr>
								<input type="hidden" name="flg" value="1">
							</table>
						</div><!-- /.sty_line -->
					</div>
						<!-- /.case -->
					</form>
				</div><!-- /.container -->

				<div class="f_contact box_full container">
					<div class="box">
						<button type="button" class="submit-btn" onclick="submitform()" id="contact_l_btn"><img class="imghover" src="<?php echo \Uri::base(); ?>assets/common_img/btn_contact06.png" alt="入力内容を修正する" style="opacity: 1;"></button>
						<button type="button" class="submit submit-btn" id="contact_r_btn"><img class="imghover" src="<?php echo \Uri::base(); ?>assets/common_img/btn_contact04.png" alt="応募する" style="opacity: 1;"></button>
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
		$( document ).ready(function() {
			$('.submit').click(function(){
                $('.submit-btn').attr('disabled', true);
				$('#confirm').submit();
			})
		});
		function submitform(){
            $('.submit-btn').attr('disabled', true);
			$('#confirm').attr('action', '<?php echo \Fuel\Core\Uri::base(); ?>form');
			$('#confirm').submit();
		}
</script>
<style>
	@media screen and (min-width:768px) {
		#confirm th.title-name{
			width: 240px!important;
		}
	}
</style>
