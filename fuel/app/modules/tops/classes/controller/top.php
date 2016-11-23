<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace Tops;

use Fuel\Core\Controller;
use Fuel\Core\Presenter;
use Parser\View;

class Controller_Top extends \Controller_Uos
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action top
	 */
	public function action_index()
	{
		\Fuel\Core\Cookie::set('url_job_search', json_encode(array('title' => 'Home', 'url' => '')));// For Thuan
		$data = array();
		$job = new \Model_Job();
		$filter_new = array(
			'new_updated' => date('Y-m-d', strtotime("-2 week"))
		);
		$filter_last_updated = array(
			'select'   => array('updated_at'),
			'order_by' => array('updated_at' => 'desc'),
			'limit'    => 1
		);
		$troubles = $job->get_data();
		$count = array();
		foreach(\Constants::$trouble as $k => $v)
		{
			$count[$k] = 0;
			foreach($troubles as $trouble)
			{
				$num = substr_count($trouble->trouble, ','.$k.',');

				if($num > 0)
					$count[$k] = $count[$k] + 1;
			}
		}

		$data['trouble_count'] = $count;
		$data['count_job'] = $job->count_data();
		$data['count_job_new'] = $job->count_data($filter_new);
		$last_updated_at = \Model_Job::find($filter_last_updated);
		if ($last_updated_at === null)
		{
			$data['last_updated_at'] = '';
		} else {
			$data['last_updated_at'] = date('m/d',strtotime($last_updated_at[0]->updated_at));
		}
		$this->template->title = 'おしごとnavi';
		$this->template->content = \View::forge('top/index',$data);
	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action error 404
	 */

	public function action_404()
	{
		$this->template->content = \View::forge('top/404');
	}

}