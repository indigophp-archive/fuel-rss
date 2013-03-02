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

abstract class RSS_Driver
{
	/**
	 * Driver config
	 */
	protected $config = array();

	/**
	 * Library instance
	 * @var object
	 */
	protected $instance = null;

	/**
	 * Driver constructor
	 *
	 * @param	array	$config		driver config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
		include_once(realpath(PKGPATH.'/rss/vendor/'.$config['path']));
		$this->init();
	}

	/**
	 * Set the max number of items
	 * @param  int|null $limit Max number of items
	 * @return bool
	 */
	public function limit($limit = 0)
	{
		 return is_int($limit) and $limit > -1 and $this->set_config('limit', $limit);
	}

	/**
	 * Set date format
	 * @param  string|null $date_format Date format, e.g. 'Y-m-d H:i'
	 * @return bool
	 */
	public function date_format($date_format = 'Y-m-d H:i')
	{
		return !empty($date_format) and is_string($date_format) and $this->set_config('date_format', $date_format);
	}


	abstract protected function init();

	/**
	 * Abstract class for RSS feed fownload
	 * @param  string $url URL of RSS feed
	 * @return mixed
	 */
	abstract public function get($url);

	/**
	 * Get a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @return	mixed					the config setting value
	 */
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	 * Set a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @param	mixed		$value		the new config value
	 * @return	object					$this
	 */
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

}
