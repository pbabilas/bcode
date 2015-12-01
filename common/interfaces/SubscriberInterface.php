<?php
/**
 * @author: Paweł Babilas
 * @date: 19.04.2015
 */

namespace app\common\interfaces;


interface SubscriberInterface
{
	/**
	 * @return array
	 */
	public function getSubscribedEvents();
}