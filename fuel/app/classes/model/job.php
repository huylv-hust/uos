<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Mss
 * @package Model
 */
class Model_Job extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'job';
	protected static $_primary_key = 'job_id';

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $filters
	 * @return $this
	 */
	private function _get_where($filters = array(), $seed = '', $select = '')
	{
		if($select != '')
			$query = \Fuel\Core\DB::select($select)->from(self::$_table_name);
		else
			$query = \Fuel\Core\DB::select(
			    'job.*',
                'm_ss.station_name1', 'm_ss.station_name2', 'm_ss.station_name3',
                'm_ss.station_line1', 'm_ss.station_line2', 'm_ss.station_line3',
                'm_ss.station1', 'm_ss.station2', 'm_ss.station3',
                'm_ss.station_walk_time1', 'm_ss.station_walk_time2', 'm_ss.station_walk_time3',
                'm_ss.addr1', 'm_ss.addr2','m_ss.addr3',
                'm_ss.lat', 'm_ss.lon'
            )->from(self::$_table_name);

		$query->join('m_ss', 'left')->on('m_ss.ss_id', '=', 'job.ss_id');
		if(isset($filters['array_id']))
		{
			$query->where('job.job_id', 'in', $filters['array_id']);
			return $query;
		}

		if(isset($filters['order_by']) && $filters['order_by'] == 'rand')
		{
			$query->order_by(DB::expr('RAND()'));
		}
		elseif(isset($filters['order_by']))
		{
			$query->order_by('job.is_pickup', 'desc');
			$query->order_by('job.is_conscription', 'desc');
			$query->order_by('job.updated_at', 'desc');
			$query->order_by('job.job_id', 'desc');
		}
		else
		{
			$query->order_by('job.job_id', 'desc');
		}

		if(isset($filters['preview']))
		{
			$query->where('job.job_id','=',$filters['preview']);
			return $query;
		}

		$query->where('job.is_available', '=', 1);

		$query->and_where_open();
		$query->where('job.start_date', '<=', date('Y-m-d'));
		$query->or_where('job.start_date', 'is', null);
		$query->and_where_close();

		$query->and_where_open();
		$query->where('job.end_date', '>=', date('Y-m-d'));
		$query->or_where('job.end_date', 'is', null);
		$query->and_where_close();

		if(isset($filters['job_id']) and $filters['job_id'])
		{
			$query->where('job.job_id','=',$filters['job_id']);
		}

		if(isset($filters['bookmark']) && $filters['bookmark'])
		{
			$arr = json_decode(\Fuel\Core\Cookie::get('bookmark', '[0]'), true);
			$query->where('job.job_id', 'in', empty($arr) ? array(0) : $arr);
			return $query;
		}

		if(isset($filters['work_day_week']) && $filters['work_day_week'])
		{
			$query->and_where_open();
			switch($filters['work_day_week'])
			{
			    case 1:
					$query->where('job.work_day_week','=',1);
			    break;

			    case 2:
					$query->where('job.work_day_week','=',2);
					$query->or_where('job.work_day_week','=',3);
			    break;

			    case 3:
				    $query->where('job.work_day_week','=',4);
				    $query->or_where('job.work_day_week','=',5);
			    break;

			    case 4:
					$query->where('job.work_day_week','>',5);
			    break;

			    default:
				//no search
			    break;
			}

			$query->and_where_close();
		}

		if(isset($filters['addr1']) && $filters['addr1'])
		{
			$query->where('m_ss.addr1', '=', $filters['addr1']);
		}

        if(isset($filters['addr23']) && $filters['addr23'])
        {
            $addr23 = array_filter(preg_split('/\s|\s+|　/', trim($filters['addr23'])));
            if (count($addr23) > 0) {
                $query->and_where_open();
                foreach($addr23 as $k => $v)
                {
                    $query->where(DB::expr("CONCAT(m_ss.addr2, IFNULL(m_ss.addr3, ''))"), 'like', '%'.$v.'%');
                }
                $query->and_where_close();
            }
        }

		if(isset($filters['employment_type']) && $filters['employment_type'][0] != '')
		{
			$count = 0;
			$query->and_where_open();
			foreach($filters['employment_type'] as $k => $v)
			{
				if($v == 4)
				{
					$query->and_where_open();
					$query->where('job.employment_type', '=', 7);
					$query->or_where('job.employment_type', '=', 8);
					$query->and_where_close();
				}
				else
				{
					if($count == 0)
						$query->where('job.employment_type', '=', $v);
					else
						$query->or_where('job.employment_type', '=', $v);
				}

				$count++;
			}

			$query->and_where_close();
		}

		if(isset($filters['work_period']) && $filters['work_period'])
		{
			$query->where('job.work_period', '=', $filters['work_period']);
		}

		if(isset($filters['work_time_view']) && $filters['work_time_view'][0] != '')
		{
			$count = 0;
			$query->and_where_open();
			foreach($filters['work_time_view'] as $k => $v)
			{
				if($count == 0)
				{
					$count++;
					$query->where('job.work_time_view', 'like', '%,'.$v.',%');
				}
				else
				{
					$query->or_where('job.work_time_view', 'like', '%,'.$v.',%');
				}
			}

			$query->and_where_close();
		}

		if(isset($filters['trouble']) && $filters['trouble'][0] != '')
		{
			$count = 0;
			$query->and_where_open();
			foreach($filters['trouble'] as $k => $v)
			{
				if($count == 0)
				{
					$count++;
					$query->where('job.trouble', 'like', '%,'.$v.',%');
				}
				else
					$query->or_where('job.trouble', 'like', '%,'.$v.',%');
			}

			$query->and_where_close();
		}

		if(isset($filters['keyword']) && $filters['keyword'])
		{
			$arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword'])));

            if (count($arr_keyword) > 0) {
                $query->and_where_open();
                $query->or_where_open();
                foreach($arr_keyword as $k => $v)
                {
                    $query->where(DB::expr('CONCAT(job.post_company_name,job.catch_copy,job.lead)'), 'like', '%'.$v.'%');
                }

                $query->or_where_close();
                $query->and_where_close();
            }
		}

		if(isset($filters['new_updated']))
		{
			$query->where('job.updated_at','>',$filters['new_updated']);
		}

		if(isset($filters['is_conscription']) and $filters['is_conscription'])
		{
			$query->where('job.is_conscription','=',$filters['is_conscription']);
		}

		if(isset($filters['is_pickup']) and $filters['is_pickup'])
		{
			$query->where('job.is_pickup','=',$filters['is_pickup']);
		}

		//add filter pickup condition (ticket 1012)
		if(isset($filters['filter_pickup']))
		{
			$query->and_where_open();
			$query->where('job.pickup_start_date', 'is', null);
			$query->or_where('job.pickup_start_date', '<=', date('Y-m-d'));
			$query->and_where_close();
			$query->and_where_open();
			$query->where('job.pickup_end_date', 'is', null);
			$query->or_where('job.pickup_end_date', '>=', date('Y-m-d'));
			$query->and_where_close();
		}

		//add filter pickup conscription (ticket 1012)
		if(isset($filters['filter_conscription']))
		{
			$query->and_where_open();
			$query->where('job.conscription_start_date', 'is', null);
			$query->or_where('job.conscription_start_date', '<=', date('Y-m-d'));
			$query->and_where_close();
			$query->and_where_open();
			$query->where('job.conscription_end_date', 'is', null);
			$query->or_where('job.conscription_end_date', '>=', date('Y-m-d'));
			$query->and_where_close();
		}

		if(isset($filters['salary_min']) && $filters['salary_min'])
		{
			if($filters['salary_min'] == 799)
			{
				$query->where('job.salary_min','<=',$filters['salary_min']);
			}
			else
			{
				$query->where('job.salary_min','>=',$filters['salary_min']);
			}
		}

		if(isset($filters['limit']) && $filters['limit'])
		{
			$query->limit($filters['limit']);
		}

		if(isset($filters['offset']) && $filters['offset'])
		{
			$query->offset($filters['offset']);
		}

		return $query;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get data for list ss
	 * @param array $filters
	 * @return mixed
	 */
	public function get_data($filters = array(), $seed = '', $select = '')
	{
		$query = $this->_get_where($filters, $seed, $select);
		return $query->as_object()->execute();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count data for list ss
	 * @param array $filters
	 * @return int
	 */
	public function count_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return count($query->execute());
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get random m_image_id
	 * @param $image_list
	 * @return string
	 */
	public static function get_random_img($image_list)
	{
		$arr_image_list = json_decode($image_list, true);
        $arr_image_list = !is_array($arr_image_list) ? [] : $arr_image_list;
		$arr_image = array_keys($arr_image_list);

		if(empty($arr_image))
			return array(
				'id'  => '',
				'alt' => '',
			);
		$arr_rand = array_rand($arr_image);
		return array(
			'id'  => $arr_image[$arr_rand],
			'alt' => $arr_image_list[$arr_image[$arr_rand]],
		);
	}
	public function get_job_detail($id)
	{
		$query = \Fuel\Core\DB::select('*')->from('job')->where('job_id', $id);
		$data = $query->execute()->as_array();
		return $data;
	}

    public static function filterPosition($jobId, $radius = 10, $limit = 10)
    {
        $sql = "
            SELECT ss.lat, ss.lon, job.ss_id FROM job
            INNER JOIN m_ss AS ss ON (job.ss_id = ss.ss_id)
            WHERE job_id = :job_id
        ";
        $rows = \Fuel\Core\DB::query($sql)->parameters(['job_id' => $jobId])->execute()->as_array();
        if (!$rows || !$rows[0]['lat'] || !$rows[0]['lon']) {
            return [];
        }

        $lat = deg2rad($rows[0]['lat']);
        $lon = deg2rad($rows[0]['lon']);
        $ssId = $rows[0]['ss_id'];

        $x = Constants::EARTH_RADIUS * cos($lat) * cos($lon);
        $y = Constants::EARTH_RADIUS * sin($lat);
        $z = Constants::EARTH_RADIUS * cos($lat) * sin($lon);

        $square = Constants::EARTH_RADIUS * Constants::EARTH_RADIUS;

        $sql = "
            SELECT
                job.job_id,
                job.post_company_name,
                job.job_category,
                job.store_name,
                job.salary_des,
                job.image_list,
                IFNULL(acos((ss.posx * :x + ss.posy * :y + ss.posz * :z) / :square) * :earth, 0) AS distance
            FROM job
            INNER JOIN m_ss AS ss ON (job.ss_id = ss.ss_id)
            WHERE
                job.job_id <> :job_id AND
                job.ss_id <> :ss_id AND
                job.is_available = 1 AND (
                    job.start_date <= NOW() OR
                    job.start_date IS NULL
                ) AND (
                    job.end_date >= NOW() OR
                    job.end_date IS NULL
                ) AND
                ss.posx IS NOT NULL AND
                (
                    (acos((ss.posx * :x + ss.posy * :y + ss.posz * :z) / :square) * :earth <= :radius) OR
                    (acos((ss.posx * :x + ss.posy * :y + ss.posz * :z) / :square) * :earth <= :radius) IS NULL
                )
            ORDER BY distance LIMIT $limit
        ";

        return \Fuel\Core\DB::query($sql)->parameters([
            'job_id' => $jobId,
            'ss_id' => $ssId,
            'earth' => Constants::EARTH_RADIUS,
            'square' => $square,
            'radius' => $radius,
            'x' => $x,
            'y' => $y,
            'z' => $z,
        ])->execute()->as_array();
    }

    /**
     * get data form job and sale job
     * @param array $filters
     * @param string $type
     * @return int
     */
    public function get_all_job($filters = [], $select = '*', $type = null)
    {
        $query = \Fuel\Core\DB::select($select)->from('view_job');

        if(isset($filters['array_id']))
        {
            $query->where('job_id', 'in', $filters['array_id']);
            return $query->as_object()->execute();
        }
        $query->where('is_available', '=', 1);

        $query->and_where_open();
        $query->where('start_date', '<=', date('Y-m-d'));
        $query->or_where('start_date', 'is', null);
        $query->and_where_close();

        $query->and_where_open();
        $query->where('end_date', '>=', date('Y-m-d'));
        $query->or_where('end_date', 'is', null);
        $query->and_where_close();

        if (isset($filters['addr1']) && $filters['addr1']) {
            $query->where('addr1', '=', $filters['addr1']);
        }

        if (isset($filters['bookmark']) && $filters['bookmark']) {
            $arr = json_decode(\Fuel\Core\Cookie::get('bookmark', '[0]'), true);
            $query->where('job_id', 'in', empty($arr) ? array('0') : $arr);
            if ($type == 'count') {
                return count($query->execute());
            }
            return $query->as_object()->execute();
        }

        if (isset($filters['job_id']) and $filters['job_id']) {
            $query->where('job_id','=',$filters['job_id']);
        }

        if (isset($filters['addr23']) && $filters['addr23']) {
            $addr23 = array_filter(preg_split('/\s|\s+|　/', trim($filters['addr23'])));
            if (count($addr23) > 0) {
                $query->and_where_open();
                foreach ($addr23 as $k => $v) {
                    $query->where('address23', 'like', '%'.$v.'%');
                }
                $query->and_where_close();
            }
        }

        if (isset($filters['work_period']) && $filters['work_period']) {
            $query->where('work_period', '=', $filters['work_period']);
        }

        if (isset($filters['work_day_week']) && $filters['work_day_week']) {
            $query->and_where_open();
            switch ($filters['work_day_week']) {
                case 1:
                    $query->where('work_day_week', '=', 1);
                    break;
                case 2:
                    $query->where('work_day_week', '=', 2);
                    $query->or_where('work_day_week', '=', 3);
                    break;
                case 3:
                    $query->where('work_day_week', '=', 4);
                    $query->or_where('work_day_week', '=', 5);
                    break;
                case 4:
                    $query->where('work_day_week', '>', 5);
                    break;
                default:
                    //no search
                    break;
            }
            $query->and_where_close();
        }

        if (isset($filters['salary_min']) && $filters['salary_min']) {
            if ($filters['salary_min'] == 799) {
                $query->where('salary_min','<=',$filters['salary_min']);
            } else {
                $query->where('salary_min','>=',$filters['salary_min']);
            }
        }

        if (isset($filters['employment_type']) && $filters['employment_type'][0] != '') {
            $count = 0;
            $query->and_where_open();
            foreach ($filters['employment_type'] as $k => $v) {
                if ($v == 4) {
                    $query->and_where_open();
                    $query->where('employment_type', '=', 7);
                    $query->or_where('employment_type', '=', 8);
                    $query->or_where('employment_type', 'like', '%,2,%');
                    $query->and_where_close();
                } else {
                    if ($count == 0) {
                        $query->where('employment_type', '=', $v);
                    } else {
                        $query->or_where('employment_type', '=', $v);
                    }
                    if ($v == 2) {
                        $query->or_where('employment_type', 'like', '%,1,%');
                    }
                }
                $count++;
            }

            $query->and_where_close();
        }

        if (isset($filters['work_time_view']) && $filters['work_time_view'][0] != '') {
            $count = 0;
            $query->and_where_open();
            foreach ($filters['work_time_view'] as $k => $v) {
                if ($count == 0) {
                    $count++;
                    $query->where('work_time_view', 'like', '%,'.$v.',%');
                } else {
                    $query->or_where('work_time_view', 'like', '%,'.$v.',%');
                }
            }
            $query->and_where_close();
        }

        if (isset($filters['trouble']) && $filters['trouble'][0] != '') {
            $count = 0;
            $query->and_where_open();
            foreach ($filters['trouble'] as $k => $v) {
                if ($count == 0) {
                    $count++;
                    $query->where('trouble', 'like', '%,'.$v.',%');
                } else {
                    $query->or_where('trouble', 'like', '%,'.$v.',%');
                }
            }
            $query->and_where_close();
        }

        if (isset($filters['keyword']) && $filters['keyword']) {
            $arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword'])));
            if (count($arr_keyword) > 0) {
                $query->and_where_open();
                $query->or_where_open();
                foreach ($arr_keyword as $k => $v) {
                    $query->where('keyword', 'like', '%'.$v.'%');
                }
                $query->or_where_close();
                $query->and_where_close();
            }
        }

        if(isset($filters['new_updated']))
        {
            $query->where('updated_at','>',$filters['new_updated']);
        }

        if (isset($filters['limit']) && $filters['limit']) {
            $query->limit($filters['limit']);
        }

        if (isset($filters['offset']) && $filters['offset']) {
            $query->offset($filters['offset']);
        }

        $query->order_by('updated_at', 'desc');
        $query->order_by('job_id', 'desc');

        if ($type == 'count') {
            return count($query->execute());
        }
        return $query->as_object()->execute();
    }
}
