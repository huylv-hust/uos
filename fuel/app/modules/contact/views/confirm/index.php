<?php
	echo \Fuel\Core\Asset::js('validate/contact.js');
?>

<!-- /#mainnav -->
<div id="topicPath">
	<ul>
		<li class="home"><a href="<?php echo \Fuel\Core\Uri::base(); ?>">HOME</a></li>
		<li>総合お問い合わせ</li>
	</ul>
</div>
<!-- /#topicPath -->

<main>
	<div id="page_form" class="sty_form">
		<div class="section box_full">
			<h2 class="tit_main">総合お問い合わせ</h2>
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
								完了
							</span>
					</li>
				</ul>
			</div><!-- /.container -->

			<?php
			//Get data contact to Session
				$data_contact = \Fuel\Core\Session::get_flash('data_contact');
			?>

			<div class="case box">
				<div class="sty_line tb_styform_warp">
					<span class="tit_line">基本情報</span>
					<table class="tb_styform form_gray">
						<tr>
							<th>氏名(全角)</th>
							<td>&nbsp;<?php echo \Fuel\Core\Input::post('name'); ?></td>
						</tr>
						<tr>
							<th>氏名(ふりがな)</th>
							<td>&nbsp;<?php echo \Fuel\Core\Input::post('name_kana');  ?></td>
						</tr>
						<tr>
							<th>電話番号(半角数字)</th>
							<td>&nbsp;<?php echo \Fuel\Core\Input::post('mobile');  ?></td>
						</tr>
						<tr>
							<th>メールアドレス(半角英数字)</th>
							<td>&nbsp;<?php echo \Fuel\Core\Input::post('mail');  ?></td>
						</tr>
						<tr>
							<th>お問い合わせ内容</th>
							<td>&nbsp;
								<?php
									echo \Fuel\Core\Form::textarea('content_confirm',trim(\Fuel\Core\Input::post('content')),array('class' => 'imp_txt','cols' => '100','disabled','style'=>'border:0;background-color:#fff'));
								?>
						</tr>
					</table>
				</div><!-- /.sty_line -->
			</div>
			<!-- /.case -->
			<div class="f_contact box_full btn_con02 container">
				<form method="post" id="form-contact-confirm" action="<?php echo \Fuel\Core\Uri::base() ?>contact/thanks">
					<?php
						echo \Fuel\Core\Form::input('name',\Fuel\Core\Input::post('name'),array('type' => 'hidden'));
					?>
					<?php
					echo \Fuel\Core\Form::input('name_kana',\Fuel\Core\Input::post('name_kana'),array('type' => 'hidden'));
					?>
					<?php
					echo \Fuel\Core\Form::input('mobile',\Fuel\Core\Input::post('mobile'),array('type' => 'hidden'));
					?>
					<?php
					echo \Fuel\Core\Form::input('mail',\Fuel\Core\Input::post('mail'),array('type' => 'hidden'));
					?>
					<?php
					echo \Fuel\Core\Form::input('content',trim(\Fuel\Core\Input::post('content')),array('type' => 'hidden'));
					?>
				<div class="box">
					<button type="button" class="btn-contact-back-step1 submit-btn" id="contact_l_btn">
						<img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_contact06.png" alt="入力内容を修正する" style="opacity: 1;">
					</button>
					<button type="button" class="btn-contact-confirm submit-btn" id="contact_r_btn">
						<img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_contact03.png" alt="送信する" style="opacity: 1;">
					</button>
					<p>
						※お問い合わせ完了メールをお送りします。<br class="sp">
						ドメイン設定をされている方は｢@<?php echo htmlspecialchars(Fuel\Core\Config::get('domain')) ?>｣を<br class="sp">
						受信可能にお願いします。
					</p>
				</div>
				</form>
			</div><!-- /.box_full -->

		</div>
		<!-- /.section -->
	</div><!-- /#page_form -->
</main>
<!--/main-->
<script type="text/javascript">
	$('#form_content_confirm').elastic();
</script>
