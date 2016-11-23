<?php

/**
 * Guide otsu4 controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_otsu4 extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '危険物乙四の取得方法 | おしごとnavi';

		$this->template->content = self::view('default/otsu4');
	}
}
