<?php
/**
 * @user: Pawel
 * @date 06.12.2015
 */

namespace app\module\nice_url\factory;

use app\common\model\AbstractMultiLangModel;
use app\module\language\models\Language;
use app\module\nice_url\generators\SlugGenerator;
use app\module\nice_url\interfaces\NiceUrlInterface;
use app\module\nice_url\interfaces\SlugCounterInterface;
use app\module\nice_url\models\Collection;
use app\module\nice_url\models\NiceUrl;

class NiceUrlFactory
{

	/**
	 * @var \app\module\language\models\Language[]|array
	 */
	private $languages;

	/** @var SlugCounterInterface */
	private $slugCounter;

	public function __construct(SlugCounterInterface $slugCounter)
	{
		$this->languages = Language::find()->all();
		$this->slugCounter = $slugCounter;
	}

	/**
	 * @param NiceUrlInterface $object
	 *
	 * @return NiceUrl
	 */
	public function generate(NiceUrlInterface $object)
	{
		$collection = new Collection();
		/** @var Language $lang */
		foreach($this->languages as $lang)
		{
			$field = $object->getFieldForNiceUrl();
			if ($object instanceof AbstractMultiLangModel)
			{
				if( in_array($field, $object->getMultiLangFields()) )
				{
					$field = $field.'__'.$lang->symbol;
				}
			}

			if ($object->isAttributeChanged($field) == false || $object->$field == '')
			{
				continue;
			}

			$niceUrl = new NiceURL();
			$niceUrl->object_class = get_class($object);
			$niceUrl->object_id = $object->getId();
			$niceUrl->language_id = $lang->id;

			$slugGenerator = new SlugGenerator();
			$niceUrl->slug = $slugGenerator->generateFrom($object->$field);
			$sameSlugCount = $this->slugCounter->run($niceUrl->slug);

			$sameSlugCount = $sameSlugCount != -1 ? '_'.($sameSlugCount+1) : '';

			$url = $niceUrl->slug.$sameSlugCount;
			$niceUrl->url = $url;

			$collection->append($niceUrl);
		}

		return $collection;
	}
}