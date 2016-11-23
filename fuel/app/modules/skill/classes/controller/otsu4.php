<?php

/**
 * Concierge otsu4 controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

namespace Skill;

class Controller_Otsu4 extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'スキル磨き | おしごとnavi';

		$this->template->content = self::view('default/otsu4');
	}
}
