<div id="topicPath">
	<ul>
		<li class="home"><a href="<?php echo \Uri::base(); ?>">HOME</a></li>
		<li>無料コンシェルジュ 登録フォーム</li>
	</ul>
</div>

<main>
	<div id="page_form" class="sty_form">
		<div class="section box_full">
			<h2 class="tit_main">無料コンシェルジュ 登録フォーム</h2>
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

			<form method="post" action="<?php echo \Uri::base(); ?>register/confirm" accept-charset="<?php echo \Uri::base(); ?>register/confirm" id="confirm-form">
			<div class="container">
				<div class="case box">
					<div class="sty_line tb_styform_warp">
						<span class="tit_line">基本情報</span>
						<table class="tb_styform form_gray">
							<tbody><tr class="alt">
								<th>氏名(全角)</th>
								<td><?php echo $info['name']; ?></td>
								<?php echo Form::input('pass', 'true', array('type' => 'hidden')); ?>
								<?php echo Form::input('name', $info['name'], array('type' => 'hidden')); ?>
							</tr>
							<tr>
								<th>氏名(ふりがな)</th>
								<td><?php echo $info['name_kana']; ?></td>
								<?php echo Form::input('name_kana', $info['name_kana'], array('type' => 'hidden')); ?>
							</tr>
							<tr class="alt">
								<th>生年月日</th>
								<td>
									<?php echo Form::input('birthday_year', $info['birthday_year'], array('type' => 'hidden')); ?>
									<?php echo Form::input('birthday_month', $info['birthday_month'], array('type' => 'hidden')); ?>
									<?php echo Form::input('birthday_day', $info['birthday_day'], array('type' => 'hidden')); ?>
									<span class="sp_box"><em><?php echo $info['birthday_year']; ?>年</em>
									</span><em><?php echo $info['birthday_month']; ?>月</em><em><?php echo $info['birthday_day']; ?>日</em>
								</td>
							</tr>
							<tr>
								<th>性別</th>
								<td><?php echo $info['gender'] == 1 ? '男性' : '女性'; ?></td>
								<?php echo Form::input('gender', $info['gender'], array('type' => 'hidden')); ?>
							</tr>
							<tr class="alt">
								<th>住所</th>
								<td>
									<table>
										<tbody><tr>
											<th>郵便番号（半角数字）</th>
											<td><?php echo $info['zipcode_first'] ?>-<?php echo $info['zipcode_last']; ?></td>
											<?php echo Form::input('zipcode_first', $info['zipcode_first'], array('type' => 'hidden')); ?>
											<?php echo Form::input('zipcode_last', $info['zipcode_last'], array('type' => 'hidden')); ?>
										</tr>
										<tr class="alt">
											<?php $addr1 = $info['addr1']; ?>
											<th>都道府県</th>
											<td><?php echo array_key_exists($addr1, \Constants::$addr1) ? \Constants::$addr1[$addr1] : ''; ?></td>
											<?php echo Form::input('addr1', $info['addr1'], array('type' => 'hidden')); ?>
										</tr>
										<tr>
											<th>市区町村</th>
											<td><?php echo $info['addr2']; ?></td>
											<?php echo Form::input('addr2', $info['addr2'], array('type' => 'hidden')); ?>
										</tr>
										<tr class="alt">
											<th>以降の住所</th>
											<td><?php echo $info['addr3']; ?></td>
											<?php echo Form::input('addr3', $info['addr3'], array('type' => 'hidden')); ?>
										</tr>
									</tbody></table>
								</td>
							</tr>
							<tr>
								<th>固定電話番号(半角数字)</th>
								<td><?php echo $info['mobile_home']; ?></td>
								<?php echo Form::input('mobile_home', $info['mobile_home'], array('type' => 'hidden')); ?>
							</tr>
							<tr>
								<th>携帯電話番号(半角数字)</th>
								<td><?php echo $info['mobile']; ?></td>
								<?php echo Form::input('mobile', $info['mobile'], array('type' => 'hidden')); ?>
							</tr>
							<tr>
								<th>メールアドレス1(半角英数字)</th>
								<td><?php echo $info['mail']; ?></td>
								<?php echo Form::input('mail', $info['mail'], array('type' => 'hidden')); ?>
							</tr>
							<tr>
								<th>メールアドレス2(半角英数字)</th>
								<td><?php echo $info['mail2']; ?></td>
								<?php echo Form::input('mail2', $info['mail2'], array('type' => 'hidden')); ?>
							</tr>
							<tr>
								<th>現在の職業</th>
								<?php $occupation_now = $info['occupation_now'];?>
								<td><?php echo isset(\Constants::$occupation_now[$occupation_now]) ? \Constants::$occupation_now[$occupation_now] : ''; ?></td>
								<?php echo Form::input('occupation_now', $info['occupation_now'], array('type' => 'hidden')); ?>
							</tr>
							<tr class="alt">
								<th>その他備考</th>
								<td><?php echo nl2br($info['notes']); ?></td>
								<textarea name="notes" style="display:none" cols="40" rows="5"><?php echo $info['notes']; ?></textarea
							</tr>
						</tbody></table>
					</div><!-- /.sty_line -->
				</div>
					<!-- /.case -->
			</div><!-- /.container -->
			</form>

			<div class="f_contact box_full container">
				<div class="box">
					<a href="javascript:void(0)" id="contact_l_btn"><img class="imghover" src="<?php echo \Uri::base(); ?>assets/common_img/btn_contact06.png" alt="入力内容を修正する" style="opacity: 1;"></a>
					<a href="javascript:void(0)" class="register-submit" id="contact_r_btn"><img class="imghover" src="<?php echo \Uri::base(); ?>assets/common_img/btn_contact05.png" alt="登録する" style="opacity: 1;"></a>
					<p>
						※登録完了メールをお送りします。<br class="sp">
						ドメイン設定をされている方は｢@<?php echo htmlspecialchars(Fuel\Core\Config::get('domain')) ?>｣を<br class="sp">
						受信可能にお願いします。
					</p>
				</div><!-- /.f_contact -->
			</div>
		</div>
		<!-- /.section -->
	</div><!-- /#page_form -->
</main>

<script type="text/javascript">
$(document).ready(function(){
	$('a.register-submit').click(function(){
		$('#confirm-form').submit();
	});
	$('a#contact_l_btn').click(function(){
		$('#confirm-form').attr('action', '<?php echo \Uri::base(); ?>register');
		$('#confirm-form').submit();
	});
});
</script>