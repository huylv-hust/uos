<?php echo \Fuel\Core\Asset::js('validate/job.js');?>
<div id="topicPath">
	<ul>
		<li class="home"><a href="<?php echo \Fuel\Core\Uri::base();?>">HOME</a></li>
		<li><?php echo ($is_search) ? $title : '仕事を探す';?></li>
	</ul>
</div>
<main>
	<div id="<?php echo $div_page_id; ?>">
		<div class="section box_full">
			<?php
			if($is_search){
			if($count_job == 0) {?>
				<div class="box_full section mb_clear" id="search_list">
					<div class="tit_search pagination clearfix">
						<span><em>0</em>件中&#12288;1－20件を表示</span>
					</div>
					<div class="container txt_c">
						<p class="no_list">該当するお仕事がありません。</p>
					</div><!-- /.container -->
				</div>
			<?php } else {?>
			<div class="tit_search pagination clearfix">
				<?php
				$end = ($count_job - $filters['offset'] < Constants::$default_limit_pagination) ? $count_job : $filters['offset'] + $filters['limit'];
				?>
				<span><em><?php echo $count_job;?></em>件中&#12288;<?php echo $filters['offset'] + 1;?>－<?php echo $end;?>件を表示</span>
				<?php echo html_entity_decode($pagination);?>
			</div>
			<?php }?>
				<h2 class="tit_main"><?php echo $title?></h2>
				<?php echo \Fuel\Core\Presenter::forge('search/showhtml')->set('filters',$filters);?>
			<?php } else {?>
				<h2 class="tit_main tit_main03">仕事を探す</h2>
				<div class="box case">
					<p>
						仕事をお探しの方は、下記の検索BOXから条件を入力し、「この条件で検索する」を押してください。<br>
						給与・待遇・制服有無などの詳細確認は「詳しく見る」をクリックしてください。
					</p>
				</div>
			<?php }?>

			<div class="container sty_form">
				<form method="get" action="<?php echo \Fuel\Core\Uri::base(); ?>search">
					<div class="case">
						<div class="sty_line tb_styform_warp bg_og">

							<div class="pc" style="">
								<table class="tb_styform tb_sty_line">
									<tbody><tr class="alt">
										<th>エリア</th>
										<td>
											<?php echo Form::select('addr1', isset($filters['addr1']) ? $filters['addr1'] : '', Constants::$addr1); ?>
										</td>
										<th>勤務期間</th>
										<td>
											<?php echo Form::select('work_period', isset($filters['work_period']) ? $filters['work_period'] : '', Constants::$work_period); ?>
										</td>
										<th>勤務日数</th>
										<td>
											<?php echo Form::select('work_day_week', isset($filters['work_day_week']) ? $filters['work_day_week'] : '', Constants::$work_day_week); ?>
										</td>
									</tr>
									</tbody></table>
								<table class="tb_styform ">
									<tbody><tr>
										<th>時間帯</th>
										<td>
											<ul class="list_line clearfix">
												<?php foreach(Constants::$work_time_view as $k => $v) {?>
												<li>
													<?php
													echo Form::checkbox('work_time_view[]', $k, (isset($filters['work_time_view']) && in_array($k, $filters['work_time_view'])) ? true : false).$v;
													?>
												</li>
												<?php }?>
											</ul>
											<!-- /.list_line -->
										</td>
									</tr>
									<tr class="alt">
										<th>雇用形態</th>
										<td>
											<ul class="list_line clearfix">
												<?php foreach(Constants::$employment_type as $k => $v) {?>
												<li>
													<?php
													echo Form::checkbox('employment_type[]', $k, (isset($filters['employment_type']) && in_array($k, $filters['employment_type'])) ? true : false).$v;
													?>
												</li>
												<?php }?>
											</ul>
											<!-- /.list_line -->
										</td>
									</tr>
									<tr>
										<th>こだわり</th>
										<td>

											<?php function show_trouble($start,$count,$trouble = array()){
												$arr_key = array_keys(Constants::$trouble_search);
												$arr_trouble = array_splice($arr_key, $start, $count);
												?>
												<ul class="tb_list">
													<?php foreach($arr_trouble as $key => $val){?>
														<?php
														echo '<li>';
														echo Form::checkbox('trouble[]', $val, (isset($trouble) && in_array($val, $trouble)) ? true : false).Constants::$trouble_search[$val];
														echo '</li>';
														?>
													<?php } ?>
												</ul>
											<?php }?>

											<?php
												$trouble = isset($filters['trouble']) ? $filters['trouble'] : array();
												show_trouble(0,4,$trouble);
												show_trouble(4,4,$trouble);
												show_trouble(8,4,$trouble);
												show_trouble(12,3,$trouble);
											?>
										</td>
									</tr>
									</tbody></table>
							</div>
							<!-- /.pc -->

							<div class="sp">
								<table class="tb_styform ">
									<tbody><tr class="alt">
										<th>エリア</th>
										<td>
											<?php echo Form::select('addr1', isset($filters['addr1']) ? $filters['addr1'] : '', Constants::$addr1, array('class' => 'filed_rea')); ?>
										</td>
									</tr>
									<tr>
										<td>
											<ul class="list_col2">
												<li>
													<span class="tit_tb">勤務期間</span>
													<?php echo Form::select('work_period', isset($filters['work_period']) ? $filters['work_period'] : '', Constants::$work_period); ?>
												</li>
												<li>
													<span class="tit_tb">勤務日数</span>
													<?php echo Form::select('work_day_week', isset($filters['work_day_week']) ? $filters['work_day_week'] : '', Constants::$work_day_week); ?>
												</li>
												<li>
													<span class="tit_tb">時間帯</span>
													<?php echo Form::select('work_time_view[]', isset($filters['work_time_view'][0]) ? $filters['work_time_view'][0] : '', Constants::get_search_work_time_view()); ?>
												</li>
												<li>
													<span class="tit_tb">雇用形態</span>
													<?php echo Form::select('employment_type[]', isset($filters['employment_type'][0]) ? $filters['employment_type'][0] : '', Constants::get_search_employment_type()); ?>
												</li>
											</ul>
										</td>
									</tr>
									<tr class="alt">
										<th>こだわり</th>
										<td>
											<?php echo Form::select('trouble[]', isset($filters['trouble'][0]) ? $filters['trouble'][0] : '', Constants::get_search_trouble()); ?>
										</td>
									</tr>
									</tbody></table>

							</div>
							<!-- /.sp -->

							<table class="tb_styform ">
								<tbody><tr class="clear_line">
									<th>フリーワード</th>
									<td>
										<input id="keyword" type="search" value="<?php echo isset($filters['keyword']) ? trim($filters['keyword']) : '';?>" placeholder="（例）週2&#12288;アルバイト" name="keyword" class="txt_sh">
										<input id="btn_keyword_search" type="submit" style="opacity: 1;" name="submit_keyword" value="検索" class="imghover btn_sh">
									</td>
								</tr>
								</tbody></table>
						</div>
						<!-- /.tb_styform_warp -->
					</div>
					<!-- /.case -->

					<div class="btn_end_search txt_c">
						<input id="btn_search" type="image" src="<?php echo \Fuel\Core\Uri::base()?>assets/common_img/btn_search.png" name="" class="imghover">
					</div>
				</form>
			</div><!-- /.container -->

			<?php if( ! $is_search) {?>
				<div id="recruit" class="box master">
					<div class="col2_box clearfix">
						<?php
						echo Presenter::forge('jobs/urgent');
						echo Presenter::forge('jobs/pickup');
						?>
					</div>
					<!-- /.col2_box -->
				</div>
			<?php } else { ?>
				<?php if($count_job != 0) {?>
					<div class="box_full section mb_clear" id="search_list">
						<div class="box">
							<?php

								foreach($jobs as $job)
								{
									$arr_job[$job->job_id] = $job;
								}


								foreach($arr_id as $job_id)
								{
									echo \Fuel\Core\Presenter::forge('search/job')->set('job', $arr_job[$job_id]);
								}
							?>

						</div>
						<!-- /.box -->
					</div><!-- /.box_full -->

					<div class="box pagination">
						<?php echo html_entity_decode($pagination);?>
					</div><!-- /.pagination -->

				<?php } }?>
		</div>
		<!-- /.section -->
	</div><!-- /#page_search -->
</main>