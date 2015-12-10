<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.05.14
 * Time: 09:30
 */

namespace app\module\nice_url\generators;

class SlugGenerator
{

	private $polishCharactersSearch = array('ę', 'ó', 'ą', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń',
		'Ę', 'Ó', 'Ą', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń' );
	private $polishCharactersReplace = array('e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n',
		'E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N' );

	public function generateFrom($string)
	{
		// dont allow "/"
		// polish is important ;)
		$string = str_replace( $this->polishCharactersSearch, $this->polishCharactersReplace, $string );

		// other languages
		$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		$string = mb_strtolower($string, 'utf-8');
		$string = preg_replace( "(\s+)", ' ', $string );
		$string = preg_replace( "([^a-z_0-9]+)", '_', $string );
		$string = trim($string, '_'); // strip the end _
		return $string;
	}
}