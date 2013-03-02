<?php

namespace RSS;

class RSS
{

	/**
	 * Instance for singleton usage.
	 */
	public static $_instance = false;


	protected static $_defaults = array(
		'driver' => 'lastrss',
		'limit' => 5,
		'date_format' => 'Y-m-d H:i',
		'path' => 'lastRSS.php',
		'class' => 'lastRSS'
	);


	/**
	 * RSS driver forge.
	 *
	 * @param	string|array	$setup		setup key for array defined in rss.setups config or config array
	 * @param	array			$config		extra config array
	 * @return  RSS_Driver    one of the RSS drivers
	 */
	public static function forge($setup = null, array $config = array())
	{
		empty($setup) and $setup = \Config::get('rss.default_setup', 'default');
		is_string($setup) and $setup = \Config::get('rss.setups.'.$setup, array());

		$setup = \Arr::merge(static::$_defaults, $setup);
		$config = \Arr::merge($setup, $config);

		$driver = '\\RSS_Driver_'.ucfirst(strtolower(\Arr::get($config, 'driver', 'lastrss')));

		if( ! class_exists($driver, true))
		{
			throw new \FuelException('Could not find RSS driver: ' . \Arr::get($config, 'driver', 'null') . ' ('.$driver . ')');
		}

		$driver = new $driver($config);

		return $driver;
	}

	/**
	 * Init, config loading.
	 */
	public static function _init()
	{
		\Config::load('rss', true);
	}

	/**
	 * Call rerouting for static usage.
	 *
	 * @param	string	$method		method name called
	 * @param	array	$args		supplied arguments
	 */
	public static function __callStatic($method, $args = array())
	{
		if(static::$_instance === false)
		{
			$instance = static::forge();
			static::$_instance = &$instance;
		}

		if(is_callable(array(static::$_instance, $method)))
		{
			return call_user_func_array(array(static::$_instance, $method), $args);
		}

		throw new \BadMethodCallException('Invalid method: '.get_called_class().'::'.$method);
	}

}
