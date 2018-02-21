<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 */
class Presenter_Search_Showhtml extends Presenter
{
	public function view()
	{
		$filters = $this->filters;
		unset($filters['page']);
		unset($filters['offset']);
		unset($filters['limit']);
		$view = '';
		if(count($filters) == 1)
		{
			if(isset($filters['addr1']) && $filters['addr1'] && isset(Constants::$addr1[$filters['addr1']]))
				$view = \Fuel\Core\View::forge('search/addr1/'.$filters['addr1']);
            $_troubles = array_column(Trouble::$trouble, 'pubname', 'id');
			if(isset($filters['trouble']) && is_array($filters['trouble']) && isset($_troubles[$filters['trouble'][0]]))
				$view = \Fuel\Core\View::forge('search/trouble/'.$filters['trouble'][0]);
		}

		$this->data = $view;
	}
}
