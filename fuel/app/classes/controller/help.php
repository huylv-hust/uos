<?php

/**
 * Help controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 01/12/2015
 */

class Controller_Help extends Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ヘルプ・お問い合わせ | おしごとnavi';

		$this->template->content = self::view('general/help');
	}
}
