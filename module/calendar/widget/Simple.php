<?php
/**
 * @user: Pawel Babilas
 * @date: 19.01.2016
 */

namespace app\module\calendar\widget;


use app\module\dashboard\interfaces\WidgetInterface;

class Simple implements WidgetInterface
{

	/**
	 * @return integer
	 */
	public function getWidth()
	{
		return 4;
	}

	/**
	 * @return integer
	 */
	public function getOffset()
	{
		return false;
	}

	/**
	 * @return string
	 */
	public function getContentsTemplate()
	{
		return '@app/module/calendar/widget/view/content.tpl';
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return 'Kalendarz';
	}

	/**
	 * @return string
	 */
	public function getIcon()
	{
		return 'calendar';
	}
}