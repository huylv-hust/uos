<?php

/**
 * Guide benefits controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Guide;

class Controller_Benefits extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '充実した福利厚生 | しごさが';

		$this->template->content = self::view('default/benefits');
	}
}
