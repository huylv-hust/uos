<?php

/**
 * Guide kiken controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_jobchange extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの転職前に知っておくべきこと | しごさが';

		$this->template->content = self::view('default/jobchange');
	}
}
