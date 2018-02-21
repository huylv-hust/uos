<?php

/**
 * Concierge flow controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

namespace Skill;

class Controller_Flow extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '合格までのフロー | しごさが';

		$this->template->content = self::view('default/flow');
	}
}
