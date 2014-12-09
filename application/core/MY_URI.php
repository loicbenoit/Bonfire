<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * URI Class extension
 *
 * Parses URIs and determines routing
 * Modified to extract the display language from the URI without disrupting routing.
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	URI
 * @author		Loic Benoit
 * @link		http://codeigniter.com/user_guide/libraries/uri.html
 */
class MY_URI extends CI_URI {

	function __construct()
	{
		parent::__construct();
		log_message('debug', "MY_URI Class Initialized");
	}


	// --------------------------------------------------------------------

	/**
	 * Set the URI String
	 *
	 * Modifications:
	 *	- Changed one line from original method
	 *	- Added code to remove optional language segment from URI (if found in first segment).
	 *
	 * @access	public
	 * @param 	string
	 * @return	string
	 */
	function _set_uri_string($str)
	{
		//---------------------------------------
		// Filter out control characters
		//---------------------------------------
		$str = remove_invisible_characters($str, FALSE);

		//---------------------------------------
		// If the URI contains only a slash we'll kill it
		//---------------------------------------
		//$this->uri_string = ($str == '/') ? '' : $str;	//Commented from original
		$str = ($str == '/') ? '' : $str; 					//Modified from original
		

		// --- Added code from here to end of method ---

		//---------------------------------------
		// We only need to split str in 2 to get the first segment.
		// Avoid doing too much work on str, it hasn't been sanitised yet
		// and you don't want to sanitize twice.
		//---------------------------------------
		$segments = array(); 
		if(strlen($str) > 0)
		{
			 $segments = explode('/', $str, 2);
		}
		
		//---------------------------------------
		// Note: Must execute this even if str is empty in order
		// to set config parameter "language_from_uri"
		//---------------------------------------
		$this->uri_string = $this->remove_lang_from_uri($segments);
	}


	// --------------------------------------------------------------------


	/**
	 * Extract and remove the language segment from the URI (it's expected to be the first segment).
	 * It's a language only if it matches a diretory name in "APPPATH/language".
	 *
	 * @param	mixed	$segments	The list of URI segments
	 * @param	mixed	$lang_code	If NOT NULL, assign language to the variable, by ref. If NULL, add it to the config array, under "language_from_uri".
	 * @param	mixed	$update_language	Should the "language" config item be updated (if possible)? Dft: TRUE
	 *
	 * @return	string	The language segment extracted from the URI or an empty string
	 */
	public function remove_lang_from_uri($segments = NULL, &$lang_code = NULL, $update_language = TRUE)
	{
		if( ! is_array($segments) OR empty($segments))
		{
			$segments = array();
		}
		
		//---------------------------------------
		// Get and sanitize the first segment.
		//---------------------------------------
		if(isset($segments[0]))
		{
			$seg0 = $this->_filter_uri($segments[0]);
		}
		else
		{
			$seg0 = '';
		}
		
		//---------------------------------------
		// Whitelist the first segment to decide if it's a language
		//---------------------------------------
		$lang = '';
		
		if(in_array($seg0, $this->list_possible_languages(), TRUE))
		{
			$lang = $seg0;
			
			//---------------------------------------
			// Remove language from URI segments.
			//---------------------------------------
			$segments = array_slice($segments, 1);
			
			//---------------------------------------
			// Avoid many circular dependency problems by using the language from URI as
			// initial language value instead of the default value from config.
			//
			// The language has been sanitized and whitelisted as far as security is concerned.
			//
			// The application may later apply additional business logic and compare
			// the current language with config->item:language_from_uri to determine if
			// the language was set from the URI or not.
			//---------------------------------------
			if(is_null($lang_code) && $update_language)
			{
				$this->config->set_item('language', $lang);
			}
		}
		else
		{
			log_message('debug', __METHOD__.' ('.__LINE__.') >>> URI doesn\'t appear to have a language segment.');
		}
		
		//---------------------------------------
		// Save the language in config, unless $lang_code is not NULL.
		//---------------------------------------
		if(is_null($lang_code))
		{
			$this->config->set_item('language_from_uri', $lang);
		}
		else
		{
			$lang_code = $lang;
		}
		
		log_message('debug', __METHOD__.' ('.__LINE__.') >>> language_from_uri is: '.$lang);

		//--------------
		// Produce the URI string.
		//--------------
		if(count($segments) > 0)
		{
			$uri = implode('/', $segments);
		}
		else
		{
			$uri = '';
		}
		
		return $uri;
	}


	// --------------------------------------------------------------------


	/**
	 * Get the list of possible language codes.
	 *
	 * @return	array 	The whitelist
	 */
	public function list_possible_languages()
	{
		$whitelist = scandir(APPPATH.'language');
		
		if(is_array($whitelist) && ! empty($whitelist))
		{
			$temp = array();
			foreach($whitelist as $v)
			{
				if('.' !== $v && '..' !== $v)
				{
					$temp[] = $v;
				}
			}
			$whitelist = $temp;
			unset($temp);
		}
		else
		{
			log_message('debug', __METHOD__.' ('.__LINE__.') >>> Language whitelist is empty.');
			$whitelist = array();
		}
		
		return $whitelist;
	}	
	// --------------------------------------------------------------------

}
// END URI Class

/* End of file MY_URI.php */
/* Location: ./application/core/MY_URI.php */
