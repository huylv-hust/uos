<script type="text/javascript">
	$(window).load(function(e) {
		// slide
		$(".swiper-slide img").hide();
		var mySwiper = new Swiper('.swiper-container',{
			pagination: '.pagination',
			loop:true,
			speed:1200,
			autoplay:3000,
			paginationClickable:true,
			calculateHeight:true,
			cssWidthAndHeight:'height',
			roundLengths:true,
			touchRatio:0.6,
			/*updateOnImagesReady: true,*/
			onImagesReady: function(e) { $(".swiper-slide img").show(); }
		});

		$('.arrow-left').on('click', function(e){
			e.preventDefault()
			mySwiper.swipePrev()
		});
		$('.arrow-right').on('click', function(e){
			e.preventDefault()
			mySwiper.swipeNext()
		});

		// auto height
		$(".col3_box").equalbox({eqName:".col3 .tit_guide"});

		// search_region
		$(".style_region").each(function(){
			$(this).find('ul').last().addClass("last");
		});

		// accordion
		if($(window).width() > 768){
			$('.accordion .toggle').show();
		}else{
			$('.accordion .toggle').hide();

		}
		$(window).resize(function(e) {
			if($(window).width() > 768){
				$('.accordion .toggle').show();
			}else{
				$('.accordion .toggle').hide();
			}
		});

		$("#good .sp").accor({conAcc: "#good .toggle" , souLaval: true});
		$(".looking_box .sp").accor({conAcc: ".looking_box .toggle"});
	});
</script>
<!--/header-->
<div id="main_visual_box">
	<div class="box clearfix">
		<div id="main_visual"><a class="arrow-left" href="<?php echo \Fuel\Core\Uri::base(); ?>"></a><a class="arrow-right" href="<?php echo \Fuel\Core\Uri::base(); ?>"></a>
			<div class="slide_box">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><a href="<?php echo \Fuel\Core\Uri::base(); ?>concierge"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/main01_pc.jpg" alt="無料コンシェルジュ"></a></div>
						<div class="swiper-slide"><a href="<?php echo \Fuel\Core\Uri::base(); ?>skill/otsu4"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/main02_pc.jpg" alt="危険物乙四とは？"></a></div>
					</div>
				</div>
				<div class="pagination"></div>
			</div>
			<!-- /.slide_box -->
		</div>
		<!-- /#main_visual -->

		<div id="job" class="clearfix">
			<div class="job_box">
				<h2>現在のお仕事件数</h2>
				<span><?php echo isset($count_job) ? $count_job : '0'; ?><em>件</em></span></div>
			<!-- /.job_box -->
			<table>
				<tr>
					<th><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_new.png" alt="NEW">新着案件数</th>
					<td><?php echo isset($count_job_new) ? $count_job_new : '0'; ?> 件</td>
				</tr>
				<tr>
					<th><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_refresh.png" alt="最終更新日">最終更新日</th>
					<td><?php echo isset($last_updated_at) ? $last_updated_at : '0'; ?></td>
				</tr>
			</table>
		</div>
		<!-- /#job -->
	</div>
	<!-- /.box -->
</div>
<!-- /#main_visual_box -->

