<?php

/**
 * Guide about controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Guide;

class Controller_About extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'しごさがとは？ | しごさが';

		$this->template->content = self::view('default/about');
	}
}
