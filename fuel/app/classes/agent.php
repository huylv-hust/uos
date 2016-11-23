<?php
/**
 * Check Agent
 * @author NamDD <NamDD6566@seta-asia.com.vn>
 * @date 18/06/2015
 */

class Agent extends Fuel\Core\Agent
{
	public static function _init()
	{
		parent::_init();
		$ua_list = array(
			'iPhone',
			//'iPad',
			'iPod',
			//'Android',
			'dream',
			'CUPCAKE',
			'blackberry9500',
			'blackberry9530',
			'blackberry9520',
			'blackberry9550',
			'blackberry9800',
			'webOS',
			'incognito',
			'webmate',
		);
		$pattern = '/'.implode( '|', $ua_list ).'/i';
		$match = preg_match( $pattern, static::$user_agent );
		if( ! $match)
		{
		   if(preg_match('/Android/',static::$user_agent) && preg_match('/Mobile/',static::$user_agent) && ! preg_match('/SC-01/',static::$user_agent))
		   {
				$match = true;
		   }
		}

		static::$properties['x_issmartphone'] = ( $match ) ? true : false;
	}
	/**
	 * 
	 * @return true/false
	 */
	public static function is_smartphone()
	{
		return static::$properties['x_issmartphone'];
	}
}
