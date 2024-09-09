<?php

declare(strict_types=1);

namespace Pointenv\Parser;

use Pointenv\Constant\RegularExpression as Regex;

final class Parser implements ParserInterface
{
  public function __construct()
  {
    //
  }

  /**
   * 
   * @return array simple keys and values
   */
  private function save(string $content)
  {
    @\preg_match_all(Regex::RENVLINE, $content, $matches);
    $keys    = $matches[1];
    $matches = @\array_slice($matches, 2);
    $values  = [];
    
    foreach($matches[3] as $i=>$match)
    {
      $values2  = $matches[2][$i];
      $values1  = $matches[1][$i];
      $values0  = $matches[0][$i];
      $final    = !$match ? $values2 : $match;
      $final    = !$final ? $values1 : $final;
      $values[$keys[$i]] = !$final ? $values0 : $final;
    }

    return $values;
  }

  /**
   * 
   * 
   * @return array $entries
   */
  public function parse(string $content)
  {
    $entries       = $this->save($content);
    $final_entries = [];

    foreach($entries as $key=>$value)
    {
      $final_entries[$key] = @\preg_replace_callback(Regex::RNESTVAR, function($matches) use ($final_entries, $entries) {
        $matched = $matches[1];
        return $final_entries[$matched] ?? $entries[$matched] ?? $matches[0];
      }, $value);
    }
    return $final_entries;
  }
}
?>