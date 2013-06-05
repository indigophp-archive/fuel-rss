<?php
/**
 * Fuel RSS package
 *
 * @package    Fuel
 * @subpackage RSS
 * @version    1.0
 * @author     Márk Ság-Kazár <sagikazarmark@gmail.com>
 * @link       https://github.com/sagikazarmark/fuel-rss
 */

namespace RSS;

class RSS_Driver_Lastrss extends RSS_Driver
{

	public function __construct(array $config)
	{
		parent::__construct($config);

		$class = $this->get_config('class', 'stdclass');
		$this->instance = new $class;

		if(!method_exists($this->instance, 'Get'))
		{
			throw new \BadMethodCallException('Invalid method: Get on '.$this->get_config('class', 'stdclass'));
		}
		return $this;
	}

	protected function _get($url)
	{
		$this->instance->items_limit = $this->get_config('limit', 0);
		//$this->instance->date_format = $this->get_config('date_format', 0);
		$this->instance->cache_dir = \Config::get('cache_dir');
		$this->instance->cache_time = 3600;

		return $this->instance->Get($url);
	}

	protected function _order($rss = null)
	{
		if ( ! is_null($rss) and $order = $this->get_config('order', false))
		{
			!is_array($order) && $order = array($order);

			usort($rss['items'], function($a, $b) use ($order) {
				$a = strtotime(\Arr::get($a, \Arr::get($order, 0, 'pubDate')));
				$b = strtotime(\Arr::get($b, \Arr::get($order, 0, 'pubDate')));

				if (\Str::lower(\Arr::get($order, 1, 'asc')) == 'desc')
				{
					return $b - $a;
				}
				else
				{
					return $a - $b;
				}
			});
		}
		return $rss;
	}
}
