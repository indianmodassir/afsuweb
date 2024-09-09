<?php

declare(strict_types=1);

namespace Pointenv\Constant;

final class RegularExpression
{
  public const RNESTVAR = '/\$\{(\w+)\}/m';
  public const RENVLINE = '/^\s*(\w+)\s*=\s*(?:"((?:.|[\r\n])*?)"|\'((?:.|[\r\n])*?)\'|`((?:.|[\r\n])*?)`|([^#\r\n]*))(?!^#)/m';
}
?>