<main>
	<div id="search_region" class="box master">
		<h2 class="tit_top"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_title01.png" alt="エリアから探す">エリアから探す</h2>
		<div class="search_box pc">
			<div class="region01 style_region"><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/okinawa">沖縄</a></div>
			<!-- /.region01 -->

			<div class="region02 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tottori">鳥取</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/shimane">島根</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/yamaguchi">山口</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/okayama">岡山</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/hiroshima">広島</a></li>
				</ul>
			</div>
			<!-- /.region02 -->

			<div class="region03 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/niigata">新潟</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/toyama">富山</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/ishikawa">石川</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/fukui">福井</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/yamanashi">山梨</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/nagano">長野</a></li>
				</ul>
			</div>
			<!-- /.region03 -->

			<div class="region04 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/aomori">青森</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/iwate">岩手</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/miyagi">宮城</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/akita">秋田</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/yamagata">山形</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/fukushima">福島</a></li>
				</ul>
			</div>
			<!-- /.region04 -->

			<div class="region05 style_region"><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/hokkaido">北海道</a></div>
			<!-- /#region05 -->

			<div class="region06 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/oita">大分</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/saga">佐賀</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kumamoto">熊本</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kagoshima">鹿児島</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/fukuoka">福岡</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/nagasaki">長崎</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/miyazaki">宮崎</a></li>
				</ul>
			</div>
			<!-- /.region06 -->

			<div class="region07 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kagawa">香川</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/ehime">愛媛</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tokushima">徳島</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kochi">高知</a></li>
				</ul>
			</div>
			<!-- /.region07 -->

			<div class="region08 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/shiga">滋賀</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kyoto">京都</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/nara">奈良</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/osaka">大阪府</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/hyogo">兵庫</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/wakayama">和歌山</a></li>
				</ul>
			</div>
			<!-- /.region08 -->

			<div class="region09 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/gifu">岐阜</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/shizuoka">静岡</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/aichi">愛知</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/mie">三重</a></li>
				</ul>
			</div>
			<!-- /.region09 -->

			<div class="region10 style_region">
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/gunma">群馬</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tochigi">栃木</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/ibaraki">茨城</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kanagawa">神奈川</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/saitama">埼玉</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/chiba">千葉</a></li>
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tokyo">東京</a></li>
				</ul>
			</div>
			<!-- /.region10 -->
		</div>
		<!-- /.search_box -->

		<div id="search_list" class="sp">
			<div class="map"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/img_map.jpg" alt="お住いの地域から探す"></div>
			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">北海道エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/hokkaido">北海道</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">東北エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/aomori">青森</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/iwate">岩手</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/miyagi">宮城</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/akita">秋田</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/yamagata">山形</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/fukushima">福島</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">関東エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/gunma">群馬</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tochigi">栃木</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/ibaraki">茨城</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kanagawa">神奈川</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/saitama">埼玉</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/chiba">千葉</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tokyo">東京</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">中部エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/niigata">新潟</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/toyama">富山</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/ishikawa">石川</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/fukui">福井</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/yamanashi">山梨</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/nagano">長野</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/gifu">岐阜</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/shizuoka">静岡</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/aichi">愛知</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/mie">三重</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">近畿エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/shiga">滋賀</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kyoto">京都</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/nara">奈良</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/osaka">大阪府</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/hyogo">兵庫</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/wakayama">和歌山</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">中国エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tottori">鳥取</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/shimane">島根</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/yamaguchi">山口</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/okayama">岡山</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/hiroshima">広島</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">四国エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kagawa">香川</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/ehime">愛媛</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/tokushima">徳島</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kochi">高知</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">九州エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/oita">大分</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/saga">佐賀</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kumamoto">熊本</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/kagoshima">鹿児島</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/fukuoka">福岡</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/nagasaki">長崎</a></li>
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/miyazaki">宮崎</a></li>
			</ul>
			<!-- /.list_search -->

			<a class="trigger" href="<?php echo \Fuel\Core\Uri::base(); ?>">沖縄エリア</a>
			<ul class="acordion_tree">
				<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>area/okinawa">沖縄</a></li>
			</ul>
			<!-- /.list_search -->

		</div>
		<!-- /#search_list -->
	</div>
	<!-- /#search_region -->

	<div id="good" class="box_full accordion master">
		<h2 class="tit_top sty02 pc"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_title02.png" alt="こだわりで探す">こだわりで探す</h2>
		<h2 class="tit_top sty02 sp"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_title02.png" alt="こだわりで探す">こだわりで探す</h2>
		<ul class="toggle clearfix">
			<?php
			foreach(Constants::$trouble_search as $k=>$v)
			{
				?>
				<li><a href="<?php echo \Fuel\Core\Uri::base() ?>kodawari/<?php echo Constants::$trouble_marks[$k]; ?>"><?php echo $v; ?>(<?php echo $trouble_count[$k]; ?>)</a></li>
			<?php
			}
			?>
		</ul>
	</div>
	<!-- /#good -->

	<div id="looking" class="container">
		<h2 class="tit_top sty03 pc"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_title03.png" alt="働き方で探す">働き方で探す</h2>
		<div class="box_full">
			<div class="looking_box accordion clearfix">
				<div class="title_look">
					<p class="pc"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_look02.png" alt="勤務期間">勤務日数</p>
					<p class="sp"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_look06.png" alt="勤務期間">勤務日数で探す</p>
				</div>
				<!-- /.title_look -->
				<ul class="toggle clearfix">
					<li class="color05"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_day_week=1"><span>週1日</span><em>▶</em></a></li>
					<li class="color06"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_day_week=2"><span>週2～3日</span><em>▶</em></a></li>
					<li class="color07"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_day_week=3"><span>週4日～5日</span><em>▶</em></a></li>
					<li class="color08"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_day_week=4"><span>ガッツリ</span><em>▶</em></a></li>
				</ul>
			</div>
			<!-- /.looking_box -->

			<div class="looking_box accordion clearfix">
				<div class="title_look">
					<p class="pc"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_look03.png" alt="時間帯">時間帯</p>
					<p class="sp"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_look07.png" alt="時間帯">時間帯で探す</p>
				</div>
				<!-- /.title_look -->
				<ul class="toggle clearfix">
					<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_time_view[]=1"><span>朝</span><em>▶</em></a></li>
					<li class="color02"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_time_view[]=2"><span>昼</span><em>▶</em></a></li>
					<li class="color03"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_time_view[]=3"><span>夕方・深夜</span><em>▶</em></a></li>
					<li class="color04"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?work_time_view[]=4"><span>深夜･早朝</span><em>▶</em></a></li>
				</ul>
			</div>
			<!-- /.looking_box -->

			<div class="looking_box accordion clearfix">
				<div class="title_look">
					<p class="pc"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_look04.png" alt="雇用形態">雇用形態</p>
					<p class="sp"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_look08.png" alt="雇用形態">雇用形態で探す</p>
				</div>
				<!-- /.title_look -->
				<ul class="toggle clearfix">
					<li class="color05"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?employment_type[]=4"><span class="small_text">アルバイト・パート</span><em>▶</em></a></li>
					<li class="color06"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?employment_type[]=3"><span>正社員</span><em>▶</em></a></li>
					<li class="color07"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?employment_type[]=1"><span>派遣</span><em>▶</em></a></li>
					<li class="color08"><a href="<?php echo \Fuel\Core\Uri::base(); ?>search?employment_type[]=2"><span>契約社員</span><em>▶</em></a></li>
				</ul>
			</div>
			<!-- /.looking_box -->
		</div>
		<!-- /.box_full -->
	</div>
	<!-- /#looking -->

	<div id="recruit" class="box master">
		<div class="col2_box clearfix">

			<?php
			echo Presenter::forge('jobs/urgent');
			echo Presenter::forge('jobs/pickup');
			?>
		</div>
		<!-- /.col2_box -->
	</div>
	<!-- /#recruit -->

	<div id="guide" class="box">
		<h3 class="tit_sub tit_txt">はじめてガイド<span>はじめてご利用される方はこちらをご覧ください。</span></h3>
		<div class="col3_box clearfix">
			<div class="col3"><a href="<?php echo \Fuel\Core\Uri::base(); ?>guide/uos" class="imghover"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/img_guide01.jpg" alt="ユーオーエスとは？"><span class="tit_guide">ユーオーエスとは？</span><span class="guide_txt"> ユーオーエスは、働きたい個人の希望と企業をマッチングからアフターケアーまで… </span></a></div>
			<div class="col3"><a href="<?php echo \Fuel\Core\Uri::base(); ?>guide/career" class="imghover"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/img_guide02.jpg" alt="どんな仕事がある？"><span class="tit_guide">どんな仕事がある？</span><span class="guide_txt"> 全30種のお仕事の他一般応募されていない企業の仕事までコンシェルジュならでは… </span></a></div>
			<div class="col3"><a href="<?php echo \Fuel\Core\Uri::base(); ?>guide/howto" class="imghover"><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/img_guide03.jpg" alt="どうやるの？"><span class="tit_guide">どうやるの？</span><span class="guide_txt"> 手っ取り早く探したい方は、お電話ください。じっくり仕事を見てから相談したいなら… </span></a></div>
		</div>
		<!-- /.col3_box -->
	</div>

	<div class="box" id="about">
		<h3 class="tit_sub tit_txt">おしごとnaviとは？</h3>
		<img alt="おしごとnaviとは" src="<?php echo \Fuel\Core\Uri::base();?>assets/images/index/img_about01.gif" class="left_img">
		<p>
			ガソリンスタンドでのお仕事を中心に一般事務のお仕事、コンビニエンスストアでのお仕事などの求人情報をご紹介しております。<br>
			おしごとnaviの特徴としては、全ての求人案件の細かい情報を把握する専門スタッフが存在するという点です。
		</p>
		<p>
			通常の求人媒体の場合、詳細は求人募集先の担当に直接問い合わせするのが一般的です。<br>
			面接前に確認したいことなど聞き難いこともありますよね？
		</p>
		<p>
			おしごとnaviなら、専門スタッフによる無料コンシェルジュサービスがあるので、面接前に確認したいことが確認できたり、条件面の要望までも事前交渉ができます。最終的には面接が必要になりますが、事前に無料コンシェルジュに確認いただくことで、面接時のミスマッチを事前に回避ができます。また、今は条件に見合う求人がないといった場合でも、事前に要望をお伝えしておいていただくと、条件にあった求人情報が入り次第、無料コンシェルジュからご案内させていただくサポートもございます。
		</p>
		<p>
			おしごとnaviでは、単純に求人情報を載せるだけはなく、働きたい！転職したい！といった方々のお気持ちを全面サポートするための求人情報サイトです。
		</p>
		<p>
			気になる求人がある、条件に見合う求人があれば転職したいなどあれば、まずはおしごとnaviをご利用ください。
		</p>
	</div>
	<!-- /#about -->


	<div class="box" id="useful">
		<h3 class="tit_sub tit_txt">お役立ちコンテンツ</h3>
		<ul>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/female.php">女性が活躍しています</a></li>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/femalestudent.php">女子学生に人気？！</a></li>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/housewife.php">主婦の狙い目バイト</a></li>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/otsu4.php">危険物乙四の取得方法</a></li>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/kiken.php">危険物取扱者</a></li>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/summer.php">夏のガソリンスタンドはきつい？！</a></li>
			<li><a href="<?php echo \Fuel\Core\Uri::base(); ?>useful/winter.php">冬のガソリンスタンドはきつい？！</a></li>
		</ul>

		</p>
	</div>
	<!-- /#about -->



</main>
<!--/main-->
