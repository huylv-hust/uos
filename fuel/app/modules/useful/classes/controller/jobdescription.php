<?php

/**
 * Guide jobdescription controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_jobdescription extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの業務内容 | しごさが';

		$this->template->content = self::view('default/jobdescription');
	}
}
