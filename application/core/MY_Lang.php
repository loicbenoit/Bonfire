<?php defined('BASEPATH') || exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Bonfire Language Class extension
 * Modification: Replace static fallback language with constant FALLBACK_LANGUAGE for un-translated lines.
 *
 */
class MY_Lang extends BF_Lang
{
    /**
     * @var String The fallback language used for un-translated lines.
     * If you change this, you should ensure that all language files have been
     * translated to the language indicated by the new value.
     */
    protected $fallback = FALLBACK_LANGUAGE;

	public function __construct()
	{
		parent::__construct();
		log_message('debug', "Application MY_Lang: Language Class Initialized");
	}
	
	
	public static function current_language()
	{
		$CI =& get_instance();
		return $CI->config->item('language');
	}
	

} // END Language Class

/* End of file MY_Lang.php */
