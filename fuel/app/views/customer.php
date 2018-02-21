<!DOCTYPE html>
<html lang="ja">
<head>
    <title><?php echo isset($title) ? $title : 'しごさが' ?></title>
    <meta charset="utf-8">
<meta name="description" content="しごさが">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <?php echo \Fuel\Core\Asset::css(['customer/style.css', 'customer/custom.css'])?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script>
        var baseUrl = "<?php echo \Fuel\Core\Uri::base();?>";
    </script>
    <?php echo \Fuel\Core\Asset::js(['remodal.min.js', 'customer/common.js', 'utility.js'])?>
<!--[if IE 7 ]> <html class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html class="ie9"> <![endif]-->
</head>
<body>

<!-- ------------ ALL START ------------ -->

<div id="container" class="front">


	<!-- ------------ HEADER START ------------ -->
	<?php echo \Fuel\Core\View::forge('customer/head');?>
	<!-- ------------ HEADER END ------------ -->

	<!-- ------------ MAIN CONTENT START ------------ -->
	<main role="main">
        <?php echo \Fuel\Core\Presenter::forge('isread/persons');?>
        <?php echo $content?>

	</main>
	<!-- ------------ MAIN CONTENT END ------------ -->


	<!-- ------------ FOOTER START ------------ -->
    <?php echo \Fuel\Core\View::forge('customer/footer');?>
	<!-- ------------ FOOTER END ------------ -->

</div>

<!-- ------------ ALL END ------------ -->

</body>
</html>
