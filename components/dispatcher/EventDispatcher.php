<?php
/**
 * @author: Paweł Babilas
 * @date: 19.04.2015
 */

namespace app\components\dispatcher;


use app\common\interfaces\SubscriberInterface;
use yii\base\Component;

class EventDispatcher extends Component
{

	CONST SUBSCRIBERS_PATH = '/module/*/subscriber/*Subscriber.php';

	public function init()
	{
		$subscribers = $this->getSubscribers();

		/** @var SubscriberInterface $subscriber */
		foreach ($subscribers as $subscriber)
		{
			$events = $subscriber->getSubscribedEvents();

			foreach ($events as $event => $callback)
			{
				if (is_array($callback))
				{
					list( $callback, $layer ) = $callback;
				}

				if (isset($layer))
				{
					\Yii::$app->$layer->on($event, [$subscriber, $callback]);
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
	 * @return array
	 */
	private function getSubscribers()
	{
		$subscribers = [];

		foreach (glob($this->getSubscribersPath()) as $filePath)
		{
			$className = $this->buildSubscriberCLassNameFromString($filePath);

			if (class_exists($className) == false)
			{
				continue;
			}

			$subscriber = new $className();

			if ($subscriber instanceof SubscriberInterface)
			{
				$subscribers[] = $subscriber;
			}
		}

		return $subscribers;
	}

	/**
	 * build namespace class name for subscriber from class name
	 * @param $string
	 *
	 * @return string
	 */
	private function buildSubscriberCLassNameFromString($string)
	{
		$parts = explode('/', $string);
		$id = array_search('module', $parts);
		$tmp = array_slice($parts, $id);
		$namespace = join('\\', $tmp);
		return basename('app\\'.$namespace, '.php');
	}

	/**
	 * gets subscribers path for glob
	 * @return string
	 */
	private function getSubscribersPAth()
	{
		return \Yii::$app->getBasePath() . EventDispatcher::SUBSCRIBERS_PATH;
	}
}