<?php
/**
 * @user: Pawel Babilas
 * @date: 06.12.2015
 */

namespace app\module\nice_url\generators;

use app\module\nice_url\factory\NiceUrlFactory;
use app\module\nice_url\interfaces\NiceUrlInterface;
use app\module\nice_url\models\NiceUrl;
use app\module\nice_url\remover\NiceUrlRemover;
use app\module\nice_url\slug\DatabaseCounter;
use yii\log\Logger;

class NiceUrlGenerator
{

	/**
	 * @param NiceUrlInterface $object
	 *
	 * @throws \yii\db\Exception
	 */
	public function runForOne(NiceUrlInterface $object)
	{
		$transaction = \Yii::$app->getDb()->beginTransaction();
		try
		{
			$factory = new NiceUrlFactory(new DatabaseCounter());
			$niceUrlCollection = $factory->generate($object);

			/** @var NiceUrl $niceUrl */
			foreach ($niceUrlCollection as $niceUrl)
			{
				NiceUrlRemover::dropOldNiceUrl($niceUrl);
				$niceUrl->save();
			}

			$transaction->commit();
		}
		catch (\Exception $e)
		{
			$transaction->rollBack();
			\Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'niceUrl');
		}
	}
}