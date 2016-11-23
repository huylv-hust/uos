<?php
echo \Fuel\Core\Asset::js('jquery.fadeimg.js');
echo \Fuel\Core\Asset::js('validate/job.js');
$default = json_encode(array('title' => '仕事を探す', 'url' => \Fuel\Core\Uri::base().'search'));
$arr = json_decode(\Fuel\Core\Cookie::get('url_job_search',$default),true);
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
									<td class="first" colspan="2"><?php echo $job->job_category;?></td>
								</tr>
								<tr>
									<!-- employment_mark -->
									<th><span class="ico01">雇用形態</span></th>
									<td class="status">
										<?php
										$employment_mark = trim($job->employment_mark,',') == '' ? array() : explode(',', trim($job->employment_mark, ','));
										foreach($employment_mark as $k => $v)
										{
											echo '<img alt="'.Constants::$employment_mark[$v].'" src="'.\Fuel\Core\Uri::base().'assets/common_img/'.Constants::$ico_employment_mark[$v].'.png">';
										}
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
										<?php
										echo $job->addr2.'【';
										echo '<span class="car">最寄り駅：</span>';
										$station = '';
										if($job->station_line1 || $job->station1)
										{
											$job->station_line1 = ($job->station_line1) ? $job->station_line1.'線' : '';
											$job->station1 = ($job->station1) ? $job->station1.'駅' : '';
											$station .= $job->station_line1.' '.$job->station1.'||';
										}

										if($job->station_line2 || $job->station2)
										{
											$job->station_line2 = ($job->station_line2) ? $job->station_line2.'線' : '';
											$job->station2 = ($job->station2) ? $job->station2.'駅' : '';
											$station .= $job->station_line2.' '.$job->station2.'||';
										}
										if($job->station_line3 || $job->station3)
										{
											$job->station_line3 = ($job->station_line3) ? $job->station_line3.'線' : '';
											$job->station3 = ($job->station3) ? $job->station3.'駅' : '';
											$station .= $job->station_line3.' '.$job->station3.'||';
										}
                                                                                $station = substr($station,0,-2);
                                                                                echo str_replace('||','、', $station);
										//echo trim($station,'、');
										echo '】';
										?>
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
											$arr_trouble = ($job->trouble == '') ? array() : explode(',',trim($job->trouble,','));
											foreach($arr_trouble as $k => $v) {
												if(isset(Constants::$trouble_search[$v]))
													echo '<li><span>'.Constants::$trouble_search[$v].'</span>|</li>';
											}
											?>
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
										<?php
										$i = 1;
										if($job->station_name1 || $job->station_line1 || $job->station1)
										{
											echo '('.$i.')'.$job->station_name1.' '.$job->station_line1.' '.$job->station1.'<br>';
											$i++;
										}

										if($job->station_name2 || $job->station_line2 || $job->station2)
										{
											echo '('.$i.')'.$job->station_name2.' '.$job->station_line2.' '.$job->station2.'<br>';
											$i++;
										}

										if($job->station_name3 || $job->station_line3 || $job->station3)
										{
											echo '('.$i.')'.$job->station_name3.' '.$job->station_line3.' '.$job->station3.'<br>';
										}
										?>
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
											<?php echo Constants::$employment_people[$job->employment_people]; ?>&#12288;&#12288;<?php echo $job->employment_people_num.$people; ?>
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
									<td><?php echo $job->interview_des;?></td>
								</tr>
								<tr>
									<th>応募方法</th>
									<td><?php echo  $job->apply_method;?></td>
								</tr>
								<tr class="alt">
									<th>応募後のプロセス</th>
									<td><?php echo  $job->apply_process;?></td>
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
									<p>東京都品川区南大井6-12-13 宇佐美大森ビル 3階(東京営業所)</p>
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

			</div>
			<!-- /.section -->
		</div><!-- /#page_search -->
	</main>
