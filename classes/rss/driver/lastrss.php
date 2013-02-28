<?php

namespace RSS;

class RSS_Driver_Lastrss extends \RSS_Driver
{

	protected function init()
	{
		$class = $this->get_config('class', 'stdclass');
		$this->instance = new $class;

		if(!method_exists($this->instance, 'Get'))
		{
			throw new \BadMethodCallException('Invalid method: Get on '.$this->get_config('class', 'stdclass'));
		}
		return $this;
	}

	public function get($url)
	{
		$this->instance->items_limit = $this->get_config('limit', 0);
		//$this->instance->date_format = $this->get_config('date_format', 0);
		$this->instance->cache_dir = \Config::get('cache_dir');
		$this->instance->cache_time = 3600;
		return $this->instance->Get($url);
	}
}
