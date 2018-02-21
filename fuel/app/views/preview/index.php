<?php
echo \Fuel\Core\Asset::js('jquery.fadeimg.js');
echo \Fuel\Core\Asset::js('validate/job.js');
$default = json_encode(array('title' => '仕事を探す', 'url' => \Fuel\Core\Uri::base().'search'));
$arr = json_decode(\Fuel\Core\Cookie::get('url_job_search',$default),true);
$maps = [];
if ($jobs->lat && $jobs->lon) {
    $maps[] = [
        'ssid' => $jobs->ss_id,
        'lat' => (float)$jobs->lat,
        'lon' => (float)$jobs->lon,
        'name' => $jobs->store_name
    ];
}
?>
	<script>
		$(window).load(function(e) {
			// accordion
			$("#tabbox01 a").fadeimg({fadeimg_show: ".show01"});

			// accordion
			if($(window).width() > 768){
				$('.accordion .toggle').show();
			}else{
				$('.accordion .toggle').hide();
			}
			$(".detail_box .sp").accor({conAcc: ".detail_box .toggle"});
		});

        var initMap = function() {
            var maps = <?php echo json_encode($maps) ?>;
            $.each(maps, function() {
                var sspos = {
                    lat : this.lat,
                    lng : this.lon
                };
                var map = new google.maps.Map(document.getElementById('ssmap-' + this.ssid), {
                    center : sspos,
                    streetViewControl: false,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DEFAULT
                    },
                    zoom : 16
                });
                var marker = new google.maps.Marker({
                    position: sspos,
                    map: map,
                    title: this.name
                });
                var infowindow = new google.maps.InfoWindow({
                    content: this.name
                });
                infowindow.open(map, marker);
            });
        };
	</script>
