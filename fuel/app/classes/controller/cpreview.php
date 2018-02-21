<?php
use Fuel\Core\Input;
use \Fuel\Core\Response;


class Controller_Cpreview extends Controller_Uos
{
    public function action_index()
    {
        $job = new Model_Salejob();

        $decoded = Utility::decrypt(Input::get('enc'));
        if ($decoded == null) {
            return new Response('forbidden', 403);
        }

        $params = explode(':', $decoded);
        if (time() - $params[1] > 86400) {
            return new Response('forbidden', 403);
        }

        $data = [];

        if (Input::method() == 'POST') {
            $data['job'] = Input::post();
        } else if (Input::method() == 'GET') {
            $job_id = Input::get('job_id',0);
            if (count($params) != 2 || $job_id != $params[0]) {
                return new Response('forbidden', 403);
            }
            $job = current($job->get_data(array('job_id' => $job_id)));
            $data['job'] = json_decode($job['edit_data'], true);
            if (!$data['job']) { $data['job'] = $job; }
        }

        $data['shop_info'] = Model_Saleshop::find_by_pk($data['job']['shop_id']);
        $data['stations'] = Controller_Search::stations4sale($data['shop_info']->stations);
        $data['customer_info'] = Model_Salecustomer::find_by_pk($data['shop_info']->customer_id);
        $data['is_preview'] = true;
        $this->template->content = self::view('search/cdetail', $data);
    }
}
