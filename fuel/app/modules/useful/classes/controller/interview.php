<?php

/**
 * Guide interview controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_interview extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの面接対策 | しごさが';

		$this->template->content = self::view('default/interview');
	}
}