<?php
if( ! count($jobs))
{
	echo '<div style="text-align:center; padding:20px">データがありません</div>';
}
	$job = $jobs;

	$job->start_date = str_replace('-','/',$job->start_date);
	$job->end_date = str_replace('-','/',$job->end_date);
	$mid = '';
	$end = ($job->end_date) ? ' 23:59（終了予定）' : '';
	if($job->start_date || $job->end_date)
	{
		$mid = '～';
		$text = (($job->start_date) ? $job->start_date.'（'.Utility::get_day_of_week($job->start_date).'）' : '').$mid.(($job->end_date) ? $job->end_date.'（'.Utility::get_day_of_week($job->end_date).'）' : '').$end;
	} else {
		$text = '随時募集中！ご応募お待ちしております。';
	}

	?>
	<div id="topicPath">
		<ul>
			<li class="home"><a href="<?php echo \Fuel\Core\Uri::base();?>">HOME</a></li>
			<li><?php echo $job->post_company_name?></li>
		</ul>
	</div>
	<main>

		<div id="page_search_detail">
			<div class="section box">
				<h2 class="tit_main"><?php echo $job->post_company_name?></h2>
				<div class="container" id="search_list">
					<div class="list_box list_wrap">
						<div class="list_search item">
							<table>
								<tbody><tr class="alt">
									<td class="first" colspan="2"><?php echo $job->job_category;?> ID:<?php echo $job->job_id ?></td>
								</tr>
								<tr>
									<!-- employment_mark -->
									<th><span class="ico01">雇用形態</span></th>
									<td class="status">
										<?php
										$employment_mark = trim($job->employment_mark,',') == '' ? array() : explode(',', trim($job->employment_mark, ','));
										$_names = [];
										foreach($employment_mark as $k => $v) {
                                            $_names[] = Constants::$employment_mark[$v];
										}
										echo implode('、', $_names);
										?>
									</td>
								</tr>
								<tr class="alt">
									<th><span class="ico02">給与</span></th>
									<td><?php echo $job->salary_des;?></td>
								</tr>
								<tr>
									<!-- nhà ga -->
									<th><span class="ico03">勤務地</span></th>
									<td>
                                        <div><?php echo $job->store_name ?></div>
                                        <?php if ($job->addr_is_view == 1) { ?>
                                            <div><?php echo \Constants::$addr1[$job->addr1] . $job->addr2 ?></div>
                                        <?php } else { ?>
                                            <div><?php echo \Constants::$addr1[$job->addr1] . $job->addr2 . @$job->addr3 ?></div>
                                        <?php } ?>
                                        <div>
                                            <?php echo $job->traffic ?>
                                            【
                                            <span class="car">最寄り駅：</span>
                                            <?php echo implode('、', $stations) ?>
                                            】
                                        </div>
									</td>
								</tr>
								<tr class="alt">
									<?php
									$tmp = '';
									if($job->work_time_view)
									{
										foreach (Constants::$work_time_view as $key => $val)
										{
											if(substr_count($job->work_time_view,','.$key.','))
												$tmp .= $val.'、';
										}
									}

									$work_time_view = trim($tmp, '、');
									?>
									<th><span class="ico04">時間帯</span></th>
									<td><?php echo $work_time_view;?></td>
								</tr>
								<tr>
									<th><span class="ico05">こだわり</span></th>
									<td>
										<ul>
											<?php
                                            $_troubles = array_column(Trouble::$trouble, 'pubname', 'id');
											$arr_trouble = ($job->trouble == '') ? array() : explode(',',trim($job->trouble,','));
											?>
                                            <?php foreach ($arr_trouble as $v) { if (!$v) { continue; } ?>
                                            <li><span><?php echo htmlspecialchars($_troubles[$v]) ?></span></li>
                                            <?php } ?>
										</ul>
									</td>
								</tr>
								</tbody></table>
						</div>
						<div class="application clearfix">
							<p>
								<span>応募可能期間</span>
								<br class="sp">
								<?php echo $text;?>
							</p>
							<ul>
								<li>
									<?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id',$job->job_id);?>
								</li>
								<li>
									<form method="post" action="<?php echo \Fuel\Core\Uri::base()?>form">
										<input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id;?>" name="job_id">
										<img class="btn_submit_apply_job imghover" alt="応募する" src="<?php echo \Fuel\Core\Uri::base();?>assets/common_img/btn_application02.png">
									</form>
								</li>
							</ul>
						</div><!-- /.application -->
					</div><!-- /.list_box -->
				</div><!-- /#search_list -->


				<div id="tabbox01" class="container pic_l clearfix case">
					<div class="img">
						<div class="pic" id="detail_image">
							<?php
							$image_random_info = Model_Mimage::get_data_image(html_entity_decode($job->image_list));
							?>
							<span style="background-image: url(<?php echo Constants::get_image($image_random_info['data']);?>)" class="image show01"></span>
							<p title="<?php echo $image_random_info['alt'];?>"><?php echo $image_random_info['alt'];?></p>
						</div>
						<div class="thumbnail clearfix">
							<ul class="clearfix">
								<?php
								$image = Model_Mimage::get_image_list(html_entity_decode($job->image_list));
								foreach($image as $k => $v) {?>
									<li>
										<a alt="<?php echo $v[1];?>" href="<?php echo $v[0];?>" style="opacity: 1;">
											<span style="background-image: url(<?php echo Constants::get_image($v[0]);?>)" class="image_detail"></span>
											<img style="height: 126px; display: none" alt="<?php echo $v[1];?>" src="<?php echo Constants::get_image($v[0]);?>">
										</a>
									</li>
								<?php }?>
							</ul>
						</div><!--/.thumbnail-->
					</div><!--/.img-->
					<div class="msg">
						<h3 class="tit_detail"><?php echo $job->catch_copy; ?></h3>
						<?php echo nl2br($job->lead);?>
						<?php if($job->url_youtube) {?>
							<div id="video">
								<h4><span>動画メッセージ</span></h4>
								<iframe width="100%" height="320" src="<?php echo $job->url_youtube;?>" frameborder="0" allowfullscreen></iframe>
							</div><!-- /#video -->
						<?php }?>
					</div><!--/.msg-->
				</div><!-- /.container -->

				<div class="container pack sty_form accordion detail_box">
					<div class="sty_line sty_green pack">
						<div class="title_look">
							<span class="tit_line pc">お仕事情報</span>
							<span class="tit_line sp">お仕事情報</span>
						</div><!--/.title_look-->

						<div class="toggle">
							<table class="tb_styform">
								<tbody><tr class="alt">
									<th>仕事内容</th>
									<td><?php echo $job->job_description;?></td>
								</tr>
								<?php if(isset($job_adds)) {
									foreach($job_adds as $job_add) {?>
										<tr>
											<th><?php echo $job_add->sub_title;?></th>
											<td><?php echo $job_add->text;?></td>
										</tr>
									<?php }}?>
								</tbody></table>
						</div><!--/.toggle-->
					</div><!-- /.sty_line -->

					<div class="application clearfix pc">
						<p>
							<span>応募可能期間</span>
							<br class="sp">
							<?php echo $text;?>
						</p>
						<ul>
							<li>
								<?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id',$job->job_id);?>
							</li>
							<li>
								<form method="post" action="<?php echo \Fuel\Core\Uri::base()?>form">
									<input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id;?>" name="job_id">
									<img class="btn_submit_apply_job imghover" alt="応募する" src="<?php echo \Fuel\Core\Uri::base();?>assets/common_img/btn_application02.png">
								</form>
							</li>
						</ul>
					</div><!-- /.application -->
				</div><!--/.container-->

				<div class="container pack sty_form accordion detail_box">
					<div class="sty_line sty_green pack">
						<div class="title_look">
							<span class="tit_line pc">勤務地・応募対象</span>
							<span class="tit_line sp">勤務地・応募対象</span>
						</div><!--/.title_look-->

						<div class="toggle">
							<table class="tb_styform">
								<tbody><tr>
									<th>勤務地</th>
									<td>
                                        <div><?php echo $job->store_name ?></div>
                                        <?php if ($job->addr_is_view == 1) { ?>
                                            <div><?php echo \Constants::$addr1[$job->addr1] . $job->addr2 ?></div>
                                        <?php } else { ?>
                                            <div><?php echo \Constants::$addr1[$job->addr1] . $job->addr2 . @$job->addr3 ?></div>
                                        <?php } ?>
                                        <div><?php echo $job->traffic ?></div>
                                        <?php if ($job->lat && $job->lon) { ?>
                                            <div id="ssmap-<?php echo $job->ss_id ?>" style="width:100%; height:255px;"></div>
                                        <?php } ?>
									</td>
								</tr>
                                <tr>
                                    <th>最寄り駅</th>
                                    <td>
                                        <?php foreach ($stations as $key => $station) { ?>
                                            <div><?php echo htmlspecialchars($station) ?></div>
                                        <?php } ?>
                                    </td>
                                </tr>
								<tr class="alt">
									<th>勤務曜日・時間</th>
									<td>
										<?php echo $job->work_time_des;?>
									</td>
								</tr>
								<tr>
									<th>資格</th>
									<td><?php echo $job->qualification;?></td>
								</tr>
								<?php if($job->employment_people || $job->employment_people_num) {?>
									<tr class="alt">
										<th>採用予定人数</th>
										<td>
											<?php
											$people = ($job->employment_people_num) ? '人' : '';
											?>
                                            <?php if ($job->employment_people != 7) { ?>
											<?php echo Constants::$employment_people[$job->employment_people]; ?>
                                            &#12288;&#12288;
                                            <?php } ?>
                                            <?php echo $job->employment_people_num.$people; ?>
										</td>
									</tr>
								<?php }?>
								<?php if(isset($job_recruits)) {
									foreach($job_recruits as $job_recruit) {?>
										<tr>
											<th><?php echo $job_recruit->sub_title;?></th>
											<td><?php echo $job_recruit->text;?></td>
										</tr>
									<?php }}?>
								</tbody></table>
						</div><!--/.toggle-->
					</div><!-- /.sty_line -->
					<div class="application clearfix pc">
						<p>
							<span>応募可能期間</span>
							<br class="sp">
							<?php echo $text;?>
						</p>
						<ul>
							<li><?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id',$job->job_id);?></li>
							<li>
								<form method="post" action="<?php echo \Fuel\Core\Uri::base()?>form">
									<input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id;?>" name="job_id">
									<img class="btn_submit_apply_job imghover" alt="応募する" src="<?php echo \Fuel\Core\Uri::base();?>assets/common_img/btn_application02.png">
								</form>
							</li>
						</ul>
					</div><!-- /.application -->
				</div><!--/.container-->

				<div class="container sty_form accordion detail_box">
					<div class="sty_line sty_green">
						<div class="title_look">
							<span class="tit_line pc">応募情報</span>
							<span class="tit_line sp">応募情報</span>
						</div><!--/.title_look-->

						<div class="toggle">
							<table class="tb_styform last">
								<tbody><tr class="alt">
									<th>面接地・他</th>
                                    <td>ご希望の勤務地または、勤務地近隣で行います。場所がわからない方にはご案内いたしますので、お問合せください。</td>
								</tr>
								<tr>
									<th>応募方法</th>
                                    <td>
                                        「応募する」ボタンまたはフリーダイヤルで応募受付中！ 「応募する」ボタンの方は、必要な項目に入力の上、「利用規約に同意して確認画面へ」ボタンを押してください。
                                        次の画面で入力内容をご確認いただき「応募する」ボタンを押して応募完了！24時間いつでも応募ＯＫです！フリーダイヤルの方は、月曜日～土曜日の9～18時の間にお電話ください。
                                        （土曜日は17時まで）お電話でお名前やご希望の店舗をうかがいます！ 日曜・祝日にご応募の場合は、お電話はつながりませんので「応募する」ボタンからご応募ください。
                                    </td>
								</tr>
								<tr class="alt">
									<th>応募後のプロセス</th>
                                    <td>
                                        （１）ご応募後、面接担当からお電話を差し上げます。<br>
                                        （２）面接担当とご相談の上、面接の日程・時間・場所を決定します。ご希望があれば面接担当にお気軽にご相談ください。<br>
                                        （３）面接担当とのお電話で、面接時のお持物をお伝えします。<br>
                                        （４）当日、面接時間にお越しください。途中で道に迷ってしまったり、急にご都合が悪くなった場合は面接担当に直接お電話ください。面接へのお越しをお待ちしております。<br>
                                        （５）面接後、1週間前後で面接担当から採否についてお電話をいたします。<br>
                                        （６）採用の場合、勤務開始の日程をご相談します。<br>
                                        （７）日程が決まりましたら、勤務開始に必要な書類などについて担当からお伝えします。<br>
                                        （８）当日、お約束の時間にお越しください。あなたの制服をご用意してお待ちしております。
                                    </td>
								</tr>
								<tr>
									<th>代表問い合わせ先</th>
									<td>
										<p><?php
											if(trim($job->phone_number1,','))
												echo $job->phone_name1.' '.str_replace(',','-',$job->phone_number1)?></p>
										<p><?php
											if(trim($job->phone_number2,','))
												echo $job->phone_name2.' '.str_replace(',','-',$job->phone_number2)?></p>
									</td>
								</tr>
								</tbody></table>

							<div class="clearfix" id="company">
								<div class="info">
									<p class="title"><?php echo $job->post_company_name;?></p>
								</div>
								<?php if($job->url_home_page) {?>
									<div class="btn">
										<a target="_blank" href="<?php echo $job->url_home_page?>"><img alt="ホームページを見る" src="<?php echo \Fuel\Core\Uri::base()?>assets/images/search/btn_detail.png" class="imghover"></a>
									</div><!--/.btn-->
								<?php }?>
							</div>
						</div><!--/.toggle-->

					</div><!-- /.sty_line -->
				</div><!--/.container-->

				<div class="application app_big pc clearfix">
					<ul>
						<li>
							<?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id',$job->job_id);?>
						</li>
						<li>
							<form method="post" action="<?php echo \Fuel\Core\Uri::base()?>form">
								<input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id;?>" name="job_id">
								<img class="btn_submit_apply_job imghover" alt="応募する" src="<?php echo \Fuel\Core\Uri::base();?>assets/common_img/btn_application02.png">
							</form>
						</li>
					</ul>
					<p>
						<span>応募可能期間</span>
						<br class="sp">
						<?php echo $text;?>
					</p>
				</div><!-- /.application -->

				<div class="application sp clearfix">
					<p>
						<span>応募可能期間</span>
						<br class="sp">
						<?php echo $text;?>
					</p>
					<ul>
						<li>
							<?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id',$job->job_id);?>
						</li>
						<li>
							<form method="post" action="<?php echo \Fuel\Core\Uri::base()?>form">
								<input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id;?>" name="job_id">
								<img class="btn_submit_apply_job imghover" alt="応募する" src="<?php echo \Fuel\Core\Uri::base();?>assets/common_img/btn_application02.png">
							</form>
						</li>
					</ul>
				</div><!-- /.application -->

                <?php if (count($recommends) > 0) { ?>
                    <div class="recommend_box_area">
                        <div class="col2 pick_up">
                            <h2><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_recruit02.png" alt="">PICK UP</h2>
                            <?php foreach ($recommends as $recommend) {
                                $image = Model_Mimage::get_data_image(html_entity_decode($recommend['image_list']));
                                ?>
                                <div class="line">
                                    <a href="<?php echo \Fuel\Core\Uri::base() ?>search/detail/<?php echo $recommend['job_id'] ?>" class="job pic_l imghover clearfix" style="opacity: 1;">
                                        <span class="img"><img src="<?php echo Constants::get_image($image['data']); ?>" alt=""></span>
                                        <span class="msg">
                                    <span class="detail"><?php echo $recommend['job_category'] ?></span>
                                    <em><?php echo htmlspecialchars($recommend['post_company_name']) ?></em>
                                    <span class="place"><?php echo htmlspecialchars($recommend['store_name']) ?></span>
                                    <span class="yen"><?php echo htmlspecialchars($recommend['salary_des']) ?></span>
                                </span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

			</div>
			<!-- /.section -->
		</div><!-- /#page_search -->
	</main>

<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=<?php echo \Fuel\Core\Config::get('gmap_key') ?>">
</script>
