<?php
/**
 * @user: Pawel Babilas
 * @date: 19.01.2016
 */

namespace app\module\dashboard\interfaces;


interface WidgetInterface
{

	/**
	 * @return integer
	 */
	public function getWidth();

	/**
	 * @return integer
	 */
	public function getOffset();

	/**
	 * @return string
	 */
	public function getContentsTemplate();

	/**
	 * @return string
	 */
	public function getTitle();

	/**
	 * @return string
	 */
	public function getIcon();

}