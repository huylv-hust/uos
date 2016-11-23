<?php

/**
 * Guide default controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

namespace Guide;

class Controller_Default extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'はじめてガイド | おしごとnavi';

		$this->template->content = self::view('default/index');
	}
}
