<?php

namespace Menu;

/**
 * Part of the Fuel framework.
 *
 * @version    0.5
 * @author     Daniel Polito - @dbpolito
 * @link       https://github.com/dbpolito/Fuel-Menu
 */

/**
 * Menu Class
 *
 * Lightweight class to create menu based on array
 *
 */
class Menu
{
	/**
	 * @var  Menu
	 */
	protected static $_instance;

	/**
	 * @var  array  contains references to all instantiations of Menu
	 */
	protected static $_instances = array();

	/**
	 * Create Fieldset object
	 *
	 * @param   string    Identifier for this fieldset
	 * @param   array     Configuration array
	 * @return  Fieldset
	 */
	public static function forge($name = 'default', $items = array())
	{
		if ($exists = static::instance($name))
		{
			\Error::notice('Menu with this name exists already, cannot be overwritten.');
			return $exists;
		}

		static::$_instances[$name] = new static($items);

		if ($name == 'default')
		{
			static::$_instance = static::$_instances[$name];
		}

		return static::$_instances[$name];
	}

	/**
	 * Return a specific instance, or the default instance (is created if necessary)
	 *
	 * @param   string  driver id
	 * @return  Fieldset
	 */
	public static function instance($instance = null)
	{
		if ($instance !== null)
		{
			if ( ! array_key_exists($instance, static::$_instances))
			{
				return false;
			}

			return static::$_instances[$instance];
		}

		if (static::$_instance === null)
		{
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}

	/**
	 * @var  array  Menu items
	 */
	protected $menu = array();

	public function __construct($items = array())
	{
		$this->menu = $items;
	}

	/**
	 * Return the html of the menu
	 *
	 * @return  HTML code
	 */
	public function get()
	{
		if ( empty($this->menu))
		{
			return '';
		}

		$output = $this->menu($this->menu, true);

		return $output;
	}

	/**
	 * Return the html code of the menu. 
	 * Heads Up: This function is recursive.
	 *
	 * @param   array  Menu array
	 * @param   bool  Is it the main level?
	 * @return  HTML code
	 */
	protected function menu($menu, $main = false)
	{
		$output = '';

		if ( ! isset($menu['attr']))
		{
			$menu['attr'] = array();
		}

		if ( !empty($menu['items']))
		{
			foreach ($menu['items'] as $item)
			{
				if ( ! isset($item['link']))
				{
					$item['link'] = '#';
				}

				$link = (is_array($item['link']) and isset($item['link']['url'])) ? $item['link']['url'] : $item['link'];
				$part = (is_array($item['link']) and isset($item['link']['part'])) ? $item['link']['part'] : false;
				$attr = isset($item['attr']) ? $item['attr'] : array();

				$pattern = $part ? "|".$link."(.*?)$|i" : "|".$link."$|i";

				if (preg_match($pattern, \Uri::string()) !== 0)
				{
					if (isset($attr['class']))
					{
						$attr['class'] .= ' active';
					}
					else
					{
						$attr['class'] = 'active';
					}
				}

				if (isset($item['name']) and $link != '#')
				{
					if (is_array($item['link']))
					{
						$content = \Html::anchor($link, $item['name'], $item['link']['attr']);
					}
					else
					{
						$content = \Html::anchor($link, $item['name']);
					}
				}
				else
				{
					$content = '';
				}

				if (isset($item['menu']) and is_array($item['menu']))
				{
					$content .= $this->menu($item['menu']);
				}

				$output .= html_tag('li', $attr, $content);
			}
		}
		else
		{
			return '';
		}

		return html_tag('ul', $menu['attr'], $output);
	}
}