<?php
/**
* @author Ribhararnus Pracutian <pracutian@ribhnux.tech>
* @version 1.0.0
* @package FunctionReplace
*/

/**
 * A Function Replace class to replace existing function within file replaced with another function.
 * Including it's parameters.
 */
class FunctionReplace {
  /**
   * Output
   * @var string
   */
  public $output = '';

  /**
   * From function name
   * @var string
   */
  private $from_fn = '';

  /**
   * To Function name
   * @var string
   */
  private $to_fn = '';

  /**
   * Whether write file's function or not
   * @var boolean
   */
  private $replace = false;

  /**
   * Succeed status if files already overwritten
   * @var boolean
   */
  public $overwritten = false;

  public function __construct ($from_fn, $to_fn, $replace = false) {
    $this->from_fn = $from_fn;
    $this->to_fn = $to_fn;
    $this->replace = $replace;

    if ($this->from_fn && $this->to_fn) {
      $this->output = $this->replace_fn($from_fn, $to_fn);
      $this->replace_file();
    }
  }

  /**
   * Get function file
   * @param  string $fn_name
   * @return string
   */
  public function get_file ($fn_name) {
    $fn = new ReflectionFunction($fn_name);
    $file = $fn->getFileName();
    if ($file && file_exists($file)) {
      return $file;
    }
  }

  /**
   * Get lines of file
   * @param  string $fn_name
   * @param  array $is_array
   * @return array
   */
  public function get_lines ($fn_name, $is_array = true) {
    $file = $this->get_file($fn_name);
    if ($file) {
      $lines = file($file);
      return $is_array ? $lines : implode('', $lines);
    }
  }

  /**
   * Get function string
   * @param  string  $fn_name
   * @param  boolean $full_content
   * @param  boolean $is_array
   * @return string|array
   */
  public function get_string ($fn_name, $full_content = true, $is_array = false) {
    $lines = $this->get_lines($fn_name);
    if ($lines) {
      $fn = new ReflectionFunction($fn_name);
      $start_line = $fn->getStartLine() - 1;
      $end_line = $fn->getEndLine() - $start_line;
      $fn_array = array_slice($lines, $start_line, $end_line);
      $fn_array = !$full_content ? array_slice($fn_array, 1, -1): $fn_array;
      return !$is_array ? implode('', $fn_array) : $fn_array;
    }
  }

  /**
   * Get function parameters
   * @param  string $fn_name
   * @return string
   */
  public function get_params ($fn_name) {
    $fn = $this->get_string($fn_name, true, true);
    if ($fn) {
      preg_match_all('%\((.*)\)%m', $fn[0], $matches);
      if (isset($matches[1])) {
        return $matches[1][0];
      }
    }
  }

  /**
   * Output of file's functions
   * @param  string $fn_old
   * @param  string $fn_new
   * @return string
   */
  public function replace_fn ($fn_old, $fn_new) {
    $fn_old_lines = $this->get_lines($fn_old);
    $fn_new_str = $this->get_string($fn_new, false, true);
    
    if ($fn_old_lines && $fn_new_str) {
      $fn = new ReflectionFunction($fn_old);
      $start_line = $fn->getStartLine();
      $end_line = $fn->getEndLine() - $start_line;
      $fn_new_params = $this->get_params($fn_new);
      $fn_old_lines[$start_line - 1] = preg_replace('%\((.*)\)%m', "($fn_new_params)", $fn_old_lines[$start_line - 1]);
      array_splice($fn_old_lines, $start_line, $end_line - 1, $fn_new_str);
      return implode('', $fn_old_lines);
    }
  }

  /**
   * Replace file path where function belongs
   * @return void
   */
  public function replace_file () {
    if ($this->replace && $this->from_fn && !empty($this->output)) {
      $this->overwritten = false;
      $origin_output = $this->get_lines($this->from_fn, false);
      $origin_length = count(str_split($origin_output));
      $output_length = count(str_split($this->output));
      if ($origin_length !== $output_length) {
        $filename = $this->get_file($this->from_fn);
        if (is_writable($filename)) {
          $handle = fopen($filename, 'wa+');
          fwrite($handle, $this->output);
          fclose($handle);
          $this->overwritten = true;
        }
      }
    }
  }

  /**
   * Check overwrite status
   */
  public function succeed () {
    return $this->overwritten;
  }
}
