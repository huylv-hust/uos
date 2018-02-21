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
										<th>市区町村</th>
										<td colspan="3">
											<input class="imp_txt" name="addr23" value="<?php echo isset($filters['addr23']) ? trim($filters['addr23']) : '';?>" placeholder="" type="text">
										</td>
									</tr>
									<tr class="">
										<th>勤務期間</th>
										<td>
											<?php echo Form::select('work_period', isset($filters['work_period']) ? $filters['work_period'] : '', Constants::$work_period); ?>
										</td>
										<th>勤務日数</th>
										<td>
											<?php echo Form::select('work_day_week', isset($filters['work_day_week']) ? $filters['work_day_week'] : '', Constants::$work_day_week); ?>
										</td>
										<th>時給</th>
										<td>
											<?php echo Form::select('salary_min', isset($filters['salary_min']) ? $filters['salary_min'] : '', Constants::$salary_min); ?>
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

                                    <?php foreach (Trouble::$categories as $ccode => $category) { ?>
                                    <tr>
                                        <th><?php echo htmlspecialchars($category['name']) ?></th>
                                        <td>
                                            <ul class="tb_list">
                                            <?php
                                                $_row = 0;
                                                $_counter = 0;
                                                foreach (Trouble::$trouble as $_trouble) {
                                                    $_counter++;
                                                    if ($ccode != $_trouble['category'] || $_trouble['pubname'] == null) { continue; }
                                                    $_row++;
                                            ?>
                                            <li><input name="trouble[]" value="<?php echo $_trouble['id'] ?>" type="checkbox" id="form_trouble[]"<?php echo isset($filters['trouble']) && in_array($_trouble['id'], $filters['trouble']) ? ' checked' : '' ?>><?php echo htmlspecialchars($_trouble['pubname']) ?></li>
                                            <?php if ($_row % 5 == 0 && count(Trouble::$trouble) > $_counter) { ?>
                                            </ul>
                                            <ul class="tb_list">
                                            <?php } ?>
                                            <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php } ?>

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
									<tr class="alt">
										<th>市区町村</th>
										<td>
											<input class="imp_txt" name="addr23" value="<?php echo isset($filters['addr23']) ? trim($filters['addr23']) : '';?>" placeholder="" type="text">
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
										<th>時給</th>
										<td>
											<?php echo Form::select('salary_min', isset($filters['salary_min']) ? $filters['salary_min'] : '', Constants::$salary_min); ?>
										</td>
									</tr>

                                    <?php foreach (Trouble::$categories as $ccode => $category) { ?>
                                    <tr>
                                        <th><?php echo htmlspecialchars($category['name']) ?></th>
                                        <td>
                                            <select name="trouble[]">
                                                <option value="">選択してください。</option>
                                                <?php
                                                    foreach (Trouble::$trouble as $_trouble) {
                                                        if ($ccode != $_trouble['category'] || $_trouble['pubname'] == null) { continue; }
                                                ?>
                                                <option value="<?php echo $_trouble['id'] ?>"<?php echo isset($filters['trouble']) && in_array($_trouble['id'], $filters['trouble']) ? ' selected' : '' ?>><?php echo htmlspecialchars($_trouble['pubname']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php } ?>

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
                                    echo \Fuel\Core\Presenter::forge('search/job')->set('job', $job)->set('stations', $stations[$job->job_id]);
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
