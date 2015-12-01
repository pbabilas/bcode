<?php
/**
 * @author: PAweł Babilas
 * @date: 18.03.2015
 */

namespace app\module\language\subscriber;;

use app\common\interfaces\SubscriberInterface;
use yii\base\ViewEvent;
use yii\web\Application;
use yii\base\Event;
use yii\base\View;

class LanguageSubscriber implements SubscriberInterface
{

	/**
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return [
			View::EVENT_AFTER_RENDER => [ 'tryToLoadTranslation', 'view' ],
			Application::EVENT_BEFORE_REQUEST => 'setLanguageSession'
		];
	}

	/**
	 * @param ViewEvent $e
	 */
	public function tryToLoadTranslation(ViewEvent $e)
	{
		$output = $e->output;
		$content = preg_replace_callback('/`([a-zA-Z0-9_-]+?)\.([.\pL0-9_-]+)(_values\((\/.*?\/)\))?`/u', array($this, 'translateStringCallback'), $output, -1, $count );
		$e->output = $content;
	}

	/**
	 * @param $matches
	 * @return string
	 */
	private function translateStringCallback($matches)
	{
		$category = $matches[1];
		$message = $matches[2];

		return \Yii::t($category, $message);
	}

	/**
	 * @param Event $event
	 */
	public function setLanguageSession(Event $event)
	{

		if (strpos(\Yii::$app->request->url, 'admin'))
		{
			return;
		}

		$sessionLang = \Yii::$app->session->get('lang');

		if ($sessionLang)
		{
			\Yii::$app->language = $sessionLang;
		}
		else
		{
			\Yii::$app->session->set('lang', \Yii::$app->language);
		}
	}


}