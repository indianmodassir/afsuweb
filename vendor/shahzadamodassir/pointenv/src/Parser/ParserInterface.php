<?php

declare(strict_types=1);

namespace Pointenv\Parser;

interface ParserInterface
{
  public function parse(string $content);
}
?>