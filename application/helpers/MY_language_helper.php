<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers extension
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Loic Benoit
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Get the current request language.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('current_language'))
{
	function current_language()
	{
		return MY_Lang::current_language();
	}
}

// ------------------------------------------------------------------------


// --------------------------------------------------------------------


/* End of file MY_lang_helper.php */
/* Location: ./application/helpers/MY_lang_helper.php */
