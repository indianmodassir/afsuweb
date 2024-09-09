<?php

declare(strict_types=1);

/**
 * Path Help with handling or manipulating file and directory path [CLASS]
 * PHP Version 8.1.4
 * 
 * @see https://github.com/javercel/path The Path Github project Repository
 * 
 * @author Shahzadi Afsara   <shahzadiafsara@gmail.com>
 * @author Shahzada Modassir <codingmodassir@gmail.com>
 * 
 * @version 1.1.0
 * 
 * @copyright All rights reserved!
 * @license MIT License
 * @date 30 August 2024 AT 01:50 AM
 * @see https://github.com/javercel/path/blob/main/LICENSE Github [LICENSE]
 */
namespace Path;

/**
 * Define multiple constant variable for used globally
 */
define('DELIMITER', ':');
define('DIR_FSEP', '/');
define('DIR_BSEP', '\\');

/**
 * class.
 * Path Help with handling or manipulating file and directory path [CLASS]
 * 
 * @author Shahzadi Afsara
 * @author Shahzada Modassir <codingmodassir@gmail.com>
 */
class Path
{

  /**
   * For Internal Use Only
   * 
   * Declare Regular Expression private constant property which use inside the \class
   * @var self Regular Expression constant var
   * @property self private property use only inside class not allow outside of class
   */
  private const RDRIVE     = '/^(?:([a-z]:)|([\\\\\/]{2}[^\W]+[\\\\\/]+[^\W]+))/i';
  private const RFILEINFO  = '/(?:(\.*([^.]*)$|)((.*)(\.[\w]*))*).*$/';
  private const RPARSEROOT = '/^(([a-z]:)*[\\\\\/]?)(^|[\\\\\/]*)/i';
  private const ROOTSEPARATOR = '/^([\\\\\/])(^|[\\\\\/]*)/';
  private const RSEPARATOR = '/^[\\\\\/]+$/';
  private const RPARENT    = '/^(?:\.\.)$/';
  private const RHASDIR    = '[\\\\\/]';
  private const RGLOBSEP   = '/[\\\\\/]+/';
  private const RDUALSEP   = '/(?:[\\\\\/])/';

  /**
   * For Internal Use Only
   * 
   * @var static
   * @property static private property use only inside class not allow outside of class
   */
  private static $pathinfo;
  private static $parsed;
  private static $drive;
  private static $paths;
  private static $resolved;
  private static $formated;

  /**
   * 
   * 
   * @param array $paths
   * @return void
   */
  public function __construct(array $paths)
  {
    @empty(@\preg_grep(self::RDRIVE, $paths)) && @\array_unshift($paths, @\getcwd());
    self::$drive    = self::init($paths);
    self::$paths    = self::set($paths);
    self::$resolved = [];
  }

  /**
   * Returns resolved string [PATH] attach with [DIR_BSEP] separator with [DRIVE]
   * 
   * @return string resolved $path string
   */
  private static function attach() : string
  {
    self::$drive = @\preg_replace(self::RDUALSEP, '\\', self::$drive);
    self::$resolved = @\array_diff(self::$resolved, ['.']);
    return self::$drive . DIR_BSEP . \join(DIR_BSEP, self::$resolved);
  }

  /**
   * Returns $path to seprate with separator like [DIR_BSEP] or [DIR_FSEP] separator
   * 
   * @param string $path Path to evaluate separator needed
   * @param string $separator An DIRECTORY_SEPARATOR like DIR_BSEP or DIR_FSEP
   * 
   * @return string Separated PATH with specific separator
   */
  public static function separate(string $path, string $separator=\DIR_BSEP) : string {
    $separator = @\preg_match(self::RSEPARATOR, $separator) ? $separator : \DIR_BSEP;
    return @\preg_replace(self::RGLOBSEP, $separator, $path);
  }

  /**
   * @method parse
   * Returns an array-object from a path string - the opposite of format().
   * 
   * @param string $path Path to evaluate parser
   * @return array parsed array-object path string - opposite of formate().
   * @throws FatalError if any of the arguments is not a string.
   */
  public static function parse(string $path) : array
  {
    @\preg_match(self::RPARSEROOT, $path, $matches);
    $path = @\preg_replace(self::RPARSEROOT, '', $path);

    self::$pathinfo = @\pathinfo($path);
    self::$parsed   = [];

    @\preg_match(self::RFILEINFO, self::$pathinfo['basename'], $match);

    $drive                = $matches[0];
    self::$parsed['base'] = $match[3] ?? $match[1];
    self::$parsed['name'] = $match[4] ?? $match[2];
    self::$parsed['ext']  = $match[5] ?? '';
    self::$parsed['root'] = $matches[1];
    self::$parsed['dir']  = $drive.@\pathinfo($path, PATHINFO_DIRNAME);
    self::$parsed['dir']  = @\preg_replace(
      self::RPARSEROOT,
      $matches[3] && @\preg_match(self::RHASDIR, self::$parsed['dir'])
      ? '$2$3' : '$0',
      self::$parsed['dir']
    );

    return self::$parsed;
  }

