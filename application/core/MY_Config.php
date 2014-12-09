<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/MX/Config.php';


// ------------------------------------------------------------------------

/**
 * CodeIgniter Config Class extension
 *
 * This class contains functions that enable config files to be managed
 *
 * Modifications:
 *	- Prepend the current language code to all URI, unless asked not to do so.
 *
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Loic Benoit
 */
class MY_Config extends MX_Config {


	/**
	 * Constructor
	 *
	 * Sets the $config data from the primary config.php file as a class variable
	 *
	 * @access   public
	 * @param   string	the config file name
	 * @param   boolean  if configuration values should be loaded into their own section
	 * @param   boolean  true if errors should just return false, false if an error message should be displayed
	 * @return  boolean  if the file was successfully loaded or not
	 */
	function __construct()
	{
		parent::__construct();
		log_message('debug', "MY_Config Class Initialized");
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Get the callable function for deciding if the language should be prepended
	 * to a URI.
	 *
	 * @return	callable
	 */
	public function get_do_not_prepend_lang_fct()
	{
		return function($uri) {
			
			//-----------------------------------
			// This regex is designed to ignore query strings, and assumes
			// that URI don't have file extensions such as ".html" and ".php".
			//-----------------------------------
			if(preg_match('#(?:^|/)(?:[^?/])+\.(?:[a-zA-Z0-9]{2,4})(?:$|\?)#', $uri))
			{
				return TRUE;
			}
			
			return FALSE;
		};
	}	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Site URL
	 * Returns base_url . index_page [. uri_string]
	 * Prepends the language to uri, if possible.
	 *
	 * @access	public
	 * @param	string or array		$uri				the URI string
	 * @param	bool				$prepend_language	TRUE: Add the current language before the URI. FALSE: Don't.
	 * @param	mixed				$prepend			Polymorphic variable:
	 *														- NULL or TRUE (dft): Prepend current language.
	 *														- String, non-empty: Prepend the string, it's a language.
	 *														- FALSE or invalid input: Do not prepend anything.
	 * @param	callable			$exclude_uri		A function accepting the URI as first argument and returning TRUE if the
	 *													language must NOT be added to the URI (such as URI for files and assets).
	 *													The default function is given by method MY_Config->get_do_not_prepend_lang_fct()
	 * @return	string
	 */
	public function site_url($uri = '', $prepend = NULL, $exclude_uri = NULL)
	{
		if(is_array($uri))
		{
			$uri = implode('/', $uri);
		}
		
		//---------------------------------------
		// Validate or obtain the callable for deciding if the language
		// should be prepended to the URI or not.
		//---------------------------------------
		if(empty($exclude_uri) OR ! is_callable($exclude_uri))
		{
			$exclude_uri = $this->get_do_not_prepend_lang_fct();
		}
		
		//---------------------------------------
		// Are we forbiden from adding the language to this URI?
		//---------------------------------------
		if($exclude_uri($uri))
		{
			$prepend = FALSE;
		}
		
		//---------------------------------------
		// Apply prepend logic.
		//---------------------------------------
		if(is_null($prepend) OR TRUE === $prepend)
		{
			// Prepend current request language.
			return parent::site_url($this->slash_item('language').ltrim($uri, '/'));
		}
		elseif(is_string($prepend) && strlen($prepend) > 0 && '/' !== $prepend)
		{
			// Prepend given string (assumed to be a language).
			return parent::site_url(rtrim($prepend, '/').'/'.ltrim($uri, '/'));
		}
		else
		{
			// Don't prepend anything.
			return parent::site_url($uri);
		}
	}

	
	// -------------------------------------------------------------
	
	
	/**
	 * Base URL
	 * Returns base_url [. uri_string]
	 * Prepends the language to uri, if possible.
	 *
	 * @param	string or array		$uri				the URI string
	 * @param	bool				$prepend_language	TRUE: Add the current language before the URI. FALSE: Don't.
	 * @param	mixed				$prepend			Polymorphic variable:
	 *														- NULL or TRUE (dft): Prepend current language.
	 *														- String, non-empty: Prepend the string, it's a language.
	 *														- FALSE or invalid input: Do not prepend anything.
	 * @param	callable			$exclude_uri		A function accepting the URI as first argument and returning TRUE if the
	 *													language must NOT be added to the URI (such as URI for files and assets).
	 *													The default function is given by method MY_Config->get_do_not_prepend_lang_fct()
	 * @return	string
	 */
	function base_url($uri = '', $prepend = NULL, $exclude_uri = NULL)
	{
		if(is_array($uri))
		{
			$uri = implode('/', $uri);
		}
		
		//---------------------------------------
		// Validate or obtain the callable for deciding if the language
		// should be prepended to the URI or not.
		//---------------------------------------
		if(empty($exclude_uri) OR ! is_callable($exclude_uri))
		{
			$exclude_uri = $this->get_do_not_prepend_lang_fct();
		}
		
		//---------------------------------------
		// Are we forbiden from adding the language to this URI?
		//---------------------------------------
		if($exclude_uri($uri))
		{
			$prepend = FALSE;
		}
		
		//---------------------------------------
		// Apply prepend logic.
		//---------------------------------------
		if(is_null($prepend) OR TRUE === $prepend)
		{
			// Prepend current request language.
			return parent::base_url($this->slash_item('language').ltrim($uri, '/'));
		}
		elseif(is_string($prepend) && strlen($prepend) > 0 && '/' !== $prepend)
		{
			// Prepend given string (assumed to be a language).
			return parent::base_url(rtrim($prepend, '/').'/'.ltrim($uri, '/'));
		}
		else
		{
			// Don't prepend anything.
			return parent::base_url($uri);
		}
	}
	
	
	// -------------------------------------------------------------

}

// END MY_Config class

/* End of file MY_Config.php */
/* Location: ./application/core/MY_Config.php */
