<?php

/**
 * Concierge lecture controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

namespace Skill;

class Controller_Lecture extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '講習概要・料金 | おしごとnavi';

		$this->template->content = self::view('default/lecture');
	}
}
