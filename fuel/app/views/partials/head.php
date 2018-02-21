<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=2.0,user-scalable=yes">
	<title><?php echo Utility::get_head_seo()['title'] ?></title>
	<meta name="keywords" content="<?php echo Utility::get_head_seo()['keywords'] ?>">
	<meta name="description" content="<?php echo Utility::get_head_seo()['description'] ?>">

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N7KJLQB');</script>
<!-- End Google Tag Manager -->

	<?php
	if(\Fuel\Core\Uri::current() == \Fuel\Core\Uri::base())
	{
		$css = array('style.css','base.css','top.css','content.css','media.css','custom.css');
	}
	else
	{
		$css = array('style.css','base.css','content.css','media.css','custom.css');
	}

	$js = array('jquery.js','common.js','slide.js','utility.js','jquery.elastic.source.js');

	//css
	echo \Fuel\Core\Asset::css($css);
	//js
	echo \Fuel\Core\Asset::js($js);
	?>

	<script type="text/javascript"> var baseUrl = '<?php echo \Uri::base(); ?>';</script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N7KJLQB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<!-- siteforce -->
<script type="text/javascript" src="//siteforce.riita.net/js/analyze.js"></script>
<script type="text/javascript">
	_exsam_analyzer.create('43-122');
    _exsam_analyzer.send();
</script>
<!-- End siteforce -->

<?php
Utility::get_head_seo();
?>
<div id="wrapper">
	<header>
		<div id="h_box" class="clearfix">
			<div id="h_left">
				<h1><?php echo Utility::get_head_seo()['h1'] ?></h1>
				<div id="logo"><a href="<?php echo \Fuel\Core\Uri::base(); ?>"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/logo_uos.png" alt=""></a></div>
			</div>
			<!-- /#h_left -->
			<div id="h_right" class="pc">
				<ul>
                    <li><a href="<?php echo \Fuel\Core\Uri::base() ?>service/"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/topnav03.png" alt="掲載ごご希望の方はこちら"></a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base() ?>keeplist"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/topnav01.png" alt="キープリスト"></a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>repeater"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/topnav02.png" alt="過去にエントリーしたことのある方はこちら"></a></li>
				</ul>
				<img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/tel.png" id="h_tel" alt="しごさがへのお問い合わせ番号"></div>
			<!-- /#h_right -->

			<div class="sp">
				<div id="menu" class="trigger"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_menu_off.png" alt="MENU"></div>
				<nav class="menu_h acordion_tree">
					<ul class="clearfix menu_list">
						<li><a href="<?php echo \Fuel\Core\Uri::base() ?>search"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu01.png">仕事を探す</a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base() ?>concierge"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu02.png">仕事を相談</a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>skill"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu03.png">スキル磨き</a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>guide"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/ico_menu04.png">はじめてガイド</a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>term"><span>ご利用にあたって</span></a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>privacy"><span>個人情報保護方針</span></a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>help"><span>ヘルプ・お問い合わせ</span></a></li>
                        <li><a href="<?php echo \Fuel\Core\Uri::base(); ?>service/"><span>掲載をご希望の方はこちら</span></a></li>
					</ul>
					<ul class="btn_menu_list clearfix">
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>keeplist"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_menu01.gif" alt=""></a></li>
						<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>repeater"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_menu02.gif" alt=""></a></li>
					</ul>
				</nav>
			</div>
			<!-- /.sp -->
			<div class="pc"><p id="h_des"><span><?php echo Utility::get_head_seo()['h_des'] ?></span></p></div>
		</div>
		<!-- /#h_box -->
		<div class="sp"><p id="h_des"><span><?php echo Utility::get_head_seo()['h_des'] ?></span></p></div>
	</header>
	<!--/header-->
