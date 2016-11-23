<main>
		<div id="topicPath">
			<ul>
				<li class="home"><a href="<?php echo \Fuel\Core\Uri::base(); ?>">HOME</a></li>
				<li>応募フォーム</li>
			</ul>
		</div>
		<div id="page_form" class="sty_form page_form_thanks">
			<div class="section box_full">
				<h2 class="tit_main">応募フォーム</h2>
				<div class="step_box container">
					<ul class="box">
						<li class="step1">
							<span>
								各項目を入力
							</span>
						</li>
						<li class="step2">
							<span>
								入力内容の確認
							</span>
						</li>
						<li class="step3 selected">
							<span>
								応募完了
							</span>
						</li>
					</ul>
				</div><!-- /.container -->

				<div class="container">

					<div class="case box">
						<div class="sty_line tb_styform_warp">
						送信完了しました。
						</div><!-- /.sty_line -->
					</div>
						<!-- /.case -->

				</div><!-- /.container -->

			</div>
			<!-- /.section -->
		</div><!-- /#page_form -->
	</main>
	<!--/main-->
<script type = "text/javascript" >
  history.pushState(null, null, 'thanks');
  window.addEventListener('popstate', function(event) {
  history.pushState(null, null, 'thanks');
 });
</script>