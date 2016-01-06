<?php
/**
 * @user: Pawel Babilas
 * @date: 14.12.2015
 */

namespace app\module\nice_url\subscriber;


use app\common\interfaces\SubscriberInterface;
use app\module\nice_url\generators\NiceUrlGenerator;
use app\module\nice_url\models\NiceUrl;
use app\module\page\models\Page;
use yii\base\Event;
use yii\db\AfterSaveEvent;

class PageSubscriber implements SubscriberInterface
{

	/**
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return [
			Page::EVENT_AFTER_UPDATE => ['refreshNiceUrlIfNeeded', [Page::className()]],
			Page::EVENT_AFTER_INSERT => ['refreshNiceUrlIfNeeded', [Page::className()]],
			Page::EVENT_AFTER_DELETE => ['deleteNiceUrl', [Page::className()]],
		];
	}

	/**
	 * @param AfterSaveEvent $event
	 */
	public function refreshNiceUrlIfNeeded(AfterSaveEvent $event)
	{
		/** @var Page $page */
		$page = $event->sender;
		$page->oldAttributes = array_merge($page->oldAttributes, $event->changedAttributes);

		$niceUrlGenerator = new NiceUrlGenerator();
		$niceUrlGenerator->runForOne($page);
	}

	/**
	 * @param Event $event
	 */
	public function deleteNiceUrl(Event $event)
	{
		/** @var Page $page */
		$page = $event->sender;

		NiceUrl::deleteAll(['object_class' => Page::className(), 'object_id' => $page->id,]);
	}
}