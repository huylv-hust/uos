<?php

/**
 * author thuanth6589
 * Class Model_Mailgroup
 */
class Model_Mailgroup extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'mail_group';
    protected static $_primary_key = 'mail_group_id';

    /**
     * select condition
     * @param $filters
     * @param $select
     * @return $this
     */
    private function get_where($filters, $select = 'mail_group.*')
    {
        $query = \Fuel\Core\DB::select($select)->from(self::$_table_name);
        if (isset($filters['partner_sales']) && $filters['partner_sales']) {
            $query->where('partner_sales', 'like', '%' . $filters['partner_sales'] . '%');
        }
        $query->order_by('mail_group.mail_group_id', 'desc');
        return $query;
    }

    /**
     * get data
     * @param array $filters
     * @param string $select
     * @return mixed
     */
    public function get_data($filters = [], $select = 'mail_group.*')
    {
        $query = $this->get_where($filters, $select);
        return $query->execute()->as_array();
    }
}
