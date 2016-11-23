<style>
	@media screen and (min-width:768px) {
		#person input, #person select, #person .text-info :not(input[type="radio"],input[type="checkbox"]){
			float: left;
		}
		#person th.title-name {
			width: 240px !important;
		}
		#person .text-info{
			color: #31708f;
		}
	}
</style>
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
									<td><?php echo $job['post_company_name'] ?></td>
								</tr>
								<tr>
									<th>職務内容</th>
									<td><?php echo $job['job_category'] ?></td>
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
				<form class="form-inline" method="POST" action="" id="person">
					<div class="case box">
						<div class="sty_line tb_styform_warp">
							<span class="tit_line">基本情報</span>
							<table class="tb_styform form_gray">
								<tr>
									<th>氏名(全角)</th>
									<td>
										<?php echo Form::input('name', Input::post('name', isset($post) ? $post->name :$person_info['name']), array('class' => 'imp_txt', 'size' => 25,'placeholder' => '山田　太郎')); ?>
										<span>※姓と名の間に全角スペースを入れてください</span>
										<span class="error"><?php if(isset($error['name'])) echo $error['name'];?></span>
									</td>
								</tr>
								<tr>
									<th>氏名(ふりがな)</th>
									<td>
										<?php echo Form::input('name_kana', Input::post('name_kana', isset($post) ? $post->name_kana :$person_info['name_kana']), array('class' => 'imp_txt', 'size' => 25,'placeholder' => 'やまだ　たろう')); ?>
										<span>※姓と名の間に全角スペースを入れてください</span>
										<span class="error"><?php if(isset($error['name_kana'])) echo $error['name_kana'];?></span>
									</td>
								</tr>
								<tr>
									<th>生年月日</th>
									<td>
										<span class="sp_box">
											<?php echo Form::select('year', Input::post('year',isset($post) ? $post->year :$person_info['year']? $time[0]:''), \Constants::list_year(), array('class'=>'year')); ?>
											<em>年</em>
										</span>
											<?php echo Form::select('month', Input::post('month',isset($post) ? $post->month :$person_info['month']? $time[0]:''), \Constants::list_month(), array('class'=>'mouth')); ?>
										<em>月</em>
											<?php echo Form::select('day', Input::post('day',isset($post) ? $post->day :$person_info['day']? $time[0]:''), \Constants::list_day(), array('class'=>'day')); ?>
										<em>日</em>
										<span class="error"><?php if(isset($error['birthday'])) echo $error['birthday'];?></span>
									</td>
								</tr>
								<tr>
									<th>性別</th>
									<td>
										<ul class="list_line clearfix">
											<li>
												<?php echo Form::radio('gender', '0' ,Input::post('gender',isset($post) ? $post->gender:''));?>男性
											</li>
											<li>
												<?php echo Form::radio('gender', '1',Input::post('gender',isset($post) ? $post->gender:''));?>女性
											</li>
										</ul>
										<span class="error"><?php if(isset($error['gender'])) echo $error['gender'];?></span>
									</td>
								</tr>
								<tr>
									<th>住所</th>
									<td>
										<table>
											<tr>
												<?php
													$zipcode = null ;
													if($person_info['zipcode'])
													$zipcode = $person_info['zipcode'];
												?>
												<th>郵便番号（半角数字）</th>
												<td>

													<?php echo Form::input('zipcode1', Input::post('zipcode1', isset($post) ? $post->zipcode1 :substr($zipcode,0,3)), array('class' => 'form-control', 'size' => 6 ,'maxlength' => 3,'placeholder'=>'000', 'onchange' => 'utility.zen2han(this)')); ?>
													-
													<?php echo Form::input('zipcode2', Input::post('zipcode2', isset($post) ? $post->zipcode2 :substr($zipcode,0,3)), array('class' => 'form-control', 'size' => 6 ,'maxlength' => 4,'placeholder'=>'0000' ,'onchange' => 'utility.zen2han(this)')); ?>
													<span class="error"><?php if(isset($error['zipcode'])) echo $error['zipcode'];?></span>
												</td>
											</tr>
											<tr>
												<th>都道府県</th>
												<td>
													<?php echo Form::select('addr1', Input::post('addr1', isset($post) ? $post->addr1 : $person_info['addr1']), \Constants::get_create_address(), array('class'=>'prefectures')); ?>
													<span class="error"><?php if(isset($error['addr1'])) echo $error['addr1'];?></span>
												</td>
											</tr>
											<tr>
												<th>市区町村</th>
												<td>
													<?php echo Form::input('addr2', Input::post('addr2', isset($post) ? $post->addr2 :$person_info['addr2']), array('class' => 'imp_txt', 'placeholder' => '●●区●●町')); ?>
													<span class="error"><?php if(isset($error['addr2'])) echo $error['addr2'];?></span>
												</td>
											</tr>
											<tr>
												<th>以降の住所</th>
												<td>
													<?php echo Form::input('addr3', Input::post('addr3', isset($post) ? $post->addr2 :$person_info['addr3']), array('class' => 'imp_txt', 'placeholder' => '住所をご入力ください')); ?>
													<span class="error"><?php if(isset($error['addr3'])) echo $error['addr3'];?></span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<th class="title-name">固定電話番号(市外局番から半角数字)</th>
									<td>
										<?php echo Form::input('tel_1', Input::post('tel_1', isset($post) ? $post->tel_1 : ($person_info['tel'] ? explode('-', $person_info['tel'])[0] : '')), array('placeholder' => "0000" ,'maxlength' => 4, 'size' => 4, 'onchange' => 'utility.zen2han(this)')); ?>
										-
										<?php echo Form::input('tel_2', Input::post('tel_2', isset($post) ? $post->tel_2 : ($person_info['tel'] ? explode('-', $person_info['tel'])[1] : '')), array('placeholder' => "0000" ,'maxlength' => 4, 'size' => 4, 'onchange' => 'utility.zen2han(this)')); ?>
										-
										<?php echo Form::input('tel_3', Input::post('tel_3', isset($post) ? $post->tel_3 : ($person_info['tel'] ? explode('-', $person_info['tel'])[2] : '')), array('placeholder' => "0000" ,'maxlength' => 4, 'size' => 4, 'onchange' => 'utility.zen2han(this)')); ?>
										<span class="text-info">※固定・携帯のどちらか必須</span>
										<span class="error"><?php if(isset($error['tel'])) echo $error['tel'];?></span>
									</td>
								</tr>
								<tr>
									<th>携帯電話番号(半角数字)</th>
									<td>
										<?php echo Form::input('mobile_1', Input::post('mobile_1', isset($post) ? $post->mobile_1 : ($person_info['mobile'] ? explode('-', $person_info['mobile'])[0] : '')), array('placeholder' => "0000" ,'maxlength' => 4, 'size' => 4, 'onchange' => 'utility.zen2han(this)')); ?>
										-
										<?php echo Form::input('mobile_2', Input::post('mobile_2', isset($post) ? $post->mobile_2 : ($person_info['mobile'] ? explode('-', $person_info['mobile'])[1] : '')), array('placeholder' => "0000" ,'maxlength' => 4, 'size' => 4, 'onchange' => 'utility.zen2han(this)')); ?>
										-
										<?php echo Form::input('mobile_3', Input::post('mobile_3', isset($post) ? $post->mobile_3 : ($person_info['mobile'] ? explode('-', $person_info['mobile'])[2] : '')), array('placeholder' => "0000" ,'maxlength' => 4, 'size' => 4, 'onchange' => 'utility.zen2han(this)')); ?>
										<span class="text-info">※固定・携帯のどちらか必須</span>
										<span class="error"><?php if(isset($error['mobile'])) echo $error['mobile'];?></span>
									</td>
								</tr>
								<tr>
									<th>メールアドレス1(半角英数字)</th>
									<td>
										<?php echo Form::input('mail_addr1', Input::post('mail_addr1', isset($post) ? $post->mail_addr1 :$person_info['mail_addr1']), array('class' => 'imp_txt', 'placeholder' => "mail＠example.com")); ?>
										<span class="text-info">※メールアドレス1・2のどちらか必須</span>
										<span class="error"><?php if(isset($error['mail_addr1'])) echo $error['mail_addr1'];?></span>
									</td>
								</tr>
								<tr>
									<th>メールアドレス2(半角英数字)</th>
									<td>
										<?php echo Form::input('mail_addr2', Input::post('mail_addr2', isset($post) ? $post->mail_addr2 :$person_info['mail_addr2']), array('class' => 'imp_txt', 'placeholder' => "mail＠example.com")); ?>
										<span class="text-info">※メールアドレス1・2のどちらか必須</span>
										<span class="error"><?php if(isset($error['mail_addr2'])) echo $error['mail_addr2'];?></span>
									</td>
								</tr>
								<tr>
									<th>現在の職業</th>
									<td>
										<ul class="list_line clearfix">
											<?php
												$occupation_now = Constants::$occupation_now;
												foreach(Constants::$occupation_now as $key => $value){
											?>
												<?php if($key!=0){ ?>
													<li>
														<?php echo Form::radio('occupation_now', $key ,Input::post('occupation_now',isset($post) ? $post->occupation_now:''));?>
														<?php echo $value?>
													</li>
												<?php } ?>
											<?php } ?>

										</ul>
										<span class="error"><?php if(isset($error['occupation_now'])) echo $error['occupation_now'];?></span>
									</td>
								</tr>
								<tr>
									<th>その他備考</th>
									<td>
										<?php echo Form::textarea('notes', Input::post('notes', isset($post) ? $post->notes :$person_info['notes']), array('rows' => 5, 'cols' => 50,'class' => 'txt_full'));?>
										<span class="error"><?php if(isset($error['notes'])) echo $error['notes'];?></span>
									</td>
								</tr>
							</table>
						</div><!-- /.sty_line -->
					</div>
						<!-- /.case -->
					</form>

