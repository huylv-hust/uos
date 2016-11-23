<?php

/**
 * Guide career controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Guide;

class Controller_Career extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'どんな仕事があるの？ | おしごとnavi';

		$this->template->content = self::view('default/career');
	}
}
