<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Search
 */
class Controller_Search extends Controller_Uos
{
	private function get_title($filters = array())
	{
		$arr_search = array(
			'keyword'         => isset($filters['keyword']) ? $filters['keyword'] : '',
			'addr1'           => isset($filters['addr1']) ? $filters['addr1'] : '',
			'work_period'     => isset($filters['work_period']) ? $filters['work_period'] : '',
			'work_day_week'   => isset($filters['work_day_week']) ? $filters['work_day_week'] : '',
			'work_time_view'  => isset($filters['work_time_view']) ? $filters['work_time_view'] : '',
			'employment_type' => isset($filters['employment_type']) ? $filters['employment_type'] : '',
			'trouble'         => isset($filters['trouble']) ? $filters['trouble'] : '',
		);

		$tmp = '';
		foreach($arr_search as $k => $v)
		{
			if($v == '') continue;

			if($k == 'keyword')
			{
				$tmp .= $v.' ';
			}
			else
			{
				$_arr_title = Constants::$$k;
				if(is_array($v))
				{
					foreach($v as $key => $value)
					{
						$tmp .= isset($_arr_title[$value]) ? $_arr_title[$value].' ' : ''.' ';
					}
				}
				else
				{
					$tmp .= isset($_arr_title[$v]) ? $_arr_title[$v].' ' : ''.' ';
				}
			}
		}

		$title = (trim($tmp) != '') ? trim($tmp).'のお仕事を探す' : '仕事を探す';
		return $title;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get list job
	 */
	public function action_index()
	{
		$filters = Input::get();
		unset($filters['page']);
		$url = \Fuel\Core\Uri::base().'search';
		if(empty($filters))
		{
			$data['is_search'] = false;
		}
		else
		{
			$data['is_search'] = true;
			$filters['page'] = \Fuel\Core\Input::get('page');
			if(isset($filters['submit_keyword']))
				$filters = array('keyword' => isset($filters['keyword']) ? $filters['keyword'] : '');

			$query_string = empty($filters) ? '' : '?'.http_build_query($filters);
			$url .= $query_string;
			$job = new \Model_Job();
			$data['count_job'] = $job->count_data($filters);
			$data['pagination'] = Pagination::forge('pagination', array(
				'pagination_url' => $url,
				'total_items'    => $data['count_job'],
				'per_page'       => \Constants::$default_limit_pagination,
				'uri_segment'    => 'page',
			));

			if( ! isset($filters['page']))
			{
				\Fuel\Core\Session::set('seed','');
			}

			$filters['offset'] = $data['pagination']->offset;
			$filters['limit'] = $data['pagination']->per_page;
			$seed = \Fuel\Core\Session::get('seed','');
			if($seed == '')
			{
				$seed = rand(0,9999999);
				\Fuel\Core\Session::set('seed',$seed);
			}

			$filters['order_by'] = 1;
			\Fuel\Core\Session::set('seed',$seed);
			$ids = $job->get_data($filters, $seed, 'job.job_id');
			foreach ($ids as $id)
				$data['arr_id'][] = $id->job_id;

			$filters['array_id'] = empty($data['arr_id']) ? array(0) : $data['arr_id'];
			$data['jobs'] = $job->get_data($filters);
			unset($filters['order_by']);
			unset($filters['array_id']);
			$data['filters'] = $filters;
		}

		$data['div_page_id'] = self::getPageId($filters, isset($data['count_job']) ? $data['count_job'] : 0);

		$data['title'] = $this->get_title($filters);
		\Fuel\Core\Cookie::set('url_job_search', json_encode(array('title' => $data['title'], 'url' => $url)));
		$this->template->content = self::view('search/index',$data);
	}

	private static function getPageId($filters, $count_job)
	{
		if (is_array($filters))
		{
			unset($filters['page']);
			unset($filters['offset']);
			unset($filters['limit']);

			if (count($filters) == 1)
			{
				if (isset($filters['addr1']))
				{
					return 'page_area';
				}
				else if (isset($filters['trouble']))
				{
					return 'page_kodawari';
				}
			}
		}

		return $count_job ? 'page_work' : 'page_search';
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * job detail
	 * @param string $job_id
	 */
	public function action_detail($job_id = '')
	{
		$job = new Model_Job();
		if( ! $job->count_data(array('job_id' => $job_id)))
			return \Fuel\Core\Response::redirect('/search');

		$data['jobs'] = $job->get_data(array('job_id' => $job_id));
		$data['job_adds'] = Model_Jobadd::find_by('job_id',$job_id,'=');
		$data['job_recruits'] = Model_Jobrecruit::find_by('job_id',$job_id,'=');
		$this->template->content = self::view('search/detail', $data);
	}
}