<div id="terms_service" class="case box">
						<div class="sty_line">
							<span class="tit_line">ご利用規約</span>
							<div class="service_box">

								<div class="section">

									<div class="container">
										<h3 class="tit_sub">第1条　おしごとnavi</h3>
										<p>
											ご登録いただく皆様の個人情報は、次の業務内容達成に必要な範囲内及び目的のみで利用致します。
										</p>
										<ul class="list_num">
											<li>「おしごとnavi」とは、株式会社ユーオーエス（以下「当社」といいます）が提供するインターネット上の求人情報サイト、「おしごとnavi」に付随関連して提供するWEBサイト、アプリケーションソフトウェア等（http://oshigoto-n.jp、および各求人企業のwebサイトからリンクするサイト、「おしごとnavi」の名称を記載したアプリケーションソフトウェア等、提供形態の如何を問わず含まれるものとします。）およびこのサイトに付随するメール配信その他のアルバイトや仕事探し情報サービスの総称をいいます。
				</li>
											<li>おしごとnaviをお使いになるすべての方（メール会員を含み、以下「ユーザー」といいます）は、自らの意思および責任のもと、おしごとnaviをご利用ください。</li>
											<li>ユーザーはおしごとnaviにおいて入力した情報の内容について責任を負うものとします。</li>
										</ul><!-- /.list_number -->
									</div><!-- /.container -->

									<div class="container">
										<h3 class="tit_sub">第2条　禁止事項について</h3>
										<ul class="list_num">
											<li>ユーザーは、おしごとnaviにおいて以下A〜Iに該当する、または該当する恐れがあると当社が判断する行為を行ってはならないものとします。<br>
												A. 意図的に虚偽の情報を登録／提供する行為<br>
												B. 個人情報あるいは活動情報の全部または一部について、自己以外の情報の登録を行う行為<br>
												C. 著作権、商標権、プライバシー権、氏名権、肖像権、名誉等の他人の権利を侵害する行為<br>
												D. 個人や団体を誹謗中傷する行為<br>
												E. 法令、公序良俗に反する行為、またはそのおそれのある行為<br>
												F. 当社または第三者に不利益を与える行為<br>
												G. おしごとnaviを利用しての営利、広告、宣伝、特定の思想・宗教への勧誘等を目的とした情報提供等の行為<br>
												H. おしごとnaviの運営を妨げる行為、または当社の信頼を毀損する行為<br>
												I. おしごとnaviを運営する目的に反する行為
											</li>
											<li>当社は、ユーザーが「おしごとnavi利用規約」に違反したと判断した場合、当該ユーザーに対し事前に通知することなく、当該ユーザーのおしごとnaviの全部または一部の利用を一時中止することができます。また、「おしごとnavi利用規約」違反の態様によっては、当社はその裁量で、当該ユーザーに対し事前に通知することなく、当該ユーザーから掲載企業に対する応募または問い合わせを過去に遡り無効とする、将来に向けて無効となる措置を行う等、当社が適当と認める措置を講ずることができるものとします。なお、その場合、おしごとnaviに関するサービスの中止および除名に伴いユーザーに生じる一切の不利益に関して当社は責任を負いません。</li>
										</ul><!-- /.list_number -->
									</div><!-- /.container -->

									<div class="container">
										<h3 class="tit_sub">第3条　反社会的勢力の排除</h3>
										<ul class="list_num">
											<li>ユーザーは、現在、暴力団、暴力団員、暴力団員でなくなった時から５年を経過しない者、暴力団準構成員、暴力団関係企業、総会屋等、社会運動等標ぼうゴロまたは特殊知能暴力集団等、その他これらに準ずる者（以下これらを「暴力団員等」といいます）に該当しないこと、および次の各号のいずれにも該当しないことを表明し、かつ将来にわたっても該当しないことを確約するものとします。<br>

												<ul class="list_num">
													<li>暴力団員等が経営を支配していると認められる関係を有すること</li>
													<li>暴力団員等が経営に実質的に関与していると認められる関係を有すること</li>
													<li>自己もしくは第三者の不正の利益を図る目的または第三者に損害を加える目的をもってするなど、不当に暴力団員等を利用していると認められる関係を有すること</li>
													<li>暴力団員等に対して資金等を提供し、または便宜を供与するなどの関与をしていると認められる関係を有すること</li>
													<li>役員または経営に実質的に関与している者が暴力団員等と社会的に非難されるべき関係を有すること</li>
												</ul><!-- /.list_number -->
											</li>
											<li>ユーザーは、自らまたは第三者を利用して次の各号の一にでも該当する行為を行わないことを確約するものとします。<br>
												<ul class="list_num">
													<li>暴力的な要求行為</li>
													<li>法的な責任を超えた不当な要求行為</li>
													<li>取引に関して、脅迫的な言動をし、または暴力を用いる行為</li>
													<li>風説を流布し、偽計を用いまたは威力を用いて当社、他の利用者、その他第三者の信用を毀損し、または当社、他の利用者、その他第三者の業務を妨害する行為</li>
													<li>その他前各号に準ずる行為</li>
												</ul><!-- /.list_number -->
											</li>
										</ul><!-- /.list_number -->
									</div><!-- /.container -->


									<div class="container">
										<h3 class="tit_sub">第4条　当社の責任等</h3>
										<ul class="list_num">
											<li>ユーザーによるおしごとnaviのご利用（これらに伴う当社または第三者の情報提供行為等を含みます）により生じる一切の損害（精神的苦痛、求職活動の中断、またはその他の金銭的損失を含む一切の不利益）につき、当社は当社に故意または重過失がない限り責任を負わないものとします。また、当社は、その他おしごとnaviを通じてアクセスできる第三者が提供するサイトおよびサービス、もしくはおしごとnaviにおいて懸賞、販売促進活動、情報提供などを行っている第三者により生じる一切の損害につき、責任を負わないものとします。なお、当社が責任を負う場合であっても、当社の故意または重過失がない限り当社の責任は直接かつ通常の損害に限られるものとします。</li>
											<li>当社は、おしごとnaviの提供に不具合やエラーや障害が生じないことを保証するものではありません。</li>
											<li>おしごとnaviにおいて提供される情報（会社情報等の第三者の情報、広告その他第三者により提供される情報）はその第三者の責任で提供されるものですので、ユーザーは、提供情報の真実性、合法性、安全性、適切性、有用性について当社が何ら保証しないことをご了承いただき、自己の責任においてご利用ください。また、おしごとnaviから得られる情報等が正確なものであること、おしごとnaviおよびおしごとnaviを通じて入手できる商品、役務、情報などがユーザーの期待を満たすものであることのいずれについても保証するものではありません。</li>
											<li>当社は通常講ずるべき対策では防止できないウィルス被害、停電被害、サーバー故障、回線障害、及び天変地異による被害等、その他当社の責によらない事由(以下「不可抗力」といいます)による被害が生じた場合には、一切責任を負わないものとします。当社はこれらの不可抗力によって、おしごとnaviにおけるデータが消去･変更されないことを保証いたしません。ユーザーは、おしごとnaviにおけるデータを自己の責任において保存いただくようお願いします。</li>

										</ul><!-- /.list_number -->
									</div><!-- /.container -->


									<div class="container">
										<h3 class="tit_sub">第5条　個人情報の取扱</h3>
										<p>
											『<a href="/privacy/">プライバシーポリシー</a>』をご覧ください。
										</p>
									</div><!-- /.container -->


									<div class="container">
										<h3 class="tit_sub">第6条　統計情報・属性情報の集計および利用</h3>
										<p>
				当社は、ユーザーによるおしごとnaviの利用によって提供・記録された年齢や性別、職業、居住地等の属性情報および行動履歴等の情報（ページビュー、応募履歴、おしごとnaviを通じた求職活動の過程、態様、応募先企業が判断・入力等を行った成否のステータスや評価情報などを含みますが、これらに限られません）について、本利用規約への同意の前後を問わず提供・記録された情報を含めて、個人を識別・特定できないように加工した上で、何らの制限もなく利用（ユーザーへの情報提供、分析・研究・統計データ等の作成、属性情報等データの作成、企業等第三者への提供、市場の調査、新サービスの開発を含みますが、これらに限られません）することができるものとし、ユーザーはこれをあらかじめ承諾します。
										</p>
									</div><!-- /.container -->

									<div class="container">
										<h3 class="tit_sub">第7条　おしごとnaviのサービス変更等</h3>
										<p>
				当社は、ユーザーへの事前の通知なくして、おしごとnaviのサービス内容変更、一時的もしくは長期的な中断、または終了することがあります。
										</p>
									</div><!-- /.container -->

									<div class="container">
										<h3 class="tit_sub">第8条　おしごとnavi利用規約の変更</h3>
										<p>
				ユーザーへの事前の通知なくして、必要に応じて、「おしごとnavi利用規約」を変更することがあります。ユーザーによりますおしごとnaviのご利用をもちまして、当該利用規約を承諾したものとみなしますので、おしごとnaviをご利用の際には、掲載されている最新の「おしごとnavi利用規約」をご確認ください。
										</p>
									</div><!-- /.container -->

									<div class="container">
										<h3 class="tit_sub">第9条　準拠法および管轄</h3>
										<p>
				おしごとnaviおよびその利用に関する準拠法は日本法とし、おしごとnaviおよびその利用に関して生じる一切の紛争については、名古屋地方裁判所または名古屋簡易裁判所を第一審の専属的合意管轄裁判所とします。
										</p>
									</div><!-- /.container -->

									<div class="container">
										<h3 class="tit_sub">■特記</h3>
										<ul class="list_num">
											<li>当社は職業安定法に規定される職業紹介は行いません(「○○のアルバイトを探してください。」という個別依頼には一切対応できません。）また、おしごとnaviに掲載される個々の求人情報への応募により生じる個別の雇用契約の仲介･契約上生じる争議に関しても一切の関与を致しません。</li>
											<li>当社は、ユーザーからの問い合わせ（「応募が掲載企業に届いているか教えてください。」「●●の情報を調査・開示してください。」などを含みますがこれらに限られません。）に対して回答を行うかを、当社の裁量で決めるものとします。</li>
									</ul><!-- /.list_number -->
									</div><!-- /.container -->

								</div><!-- /.service_box -->
							</div><!-- /.sty_line -->
						</div><!-- /#terms_service -->
					</div>

				</div><!-- /.container -->


				<div class="f_contact box_full container">
					<div class="box">
						<a><img class="imghover" src="<?php echo Uri::base() ?>assets/common_img/btn_contact.png" alt="利用規約に同意して確認画面へ"></a>
					</div><!-- /.f_contact -->
				</div><!-- /.box_full -->

			</div>
			<!-- /.section -->
		</div><!-- /#page_form -->
	</main>
	<!--/main-->
<script>
		$( document ).ready(function() {
			<?php if(!Session::get_flash('error')){?>
			$('.imghover').click(function(){
				$('#person').submit();
			})
			<?php }?>
		});
</script>
