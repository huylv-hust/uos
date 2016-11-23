<?php

class Controller_Uos extends Controller_Template
{
	public function __construct()
	{
		$data_keeplist = json_decode(\Fuel\Core\Cookie::get('bookmark','[]'),true);
		foreach($data_keeplist as $k => $v)
		{
			if($this->delete_keeplist($v))
			{
				unset($data_keeplist[$k]);
			}
		}

		\Fuel\Core\Cookie::set('bookmark',json_encode($data_keeplist),30 * 24 * 60 * 60);
	}

	public function delete_keeplist($id_job)
	{
		$filter = array(
			'job_id' => $id_job
		);
		$job = new Model_Job();
		if($job->count_data($filter) == 0)
		{
			return true;
		}

		return false;
	}

	public function before()
	{
		parent::before();
		//set_exception_handler(array($this, 'exception_handler'));
		$this->template = self::view('template');
		$this->template->head = self::view('partials/head');
		//navigator
		$this->template->navigator = self::view('partials/navi');
		//breadcrumb
		$this->template->breadcrumb = null;
		//footer - footer of page
		$jobs = new Model_Job();
		$filters['bookmark'] = true;
		$data['countkeeplist'] = $jobs->count_data($filters);
		$this->template->footer = self::view('partials/footer',$data);

	}

	public static function view($file, $data = array())
	{
		return (View::forge($file, $data));
	}

	public function set_teamplate()
	{
		$this->template->head = self::view('partials/head');
		//navigator
		$this->template->navigator = self::view('partials/navi');
		//footer - footer of page
		$this->template->footer = self::view('partials/footer');
	}
	/**
	 * set session
	 * @param type $name
	 * @param type $value
	 * @return type
	 */
	public function set_session($name,$value)
	{
		$config = array('expiration_time' => 3600);
		$session = \Session::forge($config);
		Fuel\Core\Session::delete($name);
		return $session->set($name,$value);
	}
	/**
	 *
	 * @param type $name
	 * @return type
	 */
	public function get_session($name)
	{
		return \Session ::get($name);
	}

	public function clear_all_session()
	{

	}
}
