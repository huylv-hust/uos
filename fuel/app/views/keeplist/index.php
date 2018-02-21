<?php echo \Fuel\Core\Asset::js('validate/job.js');?>
<div id="topicPath">
	<ul>
		<li class="home"><a href="<?php echo \Fuel\Core\Uri::base();?>">HOME</a></li>
		<li><?php echo $title;?></li>
	</ul>
</div>
<main>
	<?php
		$id = ($count_job == 0) ? 'page_search' : 'page_keeplist';
	?>
	<div id="<?php echo $id;?>">
		<div class="section box_full">
			<h2 class="tit_main tit_main02"><?php echo $title?></h2>
			<div class="box pack">
				<p>最大20件まで保存可能です。</p>
			</div>
			<?php if($count_job == 0) {?>
				<div class="box_full section mb_clear" id="search_list">
					<div class="tit_search pagination clearfix">
						<span><em>0</em>件中&#12288;1－20件を表示</span>
					</div>
					<div class="container txt_c">
						<p class="no_list">該当するお仕事がありません。</p>
					</div><!-- /.container -->
				</div>
			<?php } else {
				$arr = json_decode(\Fuel\Core\Cookie::get('bookmark', '[0]'), true);
				$arr_sort = array_reverse($arr);
				foreach($jobs as $job)
				{
					$arr_job[$job->job_id] = $job;
				}
				?>
				<div id="search_list">
					<div class="tit_search pagination clearfix">
						<span><em id="keeplist_count_job"><?php echo $count_job;?></em>件中&#12288;1－20件を表示</span>
					</div>
					<div class="box">
						<?php
							foreach($arr_sort as $k => $v)
							{
								if(isset($arr_job[$v]))
								{
									echo \Fuel\Core\Presenter::forge('search/job')->set('job', $arr_job[$v])->set('stations', $stations[$job->job_id]);
								}
							}
						?>
					</div>
					<!-- /.box -->
				</div><!-- /.box_full -->
			<?php }?>
		</div>
		<!-- /.section -->
	</div><!-- /#page_search -->
</main>
