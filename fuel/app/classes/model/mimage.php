<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Mimage
 * @package Model
 */
class Model_Mimage extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_image';
	protected static $_primary_key = 'm_image_id';

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get data image for search
	 * @param $image_list
	 * @return string
	 */
	public static function get_data_image($image_list)
	{
		$image_info = Model_Job::get_random_img($image_list);
		$result = array(
			'data' => '',
			'alt'  => '',
		);
		if($image_info['id'] != '' && $image = Model_Mimage::find_by_pk($image_info['id']))
		{
			$result = array(
				'data' => 'data:'.$image->mine_type.';base64,'.base64_encode($image->content),
				'alt'  => $image_info['alt'],
			);
		}

		return $result;
	}

	public static function get_image_list($image_list)
	{
		$arr_img = json_decode($image_list, true);
		$count = 1;
		$result = array();
		foreach($arr_img as $k => $v)
		{
			if($count == 4) break;
			if($image = static::find_by_pk($k))
			{
				$result[$count][0] = 'data:'.$image->mine_type.';base64,'.base64_encode($image->content);
				$result[$count][1] = $v;
				$count++;
			}
		}

		return $result;
	}
}