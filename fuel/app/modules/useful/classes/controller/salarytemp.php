<?php
/**
 * Guide salarytemp controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_salarytemp extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの給料（派遣・業務請負編） | しごさが';

		$this->template->content = self::view('default/salarytemp');
	}
}