<?php

declare(strict_types=1);

namespace Pointenv\Loader;

final class Loader implements LoaderInterface
{
  public function __construct()
  {

  }

  public function load(array $entries)
  {
    foreach($entries as $key=>$value)
    {
      $_SERVER[$key] = $_ENV[$key] = $value;
      putenv("{$key}={$value}");
    }
  }
}
?>