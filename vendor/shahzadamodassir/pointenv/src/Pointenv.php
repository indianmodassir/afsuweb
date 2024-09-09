<?php

declare(strict_types=1);

/**
 * 
 */
namespace Pointenv;

use Pointenv\Parser\ParserInterface;
use Pointenv\Parser\Parser;
use Pointenv\Loader\LoaderInterface;
use Pointenv\Loader\Loader;
use Pointenv\Validator\Validator;
use Pointenv\Store\StoreInterface;
use Pointenv\Store\PathBuilder;

class Pointenv
{

  /**
   * @var \Pointenv\Loader\LoaderInterface   $loader
   * @var \Pointenv\Parser\ParserInterface   $parser
   * @var \Pointenv\Store\StoreInterface     $store
   */
  private $loader;
  private $parser;
  private $store;

  /**
   * 
   * 
   * @var \Pointenv\Pointenv\VERSION         VERSION
   */
  public const VERSION = '1.0.0';

  /**
   * 
   * @param \Pointenv\Store\StoreInterface   $store
   * @param \Pointenv\Loader\LoaderInterface $loader
   * @param \Pointenv\Parser\ParserInterface $parser
   * 
   * @return void
   */
  public function __construct(StoreInterface $store, LoaderInterface $loader, ParserInterface $parser)
  {
    $this->loader = $loader;
    $this->parser = $parser;
    $this->store  = $store;
  }

  /**
   * 
   * 
   * @param string|null $path
   * @param string|null $name
   * @param string|null $file_encoding
   * @param
   * 
   * @return \Pointenv\Pointenv
   */
  public static function config(?string $path=null, ?string $name=null, ?string $file_encoding=null)
  {
    return self::init((!$path ? $_SERVER['DOCUMENT_ROOT'] : $path), $name, $file_encoding);
  }

  /**
   * 
   */
  public static function quickLoad()
  {
    return self::config()->safeLoad();
  }

  /**
   * 
   * 
   * @return \Pointenv\Pointenv
   */
  public function safeLoad()
  {
    try {$this->load();} catch(\Exception $e) {return [];}
  }

  /**
   * 
   * 
   * @return \Pointenv\Pointenv
   */
  public function load()
  {
    $this->loader->load($this->parser->parse($this->store->read()));
  }

  /**
   * 
   * 
   * @param string      $path
   * @param string|null $name
   * @param string|null $file_encoding
   * @param
   * 
   * @return \Pointenv\Pointenv
   */
  public static function init($path, ?string $name=null, ?string $file_encoding=null /*#param=end*/)
  {
    $PathBuilder = $name===null ? PathBuilder::setWithName() : PathBuilder::setWithoutName();
    $name && ($PathBuilder = $PathBuilder->addName($name));
    $path && ($PathBuilder = $PathBuilder->addPath($path));
    return new self($PathBuilder->fileEncoding($file_encoding)->make(), new Loader(), new Parser());
  }
}
?>
