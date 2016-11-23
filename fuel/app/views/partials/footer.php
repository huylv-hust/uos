<footer>
	<div id="bk_top"><a href="<?php echo \Fuel\Core\Uri::base(); ?>"><img class="switch imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/pagetop_pc.png" alt="ページトップへ"></a></div>
	<!--/bk_top-->

	<div id="footer_link" class="pc">
		<div class="box">
			<ul>
				<li><a href="http://uos.co.jp/business/index.html" target="_blank">求人のご相談はこちら</a>｜</li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>term">ご利用にあたって</a>｜</li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>privacy">プライバシーポリシー</a>｜</li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>help">ヘルプ・お問い合わせ</a></li>
			</ul>
		</div>
		<!-- /.box -->
	</div>
	<!-- /#footer_link -->

	<div id="footer_wrap">
		<div id="footer_box" class="clearfix">
			<div id="logo_f"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/logo_uos_f.png" alt="UOS"></div>
			<!-- /#logo_f -->
			<nav class="menu_h sp">
				<ul class="clearfix menu_list">
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>search"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu01.png" alt="仕事を探す">仕事を探す</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>concierge"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu02.png" alt="仕事を相談">仕事を相談</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>skill"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu03.png" alt="スキル磨き">スキル磨き</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>guide"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu04.png" alt="はじめてガイド">はじめてガイド</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>term"><span>ご利用にあたって</span></a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>privacy"><span>プライバシーポリシー</span></a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>help"><span>ヘルプ・お問い合わせ</span></a></li>
				</ul>
				<ul class="btn_menu_list clearfix">
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>keeplist"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_menu01.gif" alt="キープリスト"></a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>repeater"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_menu02.gif" alt="過去にエントリーしたことのある方はこちら"></a></li>
				</ul>
			</nav>
		</div>
		<!--/footer_box-->
	</div>
	<!-- /#footer_wrap -->
	<div id="copy_right">
		<p> Copyright &copy; U.O.S CORP. All Right Reserved. </p>
	</div>
	<!--/copy_right-->
</footer>
<!--/footer-->
</div>
<!--/wrapper-->
<?php
	$keeplist = $countkeeplist;
?>
<div id="concierge_pc" class="pc">
	<ul>
		<li><a href="<?php echo \Fuel\Core\Uri::base() ?>concierge"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_concierge01.png" alt="コンシェルジュに相談する（無料）"></a></li>
		<li class="common-keeplist"><a href="<?php echo \Fuel\Core\Uri::base() ?>keeplist" class="imghover"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_concierge02.png" alt="キープリストへ"><span><em><?php echo isset($keeplist) ? $keeplist : 0; ?></em>件キープ中</span></a></li>
	</ul>
</div>
<!-- /#concierge_pc -->

<div id="concierge_sp" class="sp">
	<ul class="clearfix">
		<li><a href="<?php echo \Fuel\Core\Uri::base() ?>concierge"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_concierge01_sp.png" alt="コンシェルジュに相談する（無料）"></a></li>
		<li class="common-keeplist"><a href="<?php echo \Fuel\Core\Uri::base() ?>keeplist"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_concierge02_sp.png" alt="キープリストへ"><span><em><?php echo isset($keeplist) ? $keeplist : 0; ?></em>件キープ中</span></a></li>
	</ul>
</div>
<!-- /#concierge_sp -->
<script type="text/javascript">
	$(function(){
		$("iframe").each(function(){
			var ifr_source = $(this).attr('src');
			var wmode = "wmode=transparent";
			if(ifr_source.indexOf('?') != -1) $(this).attr('src',ifr_source+'&'+wmode);
			else $(this).attr('src',ifr_source+'?'+wmode);
		});
	})
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75176166-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>