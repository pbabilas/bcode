<?php
/**
 * @author: Paweł Babilas
 * @date: 07.04.2015
 */

namespace app\common\interfaces;

interface MultiLangModelInterface
{
	/**
	 * If multilang, return array like
	 *
	 *	[
	 * 		field,
	 * 		field,
	 * 		...,
	 * 		field
	 *	]
	 *
	 * @return array
	 */
	public function getMultiLangFields();

}