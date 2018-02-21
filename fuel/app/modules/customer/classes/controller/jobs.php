<?php
namespace Customer;

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * author ThuanTH6589
 * Class Controller_Jobs
 * @package Customer
 */
class Controller_Jobs extends \Controller_CustomerBase
{
    /**
     * list sale job
     */
    public function action_index()
    {
        $login_info = Session::get('login_info');
        $filters = Input::get();
        $query_string = empty($filters) ? '' : '?' . http_build_query($filters);
        $sale_job_obj = new \Model_Salejob();
        $filters['customer_id'] = $login_info['customer_id'];
        unset($filters['limit']);
        $count_sale_job = $sale_job_obj->count_data($filters);
        $pagination = \Uospagination::forge('pagination', array(
            'pagination_url' => Uri::base() . 'customer/jobs' . $query_string,
            'total_items' => $count_sale_job,
            'per_page' => Input::get('limit', \Constants::$default_limit_pagination),
            'num_links' => \Constants::$default_num_links,
            'uri_segment' => 'page',
        ));
        $filters['offset'] = $pagination->offset;
        $filters['limit'] = $pagination->per_page;
        $sale_jobs = $sale_job_obj->get_data($filters);
        $this->template->title = '求人リスト | しごさが';
        $this->template->content = View::forge('job/list', compact('sale_jobs', 'pagination', 'count_sale_job'));
    }


    /**
     * delete sale job
     * @return \Response
     */
    public function action_delete()
    {
        if (Input::method() == 'POST') {
            $job_id = Input::post('job_id');
            if (!$sale_job = \Model_Salejob::find_by_pk($job_id)) {
                $result = false;
                return new \Response($result, 200, array());
            }
            if (\Model_Saleperson::find_one_by_job_id($job_id)) {
                Session::set_flash('error', '該当する応募情報が登録されているため削除できません');
                $result = false;
                return new \Response($result, 200, array());
            }
            if ($sale_job->delete()) {
                $result = true;
                Session::set_flash('success', \Constants::$message_delete_success);
            } else {
                $result = false;
                Session::set_flash('error', \Constants::$message_delete_error);
            }
            return new \Response($result, 200, array());
        }
    }

    public function post_open()
    {
        $job_id = Input::post('job_id');
        $sale_job = \Model_Salejob::find_by_pk($job_id);
        if (!$sale_job) {
            return new \Response(fasle, 200, array());
        }

        $sale_job->is_new(false);
        $sale_job->is_available = 1;
        $sale_job->updated_at = date('Y-m-d H:i:s');
        $sale_job->save();

        Session::set_flash('success', '公開しました');
        return new \Response(true, 200, array());
    }

    public function post_stop()
    {
        $job_id = Input::post('job_id');
        $sale_job = \Model_Salejob::find_by_pk($job_id);
        if (!$sale_job) {
            return new \Response(fasle, 200, array());
        }

        $sale_job->is_new(false);
        $sale_job->is_available = 0;
        $sale_job->updated_at = date('Y-m-d H:i:s');
        $sale_job->save();

        Session::set_flash('success', '非公開にしました');
        return new \Response(true, 200, array());
    }
}
