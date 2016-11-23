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

$data->work_time_view = trim($tmp, '、');
$data->start_date = str_replace('-','/',$data->start_date);
$data->end_date = str_replace('-','/',$data->end_date);
?>
<div class="list_box container" id="item-job-<?php echo $data->job_id; ?>">
	<div class="tit_list clearfix">
		<a href="<?php echo \Fuel\Core\Uri::base()?>search/detail/<?php echo $data->job_id?>"></a>
		<p><a href="<?php echo \Fuel\Core\Uri::base()?>search/detail/<?php echo $data->job_id?>"><?php echo $data->catch_copy; ?></a>
			<span><?php echo $data->post_company_name; ?></span>
		</p>
	</div>
	<!-- /.tit_list -->
	<div class="list_wrap">
		<div class="pic_l clearfix">
			<div class="img search_img">
				<a href="<?php echo \Fuel\Core\Uri::base()?>search/detail/<?php echo $data->job_id?>">
					<span class="image" style="background-image:url(<?php echo Constants::get_image($data->image['data']); ?>)"></span>
				</a>
			</div>
			<div class="msg list_search">
				<table>
					<tbody>
					<tr class="alt">
						<td class="first" colspan="2"><?php echo $data->job_category ?></td>
					</tr>
					<tr>
						<th><span class="ico01">雇用形態</span></th>
						<td class="status">
							<?php
							$employment_mark = trim($data->employment_mark,',') == '' ? array() : explode(',', trim($data->employment_mark, ','));
							foreach($employment_mark as $k => $v)
							{
								echo '<img alt="'.Constants::$employment_mark[$v].'" src="'.\Fuel\Core\Uri::base().'assets/common_img/'.Constants::$ico_employment_mark[$v].'.png">';
							}
							?>
						</td>
					</tr>

					<tr class="alt">
						<th><span class="ico02">給与</span></th>
						<td><?php echo $data->salary_des;?></td>
					</tr>
					<tr>
						<th><span class="ico03">勤務地</span></th>
						<td>
							<?php
								echo $data->addr2.'【';
								echo '<span class="car">最寄り駅：</span>';
								$station = '';
								if($data->station_line1 || $data->station1)
								{
									$data->station_line1 = ($data->station_line1) ? $data->station_line1.'線' : '';
									$data->station1 = ($data->station1) ? $data->station1.'駅' : '';
									$station .= $data->station_line1.' '.$data->station1.'||';
								}

								if($data->station_line2 || $data->station2)
								{
									$data->station_line2 = ($data->station_line2) ? $data->station_line2.'線' : '';
									$data->station2 = ($data->station2) ? $data->station2.'駅' : '';
									$station .= $data->station_line2.' '.$data->station2.'||';
								}

								if($data->station_line3 || $data->station3)
								{
									$data->station_line3 = ($data->station_line3) ? $data->station_line3.'線' : '';
									$data->station3 = ($data->station3) ? $data->station3.'駅' : '';
									$station .= $data->station_line3.' '.$data->station3.'||';
								}
                                                                $station = substr($station,0,-2);
                                                                echo str_replace('||','、', $station);
								//echo trim($station,'、');
								echo '】';
							?>
						</td>
					</tr>

					<tr class="alt">
						<th><span class="ico04">時間帯</span></th>
						<td><?php echo $data->work_time_view?></td>
					</tr>
					<tr>
						<th><span class="ico05">こだわり</span></th>
						<td>
							<ul>
								<?php foreach($data->trouble as $k => $v) {
									if(isset(Constants::$trouble_search[$v]))
										echo '<li><span>'.Constants::$trouble_search[$v].'</span>|</li>';
								 }
								?>
							</ul>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.container -->
		<p class="txt"><?php echo nl2br($data->lead);?></p>

		<div class="detail_link_wrap"><a href="<?php echo \Fuel\Core\Uri::base()?>search/detail/<?php echo $data->job_id?>" class="detail_link_btn"><span>詳細はこちら</span></a></div>
		<div class="application clearfix">
			<?php
			$mid = '';
			$end = ($data->end_date) ? ' 23:59（終了予定）' : '';
			if($data->start_date || $data->end_date)
			{
				$mid = '～';
				$text = (($data->start_date) ? $data->start_date.'（'.Utility::get_day_of_week($data->start_date).'）' : '').$mid.(($data->end_date) ? $data->end_date.'（'.Utility::get_day_of_week($data->end_date).'）' : '').$end;
			} else {
				$text = '随時募集中！ご応募お待ちしております。';
			}
			?>
			<p><span>応募可能期間</span><br class="sp"><?php echo $text;?></p>
			<ul>
				<li><?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $data->job_id);?></li>
				<li>
					<form method="post" action="<?php echo \Fuel\Core\Uri::base()?>form">
						<input type="hidden" class="hidden_job_id" value="<?php echo $data->job_id;?>" name="job_id">
						<img class="btn_submit_apply_job imghover" alt="応募する" src="<?php echo \Fuel\Core\Uri::base();?>assets/common_img/btn_application02.png">
					</form>
				</li>
			</ul>
		</div>
		<!-- /.application -->
	</div>
	<!-- /.list_wrap -->
</div>
