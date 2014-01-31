<?php 
/**
 * Load - Run controller and Output view - by path
 *
 * @param  [string|array] $path Path to the controller/action/params
 * @return [void]               Returns the view OR contents if the View if $path is null
 *
 * @demo   load('layout/member/header');  // LayoutController::member(array('header))
 * @demo   load(array('controller' => 'layout', 'action' => 'member', 'params' => array('header)));
 * ********************************************** */
  function load($path = null, $ajax = false) { return $ajax ? null : Controller::exec($path); }

/**
 * Alias for Language::get - return translated string realated to the $key
 * @param  [string] $key = null Key relating to translated text
 * @return [string]             Returns the translation equivalent to the string
 * 
 * @demo   echo __('message');  // ouput: 'Salut Lume!'
 * **************************************************** */
  function __($key = null, $replace = null)
  { 
    $string = Language::get($key);
    
    if(is_array($replace))
      foreach($replace as $word)
        $string = sprintf($string, $word);
    elseif(!empty($replace))
      $string = sprintf($string, $replace);
    
    return $string;
  }

/**
 * Redirect - Internal redirect helper function
 * @param  [string] $location = BASEURL Where to redirect
 * @return [void]                       Doesn't return anything it redirects
 * 
 * @demo   redirect(BASEURL.'module/controller/action/params');
 * ******************************************************************************* */
  function redirect($location = BASEURL) { header('Location: '.$location); exit; }
  
  function kill($status = 200, $message = null)
  {
    $status = (int) $status;
		
		errorlog("kill({$status}) | Killed: {$message}");
    
    switch($status)
    {
      case 200: header('HTTP/1.1 200 OK'); die('200 '. (empty($message) ? 'OK' : $message)); break;
      case 403: header('HTTP/1.1 403 Forbidden'); die('403 '. (empty($message) ? 'Forbidden!' : $message)); break;
      case 404: header('HTTP/1.1 404 Not Found'); die('404 '. (empty($message) ? 'Not found!' : $message)); break;
      case 500: header('HTTP/1.1 500 Internal Server Error'); die('500 '. (empty($message) ? 'Internal Server Error' : $message)); break;
      default: die((string) $status); break;
    }
  }
  
  
  function compress_html($contents)
  {
    $search = array(
      '/\>[^\S ]+/s', # strip whitespaces after tags, except space  #
      '/[^\S]+\</s',  # strip whitespaces before tags, except space #
      '/(\s)+/s',     # shorten multiple whitespace sequences       #
      '/ {2,}/',
      '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
    );
    $replace = array('>', '<', '\\1', ' ', '');
    return preg_replace($search, $replace, $contents);
  }

  function mtimestamp()
  {
    return ceil(microtime(true) * 1000);
  }

  function get_file_extension($filepath) { return strtolower(array_pop(explode('.',$filepath))); }

  function get_mime_type($filepath)
  {
    $ext = get_file_extension($filepath);

    if (!$type = get_mime_by_extension($ext))
      $type = 'text/html';

    return $type;
  }

  function get_mime_by_extension($ext)
  {
    $ct['htm']  = 'text/html';
    $ct['html'] = 'text/html';
    $ct['json'] = 'application/json';
    $ct['txt']  = 'text/plain';
    $ct['asc']  = 'text/plain';
    $ct['bmp']  = 'image/bmp';
    $ct['gif']  = 'image/gif';
    $ct['jpeg'] = 'image/jpeg';
    $ct['jpg']  = 'image/jpeg';
    $ct['jpe']  = 'image/jpeg';
    $ct['png']  = 'image/png';
    $ct['ico']  = 'image/vnd.microsoft.icon';
    $ct['mpeg'] = 'video/mpeg';
    $ct['mpg']  = 'video/mpeg';
    $ct['mpe']  = 'video/mpeg';
    $ct['qt']   = 'video/quicktime';
    $ct['mov']  = 'video/quicktime';
    $ct['avi']  = 'video/x-msvideo';
    $ct['wmv']  = 'video/x-ms-wmv';
    $ct['mp2']  = 'audio/mpeg';
    $ct['mp3']  = 'audio/mpeg';
    $ct['rm']   = 'audio/x-pn-realaudio';
    $ct['ram']  = 'audio/x-pn-realaudio';
    $ct['rpm']  = 'audio/x-pn-realaudio-plugin';
    $ct['ra']   = 'audio/x-realaudio';
    $ct['wav']  = 'audio/x-wav';
    $ct['css']  = 'text/css';
    $ct['zip']  = 'application/zip';
    $ct['pdf']  = 'application/pdf';
    $ct['doc']  = 'application/msword';
    $ct['bin']  = 'application/octet-stream';
    $ct['exe']  = 'application/octet-stream';
    $ct['class']= 'application/octet-stream';
    $ct['dll']  = 'application/octet-stream';
    $ct['xls']  = 'application/vnd.ms-excel';
    $ct['ppt']  = 'application/vnd.ms-powerpoint';
    $ct['wbxml']= 'application/vnd.wap.wbxml';
    $ct['wmlc'] = 'application/vnd.wap.wmlc';
    $ct['wmlsc']= 'application/vnd.wap.wmlscriptc';
    $ct['dvi']  = 'application/x-dvi';
    $ct['spl']  = 'application/x-futuresplash';
    $ct['gtar'] = 'application/x-gtar';
    $ct['gzip'] = 'application/x-gzip';
    $ct['js']   = 'application/x-javascript';
    $ct['swf']  = 'application/x-shockwave-flash';
    $ct['tar']  = 'application/x-tar';
    $ct['xhtml']= 'application/xhtml+xml';
    $ct['au']   = 'audio/basic';
    $ct['snd']  = 'audio/basic';
    $ct['midi'] = 'audio/midi';
    $ct['mid']  = 'audio/midi';
    $ct['m3u']  = 'audio/x-mpegurl';
    $ct['tiff'] = 'image/tiff';
    $ct['tif']  = 'image/tiff';
    $ct['rtf']  = 'text/rtf';
    $ct['wml']  = 'text/vnd.wap.wml';
    $ct['wmls'] = 'text/vnd.wap.wmlscript';
    $ct['xsl']  = 'text/xml';
    $ct['xml']  = 'text/xml';

    return $ct[$ext];
  }

  function valid_date($date)
  {
    $date = preg_replace('/[-\.:\s]/', '-', $date);

    if(!preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date)) return FALSE;

    $timestamp = strtotime($date);
    if(!is_numeric($timestamp)) return FALSE;

    return checkdate(date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp));
  }

  function valid_url($url)
  {
    return preg_match('/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9-_]*)+):?(d+)?/?/i', $url);
  }
  
  function friendly_url($keyword)
  {
    return trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $keyword), '-');
  }

  function array_sort($array, $on, $order = SORT_ASC)
  {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) 
    {
      foreach ($array as $k => $v) 
      {
        if (is_array($v)) 
        {
          foreach ($v as $k2 => $v2) 
            if ($k2 == $on) 
              $sortable_array[$k] = $v2;
        }
        else 
        {
          $sortable_array[$k] = $v;
        }
      }

      switch ($order) 
      {
        case SORT_ASC:
          asort($sortable_array);
        break;
        case SORT_DESC:
          arsort($sortable_array);
        break;
      }

      foreach ($sortable_array as $k => $v)
        $new_array[$k] = $array[$k];
    }
    return $new_array;
  }
  
  function rimplode($sep = '-', $array = null)
  {
    # TODO: recursive implode #
  }

