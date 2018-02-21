<div id="mainnav">
	<div id="mainnav_box" class="clearfix">
		<div id="search_box" class="clearfix">
			<form action="<?php echo \Fuel\Core\Uri::base(); ?>search" method="get">
				<input name="keyword" value="<?php echo htmlspecialchars(\Fuel\Core\Input::get('keyword')); ?>" type="search" placeholder="（例）週2　アルバイト">
				<input class="imghover" name="" type="submit" value="検索">
			</form>
		</div>
		<!-- /#search_box -->
		<nav class="pc">
			<ul class="clearfix">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>guide"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/mainnav04.png" alt="はじめてガイド"></a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>skill"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/mainnav03.png" alt="スキル磨き"></a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>concierge"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/mainnav02.png" alt="仕事を相談"></a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>search"><img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/mainnav01.png" alt="仕事を探す"></a></li>
				
			</ul>
		</nav>
	</div>
	<!-- /#mainnav_box -->
</div>
<!-- /#mainnav -->