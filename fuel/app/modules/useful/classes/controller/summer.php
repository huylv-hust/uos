<?php

/**
 * Guide kiken controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_summer extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '夏のガソリンスタンドはきつい？ | おしごとnavi';

		$this->template->content = self::view('default/summer');
	}
}
