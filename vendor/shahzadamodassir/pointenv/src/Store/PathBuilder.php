<?php

declare(strict_types=1);

namespace Pointenv\Store;

use Path\Path;

final class PathBuilder
{

  /**
   * 
   */
  private const DEFAULT_ENV = '.env';
  private $fileEncoding;
  private $name;
  private $path;

  /**
   * 
   * @param string|null $path
   * @param string|null $name
   * @param string|null $fileEncoding
   * 
   * @return void
   */
  public function __construct(string $path=null, string $name=null, ?string $fileEncoding=null)
  {
    $this->fileEncoding = $fileEncoding;
    $this->path         = $path;
    $this->name         = $name;
  }

  /**
   * 
   * @return \Pointenv\Store\PathBuilder
   */
  public function fileEncoding(?string $fileEncoding=null)
  {
    return new self($this->path, $this->name, $fileEncoding);
  }

  /**
   * 
   * 
   * @return \Pointenv\Store\PathBuilder
   */
  public static function setWithoutName()
  {
    return new self();
  }

  /**
   * 
   * 
   * @return \Pointenv\Store\PathBuilder
   */
  public static function setWithName()
  {
    return new self(null, self::DEFAULT_ENV);
  }

  /**
   * 
   * 
   * @param string $name
   * @return \Pointenv\Store\PathBuilder
   */
  public function addName(string $name)
  {
    return new self($this->path, $name, $this->fileEncoding);
  }

  /**
   * 
   * 
   * @param string $path
   * @return \Pointenv\Store\PathBuilder
   */
  public function addPath(string $path)
  {
    return new self($path, $this->name, $this->fileEncoding);
  }

  /**
   * 
   * 
   * @return \Pointenv\Store\StoreInterface
   */
  public function make()
  {
    return new FileReader(Path::resolve((string) $this->path, (string) $this->name), $this->fileEncoding);
  }
}
?>