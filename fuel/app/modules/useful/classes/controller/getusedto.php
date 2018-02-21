<?php

/**
 * Guide getusedto controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_getusedto extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの職場に早く馴染むコツ';

		$this->template->content = self::view('default/getusedto');
	}
}
