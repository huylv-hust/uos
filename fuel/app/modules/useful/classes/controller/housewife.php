<?php

/**
 * Guide housewife controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_housewife extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '主婦の狙い目バイト | しごさが';

		$this->template->content = self::view('default/housewife');
	}
}
