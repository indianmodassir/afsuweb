<?php

declare(strict_types=1);

namespace Pointenv\Store;

final class FileReader implements StoreInterface
{
  private $fileEncoding;
  private $filePath;
  public function __construct(string $filePath, ?string $file_encoding=null)
  {
    $this->fileEncoding = $file_encoding ?? 'utf-8';
    $this->filePath = $filePath;
  }

  public function read()
  {
    return @\mb_convert_encoding(@\file_get_contents($this->filePath), $this->fileEncoding);
  }
}
?>