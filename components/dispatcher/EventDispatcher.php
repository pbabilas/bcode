<?php
/**
 * @author: Paweł Babilas
 * @date: 19.04.2015
 */

namespace app\components\dispatcher;


use app\common\interfaces\SubscriberInterface;
use Yii;
use yii\base\Component;
use yii\base\Event;

class EventDispatcher extends Component
{
	public function init()
	{
		$subscribers = $this->getSubscribers();


		foreach ($subscribers as $subscriberClassName)
		{
			/** @var SubscriberInterface $subscriber */
			$subscriber = new $subscriberClassName();
			$events = $subscriber->getSubscribedEvents();

			foreach ($events as $event => $callback)
			{
				if (is_array($callback))
				{
					list($callback, $layer) = $callback;
				}

				if (isset($layer))
				{
					if (is_array($layer))
					{
						//in future We can declare Event as key of array if nessesary
						Event::on($layer[0], $event, [$subscriber, $callback]);
					}
					else
					{
						\Yii::$app->$layer->on($event, [$subscriber, $callback]);
					}
				}
				else
				{
					\Yii::$app->on($event, [$subscriber, $callback]);
				}

				unset($layer);
			}
		}
	}

	/**
	 * gets subscribers events to run
	 *
	 * @return array
	 */
	private function getSubscribers()
	{
		$classMapPath = Yii::$app->getBasePath() . '/runtime/class_map.php';
		$subscribers = require_once( $classMapPath );

		return $subscribers;
	}
}