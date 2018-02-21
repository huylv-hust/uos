<?php

/**
 * Guide servicetype controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_servicetype extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの提供サービスの種類 | しごさが';

		$this->template->content = self::view('default/servicetype');
	}
}
