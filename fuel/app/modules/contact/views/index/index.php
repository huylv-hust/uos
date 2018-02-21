<?php
	echo \Fuel\Core\Asset::js('validate/contact.js');
?>
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
					<li class="step1 selected">
							<span>
								各項目を入力
							</span>
					</li>
					<li class="step2">
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
			<?php echo \Fuel\Core\Form::open(array('id' => 'form-contact-index', 'method' => 'post','action' => \Fuel\Core\Uri::base().'contact/confirm')); ?>
			<div class="case box">
				<div class="sty_line tb_styform_warp">
					<span class="tit_line">基本情報</span>
<span style="color: #f00">※は必須項目です。</span>

					<table class="tb_styform form_gray">
						<tr>
							<th>氏名(全角)</th>
							<td>
								<?php
									echo \Fuel\Core\Form::input('name',\Fuel\Core\Input::post('name'),array('class' => 'imp_txt', 'placeholder' => '山田　太郎'));
								?>
								<span>※姓と名の間に全角スペースを入れてください</span>
								<?php
									if(isset($error['name']))
										echo '<span class="error">'.$error['name'].'</span>';
								?>
							</td>
						</tr>
						<tr>
							<th>氏名(ふりがな)※</th>
							<td>
								<?php
								echo \Fuel\Core\Form::input('name_kana',\Fuel\Core\Input::post('name_kana'),array('class' => 'imp_txt', 'placeholder' => 'やまだ　たろう'));
								?>
								<span>※姓と名の間に全角スペースを入れてください</span>
								<?php
								if(isset($error['name_kana']))
									echo '<span class="error">'.$error['name_kana'].'</span>';
								?>
							</td>
						</tr>
						<tr>
							<th>電話番号(半角数字)※</th>
							<td>
								<?php
								echo \Fuel\Core\Form::input('mobile',\Fuel\Core\Input::post('mobile'),array('class' => 'imp_txt', 'placeholder' => '00000000000'));
								?>
								<?php
								if(isset($error['mobile']))
									echo '<span class="error">'.$error['mobile'].'</span>';
								?>
							</td>
						</tr>
						<tr>
							<th>メールアドレス(半角英数字)※</th>
							<td>
								<?php
								echo \Fuel\Core\Form::input('mail',\Fuel\Core\Input::post('mail'),array('class' => 'imp_txt', 'placeholder' => 'mail＠example.com'));
								?>
								<?php
								if(isset($error['mail']))
									echo '<span class="error">'.$error['mail'].'</span>';
								?>
							</td>
						</tr>
						<tr>
							<th>お問い合わせ内容※</th>
							<td>
								<?php
								echo \Fuel\Core\Form::textarea('content',\Fuel\Core\Input::post('content'),array('class' => 'imp_txt','cols' => '50', 'rows' => '5'));
								?>
								<?php
								if(isset($error['content']))
									echo '<span class="error">'.$error['content'].'</span>';
								?>
							</td>
						</tr>
					</table>

				</div><!-- /.sty_line -->
			</div>
			<!-- /.case -->
			<div class="f_contact box_full btn_con02 container">
				<div class="box">
					<button type="button" class="btn-submit btn-contact-submit submit-btn">
						<img class="imghover" src="<?php echo \Fuel\Core\Uri::base() ?>assets/common_img/btn_contact02.png" alt="">
					</button>
				</div><!-- /.f_contact -->
			</div><!-- /.box_full -->
			<?php
			echo \Fuel\Core\Form::close();
			?>
		</div>
		<!-- /.section -->
	</div><!-- /#page_form -->
</main>
<!--/main-->
