<?php

/**
 * Guide kiken controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_recruiting extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンド求人の選び方 | しごさが';

		$this->template->content = self::view('default/recruiting');
	}
}
