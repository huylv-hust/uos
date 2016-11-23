<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_KeepList
 */
class Controller_KeepList extends Controller_Uos
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * show keeplist
	 */
	public function action_index()
	{
		$job = new \Model_Job();
		$filters['bookmark'] = true;
		$data['count_job'] = $job->count_data($filters);
		$data['jobs'] = $job->get_data($filters);
		$data['title'] = 'キープリスト';
		$url = \Fuel\Core\Uri::base().'keeplist';
		\Fuel\Core\Cookie::set('url_job_search', json_encode(array('title' => $data['title'], 'url' => $url)));
		$this->template->content = self::view('keeplist/index',$data);
	}

	public function action_keeplist()
	{
		if(\Fuel\Core\Input::post())
		{
			$job = new Model_Job();
			$return = array();
			if( ! $job_id = \Fuel\Core\Input::post('job_id') or ($job->count_data(array('job_id' => $job_id)) == 0))
			{
				return false;
			}

			$data = json_decode(\Fuel\Core\Cookie::get('bookmark','[]'),true);
			if( ! in_array($job_id,$data) and count($data) >= 20)
			{
				$return['flag'] = 'limitkeeplist';
				return \Fuel\Core\Response::forge(json_encode($return));
			}


			if( ! in_array($job_id,$data))
			{
				$return['flag'] = 'bookmark';
				$data[] = $job_id;
			}
			else
			{
				$key = array_search($job_id, $data);
				unset($data[$key]);
				$return['flag'] = 'un_bookmark';
			}

			\Fuel\Core\Cookie::set('bookmark',json_encode($data),30 * 24 * 60 * 60);
			$return['keeplist'] = $data;
			return \Fuel\Core\Response::forge(json_encode($return));
		}

		return false;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * check end date vs current time
	 */
	public function action_check_time()
	{
		$job_id = \Fuel\Core\Input::post('job_id', 0);
		$result = array('message' => false);
		if($job = Model_Job::find_by_pk($job_id) and $job->count_data(array('job_id' => $job_id)))
		{
			$result = array('message' => true);
		}

		return \Fuel\Core\Response::forge(json_encode($result));
	}
}