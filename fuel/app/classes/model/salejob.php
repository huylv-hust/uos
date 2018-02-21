<?php

/**
 * author thuanth6589
 * Class Model_Salejob
 */
class Model_Salejob extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'sale_job';
    protected static $_primary_key = 'job_id';
    protected static $_properties = array(
        'job_id',
        'plan_code',
        'is_behalf',
        'shop_id',
        'visible_shop_name',
        'start_date',
        'end_date',
        'image_list',
        'access',
        'url_home_page',
        'employment_mark',
        'job_type',
        'job_type2',
        'job_name',
        'salary_type',
        'salary_des',
        'salary_min',
        'catch_copy',
        'lead',
        'work_time_view',
        'work_day_week',
        'work_time_des',
        'qualification',
        'employment_people',
        'employment_people_num',
        'job_title',
        'job_description',
        'recruit_title',
        'recruit_description',
        'trouble',
        'edit_data',
        'is_available',
        'status',
        'created_at',
        'updated_at',
    );

    public $fields = array();
    public $validation;
    public function __construct()
    {
        \Fuel\Core\Config::set('language', 'jp');
        \Fuel\Core\Lang::load('label');
    }

    /**
     * @param $filters
     * @param string $select
     * @return $this
     */
    private function get_where($filters, $select = '*')
    {
        $query = \Fuel\Core\DB::select(
            'sale_job.' . $select, 'sale_shop.shop_name',
            ['sale_job.status', 'sale_job_status'],
            'sale_customer.company_name',
            'sale_customer.email'
        )->from(self::$_table_name);
        $query->join('sale_shop', 'LEFT')->on('sale_shop.shop_id', '=', 'sale_job.shop_id');
        $query->join('sale_customer', 'LEFT')->on('sale_customer.customer_id', '=', 'sale_shop.customer_id');

        if (isset($filters['job_id']) && $filters['job_id']) {
            $query->where('sale_job.job_id', '=', $filters['job_id']);
        }

        if (isset($filters['customer_id']) && $filters['customer_id']) {
            $query->where('sale_shop.customer_id', '=', $filters['customer_id']);
        }

        if (@is_array($filters['status'])) {
            $query->where('sale_job.status', 'IN', $filters['status']);
        }

        if (@is_array($filters['is_available'])) {
            $query->where('sale_job.is_available', 'IN', $filters['is_available']);
        }

        if (isset($filters['keyword']) && $filters['keyword']) {
            $arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword'])));
            $query->and_where_open();
            foreach ($arr_keyword as $k => $v) {
                $query->where(\Fuel\Core\DB::expr('CONCAT(sale_shop.shop_name, sale_shop.shop_kana)'), 'LIKE', '%' . $v . '%');
            }
            $query->and_where_close();
        }

        if (isset($filters['limit']) && $filters['limit']) {
            $query->limit($filters['limit']);
        }

        if (isset($filters['offset']) && $filters['offset']) {
            $query->offset($filters['offset']);
        }

        $query->order_by(self::$_primary_key, 'desc');

        return $query;
    }

    /**
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
     * count data
     * @param array $filters
     * @param string $select
     * @return int
     */
    public function count_data($filters = [], $select = '*')
    {
        $query = $this->get_where($filters, $select);
        return count($query->execute());
    }

    /**
     * create data to save
     * @param $data
     * @return mixed
     */
    public function set_data($data)
    {
        $result['trouble'] = '';
        $result['employment_mark'] = '';
        $result['work_time_view'] = '';
        if (!empty($data['trouble'])) {
            $result['trouble'] = ',';
            foreach ($data['trouble'] as $k => $v) {
                $result['trouble'] .= $v . ',';
            }
        }
        if (!empty($data['employment_mark'])) {
            $result['employment_mark'] = ',';
            foreach ($data['employment_mark'] as $k => $v) {
                $result['employment_mark'] .= $v . ',';
            }
        }
        if (!empty($data['work_time_view'])) {
            $result['work_time_view'] = ',';
            foreach ($data['work_time_view'] as $k => $v) {
                $result['work_time_view'] .= $v . ',';
            }
        }

        foreach ($data as $k => $v) {
            if (in_array($k, self::$_properties) && !is_array($v)) {
                $result[$k] = trim($v) != '' ? trim($v) : null;
            }
        }
        $result['is_behalf'] = isset($result['is_behalf']) ? 1 : 0;
        //image
        if (isset($data['content'])) {
            $result['content'] = $data['content'];
            $result['m_image_id'] = $data['m_image_id'];
            $result['alt'] = $data['alt'];
            $result['mine_type'] = $data['mine_type'];
        }
        return $result;
    }

    /**
     * save sale job
     * @param $data
     * @return bool
     */
    public function save_data($data)
    {
        if (empty($data)) {
            return false;
        }
        try {
            \Fuel\Core\DB::start_transaction();
            $image_obj = new Model_Mimage();

            //insert image
            $res_image = $image_obj->insert_image($data);
            if ($res_image === false) {
                return false;
            }

            //edit
            $data['image_list'] = !empty($res_image) ? json_encode($res_image) : '';
            unset($data['content']);
            unset($data['m_image_id']);
            unset($data['width']);
            unset($data['height']);
            unset($data['alt']);
            unset($data['mine_type']);
            if (isset($data['job_id'])) {
                $json['edit_data'] = json_encode($data);
                $data = $json;
                $this->is_new(false);
            } else {
                $data['edit_data'] = '';
                $data['created_at'] = date('Y-m-d H:i:s', time());
                $data['is_available'] = 0;
            }
            $data['status'] = 0;
            $data['updated_at'] = date('Y-m-d H:i:s', time());
            $this->set($data);
            if (!$this->save()) {
                \Fuel\Core\DB::rollback_transaction();
                return false;
            }

            \Fuel\Core\DB::commit_transaction();
            return true;
        } catch (Exception $e) {
            \Fuel\Core\DB::rollback_transaction();
            return false;
        }
    }

    public function validate()
    {
        $this->validation = \Fuel\Core\Validation::forge('salejob');
        $this->validation->add_callable('myrules');
        $this->validation->add_field('start_date', \Fuel\Core\Lang::get('start_date'), 'required|valid_date[Y-m-d]')->add_rule('before_or_equal', $this->validation->input('end_date'));
        $this->validation->add_field('end_date', \Fuel\Core\Lang::get('end_date'), 'required|valid_date[Y-m-d]')->add_rule('over6months', $this->validation->input('start_date'));
        $this->validation->add_field('shop_id', \Fuel\Core\Lang::get('shop_name'), 'required');
        $this->validation->add_field('access', \Fuel\Core\Lang::get('access'), 'max_length[100]');
        $this->validation->add_field('url_home_page', \Fuel\Core\Lang::get('url_home_page'), 'max_length[50]');
        $this->validation->add_field('employment_mark', \Fuel\Core\Lang::get('employment_mark'), 'required');
        $this->validation->add_field('job_name', \Fuel\Core\Lang::get('job_name'), 'required|max_length[100]');
        $this->validation->add_field('job_type', \Fuel\Core\Lang::get('job_type'), 'required')->add_rule('requiredSelection');
        $this->validation->add_field('job_type2', \Fuel\Core\Lang::get('job_type'), 'required')->add_rule('duplication', $this->validation->input('job_type'));
        $this->validation->add_field('salary_type', \Fuel\Core\Lang::get('salary_type'), 'required|valid_string[numeric]|numeric_max[127]');
        $this->validation->add_field('salary_des', \Fuel\Core\Lang::get('salary_des'), 'required|max_length[100]');
        $this->validation->add_field('salary_min', \Fuel\Core\Lang::get('salary_min'), 'valid_string[numeric]|numeric_max[2147483647]')->add_rule('required_salary_min',  $this->validation->input('salary_type'));
        $this->validation->add_field('catch_copy', \Fuel\Core\Lang::get('catch_copy'), 'max_length[90]');
        $this->validation->add_field('lead', \Fuel\Core\Lang::get('lead'), 'max_length[100]');
        $this->validation->add_field('work_day_week', \Fuel\Core\Lang::get('work_day_week'), 'required|valid_string[numeric]|numeric_max[6]');
        $this->validation->add_field('work_time_des', \Fuel\Core\Lang::get('work_time_des'), 'required');
        $this->validation->add_field('qualification', \Fuel\Core\Lang::get('qualification'), 'max_length[200]');
        $this->validation->add_field('employment_people_num', \Fuel\Core\Lang::get('employment_people_num'), 'valid_string[numeric]|max_length[7]')->add_rule('required_employment_people_num', $this->validation->input('employment_people'));
        $this->validation->add_field('job_title', \Fuel\Core\Lang::get('job_title'), 'max_length[100]');
        $this->validation->add_field('recruit_title', \Fuel\Core\Lang::get('recruit_title'), 'max_length[100]');

        $result = $this->validation->run();
        if (!$result) {
            $result = $this->validation->error_message();
        }
        //image
        $content = $this->validation->input('content');
        if (is_array($content) && count($content) > 4) {
            $result['image_list'] = '最大4枚まで';
        }

        return $result;
    }
}
