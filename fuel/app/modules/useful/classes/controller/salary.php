<?php
/**
 * Guide salary controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_salary extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの給料（正社員・アルバイト編） | しごさが';

		$this->template->content = self::view('default/salary');
	}
}
