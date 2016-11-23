<?php

/**
 * Guide female controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_female extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '女子学生に人気？！ | おしごとnavi';

		$this->template->content = self::view('default/female');
	}
}
