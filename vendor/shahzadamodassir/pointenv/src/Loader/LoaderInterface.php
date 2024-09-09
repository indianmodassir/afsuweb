<?php

declare(strict_types=1);

namespace Pointenv\Loader;

interface LoaderInterface
{
  public function load(array $entries);
}
?>