  /**
   * @method format
   * Returns an format-path from a array object - the opposite of parse().
   * 
   * @param array $path_object Path to evaluate
   * @return string formated path-string object - the opposite of parse().
   * @throws FatalError if any of the arguments is not a array.
   */
  public static function format(array $path_object) : string
  {
    self::$formated = [];
    array_push(self::$formated,
      isset($path_object['dir']) && $path_object['dir'] ?
        $path_object['dir'] :
        $path_object['root'],
      isset($path_object['base']) && $path_object['base'] ?
        $path_object['base'] : $path_object['name'] . $path_object['ext']
    );

    return join(DIR_BSEP, self::$formated);
  }

  /**
   * Normalize a string path, reducing '..' and '.' parts. When multiple slashes are found,
   * they're replaced by a single one; when the path contains a trailing slash,
   * it is preserved. On Windows backslashes are used.
   * 
   * @param string $path string path to normalize.
   * @return string normalized path string
   */
  public static function normalize(string $path) : string
  {
    return self::join($path);
  }

  /**
   * On Windows systems only, returns an equivalent namespace-prefixed path for the given path.
   * If path is not a string, path will be returned without modifications.
   * This method is meaningful only on Windows system. On POSIX systems,
   * the method is non-operational and always returns path without modifications.
   * 
   * @param string $path string path to NamespacedPath
   * @return string toNamespacedPath string path expression
   */
  public static function to_namespaced_path(string $path) : string
  {
    return '\\\\?\\' . self::separate(
      @\preg_replace('/^([\\\\\/]{2})([^\\\\\/]+)/', '\\\$1UNC\\\$2', self::resolve($path))
    );
  }

  /**
   * Join all arguments together and normalize the resulting path.
   * 
   * @param string ...$path Path to join
   * @return string joined path
   */
  public static function join(string ...$paths) : string
  {
    return preg_replace(self::RDRIVE, '', self::resolve(join(DIR_BSEP, $paths)));
  }

  /**
   * Returns and Primary [DRIVE] and remove matched [DRIVE] value a specific [index]
   * 
   * @param array $paths A sequence of paths or path segments.
   * @return array Matched single [DRIVE] from last position with array format()
   */
  private static function init(array &$paths)
  {
    // Matches [DRIVE] from starting point in array $paths
    $matches = @\preg_grep(self::RDRIVE, $paths);
    $index   = @\array_key_last($matches);
    $matched = @\end($matches);

    // Re-matches exact [DRIVE] from $matches expression
    @\preg_match(self::RDRIVE, $matched, $matches);
    $matched       = @\end($matches);

    // Remove matched [DRIVE] and Update matched path value a specific [$index]
    $paths[$index] = @\substr($paths[$index], @\strlen($matched));

    return $matched;
  }

  /**
   * Returns set newly-paths array with separated [DIR_BSEP] separator
   * 
   * @param array $path A sequence of paths or path segments.
   * @return array Split a `$paths` into substrings using the [DIR_BSEP] and return them as an array.
   */
  private static function set(array $paths)
  {
    // TODO: Need to Enhance method specified version
    // Remove NULL and EMPTY value of [array] $paths
    $paths = array_diff($paths, [null, '']);

    if (!@empty(($matches=@\preg_grep(self::ROOTSEPARATOR, $paths)))) {
      $index  = @\array_key_last($matches);
      $length = @\count($paths);
      $paths  = @\array_slice($paths, $index, $length);
    }
    
    return @\explode(
      DIR_BSEP,
      @join(DIR_BSEP, @\array_map('self::separate', $paths))
    );
  }

  /**
   * The right-most parameter is considered {to}. Other parameters are considered an array of {from}.
   * Starting from leftmost {from} parameter, resolves {to} to an absolute path.
   * 
   * If {to} isn't already absolute, {from} arguments are prepended in right to left order,
   * until an absolute path is found. If after using all {from} paths still no absolute path is found,
   * the current working directory is used as well. The resulting path is normalized,
   * and trailing slashes are removed unless the path gets resolved to the root dire
   * 
   * @param string ...$path A sequence of paths or path segments.
   * @return
   */
  public static function resolve(string ...$paths) : string
  {
    //
    new static($paths);
    self::$paths = @\array_diff(self::$paths, ['']);
    foreach(self::$paths as $path) {
      @\preg_match(self::RPARENT, $path) ? @\array_pop(self::$resolved) : @\array_push(self::$resolved, $path);
    }

    return self::attach();
  }
}
?>