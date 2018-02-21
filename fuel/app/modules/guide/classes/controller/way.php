<?php

/**
 * Guide way controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Guide;

class Controller_Way extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '求人情報の見方 | しごさが';

		$this->template->content = self::view('default/way');
	}
}
