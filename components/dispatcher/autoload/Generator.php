<?php
namespace app\components\dispatcher\autoload;


use app\components\dispatcher\exception\WrongPathGivenException;
use app\components\dispatcher\interfaces\DependencyInterface;


/**
 * @user: Pawel Babilas
 * @date: 13.01.2016
 */

class Generator
{
	const NAMESPACE_PATTERN = "/<\?php\s*((\s*?\/\*([\s\S]*?)\*\/)|(\s*?\/\/([\s\S]*?)))*\s*?^\s*?namespace\s+(?<ns>[\\\a-z0-9_]+);/mi";

	private $pattern = "/^class\s*(\w*)\s*/m";

	/** @var DependencyInterface[] */
	private $dependencies;

	/** @var  array */
	private $classMap;

	/**
	 * @param null $pattern
	 */
	public function setPattern($pattern)
	{
		$this->pattern = $pattern;
	}

	/**
	 * @param DependencyInterface $dependency
	 */
	public function setDependency($dependency)
	{
		$this->dependencies[] = $dependency;
	}

	/**
	 * @param string $path
	 *
	 * @throws WrongPathGivenException
	 */
	public function run($path)
	{
		$files = $this->getFilesForPath($path);

		$i = 0;
		foreach ( $files as $file )
		{
			$code = file_get_contents( $file, true );
			$this->getClassName($code);
			$i++;
		}
	}

	/**
	 * @param string $path
	 *
	 * @return array
	 *
	 * @throws WrongPathGivenException
	 */
	private function getFilesForPath($path)
	{
		if (file_exists($path) == false OR is_dir($path) == false)
		{
			throw new WrongPathGivenException();
		}

		$files = [];

		$dir = opendir($path);
		while ( ($file = readdir($dir)) !== FALSE )
		{
			$fullPath = $path. '/' . $file;
			$isDir = is_dir($fullPath);

			if ( $isDir )
			{
				if ( $file != "." && $file != "..")
				{
					$filesInSubdir = $this->getFilesForPath($fullPath);
					$files = array_merge($files, $filesInSubdir);
				}
			}
			else
			{
				$ext = substr($fullPath, -4, 4);
				if ( $ext == ".php" )
				{
					$files[] = $fullPath;
				}
			}
		}

		closedir($dir);

		return $files;
	}

	/**
	 * @param $code
	 * @return array
	 */
	protected function getClassName($code)
	{
		preg_match_all($this->pattern, $code, $matches);
		preg_match_all(Generator::NAMESPACE_PATTERN, $code, $namespaceMatches);

		foreach ($matches[1] as $class)
		{
			$hasNamespaces = isset($namespaceMatches['ns'][0]);
			if($hasNamespaces)
			{
				$class =  $namespaceMatches['ns'][0].'\\'.$class;
			}

			if ($this->dependenciesAreMet($class) == false)
			{
				continue;
			}

			$this->classMap[] = $class;
		}
	}

	public function saveTo( $file )
	{
		return file_put_contents( $file, "<?php return " . var_export( $this->classMap, true ) . "; ?>\n");
	}

	/**
	 * @param string $class
	 *
	 * @return bool
	 */
	private function dependenciesAreMet($class)
	{
		foreach ($this->dependencies as $dependency)
		{
			$dependency->setClassName($class);
			if ($dependency->isMet() == false)
			{
				return false;
			}
		}

		return true;
	}
}