/**
 * Array One - Array Two = Result
 *
 * @param  array $one The big array
 * @param  array $two The smaller array
 * @return array      Result difference array
 *
 * @demo   $result = array_difference($one, $two)
 * ********************************************** */
  function array_difference($one, $two)
  {
    $result = array();
    foreach($one as $o_key => $o_value)
    {
      $value = $o_value;

      foreach($two as $t_key => $t_value)
      {
        if(is_array($o_value) && is_array($t_value))
        {
          if(array_compare($o_value, $t_value))
            $value = NULL;
        }
        elseif($o_value == $t_value)
          $value = NULL;
      }
      if(!is_null($value))
        $result[$o_key] = $value;

    }
    return $result;
  }

/**
 * Compare arrays
 *
 * @param  array $one First array
 * @param  array $two Second array
 * @return bool       Are the 2 arrays equal
 *
 * @demo   if(array_compare($group, $products))
 *           echo 'the arrays are equal';
 * ********************************************** */
  function array_compare($one = NULL, $two = NULL)
  {
    if(!is_array($one) || !is_array($two)) return FALSE;

    if(count($one) != count($two))  return FALSE;

    $result = TRUE;

    foreach($one as $o_key => $o_value)
    {
      $result = FALSE;
      foreach($two as $t_key => $t_value)
      {
        if(is_array($o_value) && is_array($t_value))
        {
          if(array_compare($o_value, $t_value))
            $result = TRUE;
        }
        elseif($o_value == $t_value)
        {
          $result = TRUE;
        }
      }
      if($result == FALSE) break;
    }
    return $result;
  }

  function urlify($string = '') { return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)), '-'); }

  function deep_serialize($variable) { return base64_encode(gzcompress(serialize($variable))); }

  function deep_unserialize($string) { return unserialize(gzuncompress(base64_decode($string))); }
  
  function debug($data = null)
  {
    echo NL, '<pre>', NL, print_r($data), NL, '</pre>', NL;
  }

  function devlog($data = null)
  {
		if(!Config::get('system:logging')) return;
	
    if(! is_string($data))
      $data = print_r($data, true);
      
    $data = trim(strip_tags($data));

    $data = '['. strftime('%Y-%m-%d %H:%M:%S', time()) ."] {$data}". NL;
    
    // @TODO: Check if logs/what_ever folder exists

    file_put_contents(ROOT.'logs'.DS.'dev.'.strftime('%Y%m%d').'.log', $data, FILE_APPEND);
  }

  function errorlog($data = NULL)
  {
		if(!Config::get('system:logging') || Config::get('system:environment') === 'production') return;
		
    if(! is_string($data))
      $data = print_r($data, true);
      
    $data = trim(strip_tags($data));

    $data = '['. strftime('%Y-%m-%d %H:%M:%S', time()) ."] {$data}". NL ;
    
    // @TODO: Check if logs/what_ever folder exists
		
    file_put_contents(ROOT.'logs'.DS.'error.'.strftime('%Y%m%d').'.log', $data, FILE_APPEND);
  }
  
  function date_mysql_us($date = '1970-01-13', $sep = '-')
  {
    list($year, $month, $day) = explode('-', $date);
    return array(
      'date'  => "{$month}{$sep}{$day}{$sep}{$year}",
      'day'   => $day,
      'month' => $month,
      'year'  => $year,
    );
  }
  
  function array_value($key = 0, $array = array())
  {
    return isset($array[$key]) ? $array[$key] : NULL;
  }
  
  function bigintval($bigint, $extract = false)
  {
    if($extract) 
    {
      preg_match('/^(\d+).*/', $bigint, $matches);
      return array_value(1, $matches);
    }
    else
    {
      preg_match('/^\d+$/', $bigint, $matches);
      return array_value(0, $matches);
    }
  }


  /* Utility                                                                                                          */
  function count_digits($numb)
  {
    $i = 0;
    while($numb > 1)
    {
      $numb = $numb / 10;
      $i++;
    }
    return $i;
  }

  function limit_words($string, $limit = 20)
  {
    $words = explode(' ', $string);
    $string = '';
    for($i = 0; $i < $limit; ++$i)
    {
      if(!empty($words[$i]))
        $string .= $words[$i] . ' ';
    }
    return trim($string). '...';
  }

  function highlight_word($string, $word = null)
  {
    if(empty($word)) return $string;
    return preg_replace("/b($word)b/i", '<span style="background:#5fc9f6">$1</span>', $string);
  }
	
	function db_format_columns($columns = '*', $table = null)
	{
		$formatted = array();
		
		if(!is_array($columns))
			$columns = explode(',', ((string) $columns));
			
		$table = empty($table) ? '' : "`{$table}`.";
		
		foreach($columns as $value)
			$formatted[] = trim($value) === '*' ? $table.'*' : $table.'`'. trim($value) .'`';

		return implode(', ', $formatted);
	}
