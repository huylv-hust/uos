<?php

/**
 * Concierge default controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

namespace Skill;

class Controller_Default extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'スキル磨き | しごさが';

		$this->template->content = self::view('default/index');
	}
}
