<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 29.11.15
 * Time: 19:50
 */

namespace app\common;

class Message
{
	const ALERT = "alert";
	const WARNING = "warning";
	const INFO = "info";

	private $content;
	private $type;

	public function __construct($content, $type = null)
	{
		if ( ! in_array($type, array( self::ALERT, self::WARNING, self::INFO )))
		{
			$type = self::INFO;
		}

		$this->type = $type;
		$this->content = $content;
	}

	public function __toString()
	{
		return $this->content;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getContent()
	{
		return $this->content;
	}
}
