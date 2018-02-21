<?php

/**
 * Guide service controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_service extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの接客スキル〜基本編〜 | しごさが';

		$this->template->content = self::view('default/service');
	}
}
