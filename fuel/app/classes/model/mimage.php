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
    protected $_data_default;
    public function __construct()
    {
        $this->_data_default = Utility::get_default_data(self::$_table_name);
    }
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
            'alt' => '',
        );
        if ($image_info['id'] != '' && $image = Model_Mimage::find_by_pk($image_info['id'])) {
            $result = array(
                'data' => 'data:' . $image->mine_type . ';base64,' . base64_encode($image->content),
                'alt' => $image_info['alt'],
            );
        }

		return $result;
	}

	public static function get_image_list($image_list)
	{
        $result = array();
		$arr_img = json_decode($image_list, true);
        if (is_array($arr_img) == false) { return $result; }

		$count = 1;
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

    /*
     * @param $m_image
     * @return array
     */
    public function get_list_m_image($m_image)
    {
        $m_image_id = array();
        $m_image_alt = array();
        $m_image = json_decode($m_image, true);
        $arr_res = array();
        if (count($m_image)) {
            foreach ($m_image as $key => $val) {
                $m_image_id[] = $key;
                $m_image_alt[$key] = $val;
            }

            $config['where'][] = array(
                'm_image_id',
                'IN',
                $m_image_id,
            );

            $res = $this->get_list_data($config);
            $i = 0;
            foreach ($res as $row) {
                $arr_res[$i]['m_image_id'] = $row['m_image_id'];
                $arr_res[$i]['content'] = base64_encode($row['content']);
                $arr_res[$i]['width'] = '';
                $arr_res[$i]['height'] = '';
                $arr_res[$i]['mine_type'] = $row['mine_type'];
                $arr_res[$i]['alt'] = $m_image_alt[$row['m_image_id']];
                ++$i;
            }
        }

        return $arr_res;
    }

    /**
     * @param $config
     * @return array|null
     */
    public function get_list_data($config)
    {
        $obj = static::forge()->find($config);
        if(count($obj))
        {
            return $obj;
        }

        return [];
    }

    /**
     * @param $data
     * @return array|bool
     */
    public function insert_image($data)
    {
        if (!isset($data['content'])) {
            return [];
        }
        $data_image_content = $data['content'];
        $data_image_id = $data['m_image_id'];
        $data_image_alt = $data['alt'];
        $data_image_mine_type = $data['mine_type'];
        $res_image = [];
        $data_image = [];
        $res_image_insert = [];
        for ($i = 0; $i < count($data_image_id); ++$i) {
            if ($data_image_id[$i] == '') {
                $data_image[] = array(
                    'm_image_id' => hash('SHA256', base64_decode($data_image_content[$i])),
                    'content' => base64_decode($data_image_content[$i]),
                    'width' => null,
                    'height' => null,
                    'mine_type' => $data_image_mine_type[$i],
                    'alt' => $data_image_alt[$i],
                );
            } else {
                $res_image[$data_image_id[$i]] = $data_image_alt[$i];
            }
        }

        if (count($data_image)) {
            $res_image_insert = $this->insert_multi_data($data_image);
            if ($res_image_insert === false) {
                return false;
            }
        }

        return array_merge($res_image, $res_image_insert);
    }

    /**
     * @param $data
     * @return array|bool|mixed
     * @throws Database_exception
     * @throws Exception
     */
    public function insert_data($data)
    {
        $data['update_at'] = date('Y-m-d H:i');
        $data['create_at'] = date('Y-m-d H:i');
        if (!count($data)) {
            return [];
        }
        foreach ($data as $key => $val) {
            if (!key_exists($key, $this->_data_default)) {
                unset($data[$key]);
            }
        }

        Fuel\Core\DB::query('LOCK TABLES ' . self::$_table_name . ' READ');
        try {
            $check_exits = static::forge()->find_by_pk($data['m_image_id']);
            $res = true;
            if (!count($check_exits)) {
                $data['create_at'] = date('Y-m-d H:i');
                $obj = static::forge();
                $obj->set($data);
                $res = $obj->save();
            }
        } catch (\Database_exception $e) {
            $res = false;
            throw $e;
        }

        Fuel\Core\DB::query('UNLOCK TABLES');
        return $res;
    }

    /**
     * @param $data
     * @return array|bool
     * @throws Database_exception
     */
    public function insert_multi_data($data)
    {
        $res_data = [];
        $check = true;
        foreach ($data as $row) {
            $res = $this->insert_data($row);
            if ($res !== false) {
                $res_data[hash('SHA256', $row['content'])] = $row['alt'];
            } else {
                $check = false;
                break;
            }
        }
        if ($check) {
            return $res_data;
        }
        return false;
    }
}
