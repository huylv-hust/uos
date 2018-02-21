<?php

/**
 * @author NamDD6566 <namdd6566@seta-asia.com.vn>
 * @package Model
 */
class Model_Saleshop extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'sale_shop';
    protected static $_primary_key = 'shop_id';
    protected static $_properties = array(
        'shop_id',
        'customer_id',
        'shop_name',
        'shop_kana',
        'prefecture_id',
        'city',
        'town',
        'access',
        'stations',
        'mark_info',
        'note',
        'created_at',
        'updated_at'
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property' => 'created_at',
            'overwrite' => true,
        ),
    );

    private $obj = null;

    function __construct()
    {
    }

    public function validate()
    {

        \Fuel\Core\Config::set('language', 'jp');
        \Fuel\Core\Lang::load('label');
        $validation = \Fuel\Core\Validation::forge('saleshop');
        $validation->add_callable('myrules');
        $validation->add_field('shop_name', \Fuel\Core\Lang::get('shop_name'), 'required|max_length[50]');
        $validation->add_field('shop_kana', \Fuel\Core\Lang::get('shop_kana'), 'required|kana|max_length[50]');
        $validation->add_field('prefecture_id', \Fuel\Core\Lang::get('prefecture_id'), 'required');
        $validation->add_field('city', \Fuel\Core\Lang::get('city'), 'required|max_length[10]');
        $validation->add_field('town', \Fuel\Core\Lang::get('town'), 'max_length[50]');
        $validation->add_field('mark_info', \Fuel\Core\Lang::get('mark_info'), 'max_length[100]');
        $validation->add_field('access', \Fuel\Core\Lang::get('access'), 'max_length[50]');
        for($i = 0 ; $i < 3; ++$i){
            $validation->add_field('station_time['.$i.']',\Fuel\Core\Lang::get('station_time'),'valid_string[numeric]|max_length[2]');
        }

        return !$validation->run() ? $validation->error_message() : array();
    }

    /**
     * @param $filters
     * @return mixed
     */
    private function get_where($filters)
    {
        $query = DB::select(
            'sale_shop.shop_id',
            'sale_shop.customer_id',
            'sale_shop.shop_name',
            'sale_shop.shop_kana',
            'sale_shop.prefecture_id',
            'sale_shop.town',
            'sale_shop.city',
            'sale_shop.created_at',
            'sale_shop.updated_at',
            'sale_shop.access',
            'sale_shop.application_price',
            'sale_shop.employment_price',
            'sale_customer.company_name'
        )->from(self::$_table_name);
        $query->join('sale_customer', 'LEFT')->on('sale_shop.customer_id', '=', 'sale_customer.customer_id');
        if (isset($filters['keyword_search_screen_shop']) && $filters['keyword_search_screen_shop']) {
            $arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword_search_screen_shop'])));
            $query->and_where_open();
            foreach ($arr_keyword as $k => $v) {
                $query->where(\Fuel\Core\DB::expr('CONCAT(sale_customer.company_name, sale_customer.company_kana, sale_shop.shop_name, sale_shop.shop_kana)'), 'LIKE', '%' . $v . '%');
            }
            $query->and_where_close();
        }

        if(isset($filters['customer_id']) && $filters['customer_id']) {
            $query->where('sale_shop.customer_id', '=', $filters['customer_id']);
        }

        if (isset($filters['keyword_modal_sale_job']) && $filters['keyword_modal_sale_job']) {
            $arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword_modal_sale_job'])));

            if(count($arr_keyword)) {
                foreach ($arr_keyword as $k => $v) {
                    $query->and_where_open();
                    $query->where(\Fuel\Core\DB::expr('
                        CONCAT(
                            sale_shop.shop_name,
                            sale_shop.shop_kana,
                            sale_shop.city,
                            sale_shop.town,
                            sale_shop.access,
                            sale_shop.mark_info,
                            sale_shop.note
                        )'
                    ), 'LIKE', '%' . $v . '%');

                    $jsonStr = str_replace(
                        '\\',
                        '\\\\',
                        trim(json_encode($v), '"')
                    );
                    $query->or_where('sale_shop.stations', 'LIKE', '%' . $jsonStr . '%');
                    $query->and_where_close();
                }
            }
        }

        if (isset($filters['limit']) && $filters['limit']) {
            $query->limit($filters['limit']);
        }

        if (isset($filters['offset']) && $filters['offset']) {
            $query->offset($filters['offset']);
        }

        $query->order_by('sale_shop.shop_id', 'desc');
        return $query;
    }

    /**
     * Get data
     * @param array $filters
     * @param string $select
     * @return mixed
     */
    public function get_data($filters = [], $select = '*')
    {
        $query = $this->get_where($filters, $select);
        return $query->execute()->as_array();
    }

    /**
     * @param $data
     * @param int $id
     * @return bool
     */
    public function save_data($data, $id = 0)
    {
        if ($id == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->obj = static::forge();
            $this->obj->set($data);
            $res = $this->obj->save();
            return $res['0'];
        }
        $this->obj = static::forge()->find_by_pk($id);
        if (count($this->obj)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->obj->set($data);
            $this->obj->is_new(false);
            return (boolean)$this->obj->save();
        }

        return false;
    }

    public function lastInsertId()
    {
        return $this->obj != null ? $this->obj->shop_id : null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete_data($id)
    {
        $obj = static::forge()->find_by_pk($id);
        if (count($obj)) {
            return $obj->delete();
        }

        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public function get_info_data(&$id)
    {
        $obj = static::forge()->find_by_pk($id);
        if ($obj !== null) {
            $id = $obj->_data['shop_id'];
            return $obj->_data;
        }
        $id = 0;
        return array_fill_keys(self::$_properties, null);
    }

    /**
     * @param array $filters
     * @return int
     */
    public function count_data($filters = array())
    {
        $query = $this->get_where($filters);
        return count($query->execute());
    }

}
