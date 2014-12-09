<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers extension
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string	$uri				the URI string
 * @param	bool	$prepend_language	TRUE: Add the current language before the URI. FALSE: Don't.
 * @return	string
 */
if ( ! function_exists('site_url'))
{
	function site_url($uri = '', $prepend_language = TRUE)
	{
		$CI =& get_instance();
		return $CI->config->site_url($uri, $prepend_language);
	}
}

// ------------------------------------------------------------------------

/**
 * Base URL
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @access	public
 * @param	string	$uri				the URI string
 * @param	bool	$prepend_language	TRUE: Add the current language before the URI. FALSE: Don't.
 * @return	string
 */
if ( ! function_exists('base_url'))
{
	function base_url($uri = '', $prepend_language = TRUE)
	{
		$CI =& get_instance();
		return $CI->config->base_url($uri, $prepend_language);
	}
}


// --------------------------------------------------------------------


/**
 * Appends and/or prepend a slash to the string, if not empty and not a slash.
 *
 * @access	public
 * @param	string
 * @param	int		$option		<0: Prepend, 0: Prepend and append, >0: Append.
 * @return	string
 */
if( ! defined('SLASH_PREPEND'))	{	define('SLASH_PREPEND', -1);	}
if( ! defined('SLASH_BOTH'))	{	define('SLASH_BOTH', 0);		}
if( ! defined('SLASH_APPEND'))	{	define('SLASH_APPEND', 1);		}

if ( ! function_exists('slash'))
{
	function slash($str, $option = 1)
	{
		if(trim($str) == '')
		{
			return '';
		}

		if($option < 0)
		{
			// Prepend
			return '/'.ltrim($str, '/');
		}
		elseif($option > 0)
		{
			// Append
			return rtrim($str, '/').'/';
		}
		else
		{
			// Both prepend and append
			return '/'.trim($str, '/').'/';
		}
	}
}

// --------------------------------------------------------------------


/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */
