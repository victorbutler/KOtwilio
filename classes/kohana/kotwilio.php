<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twilio for Kohana.
 *
 * @package    Kotwilio
 * @author     Victor Butler <victorbutler@gmail.com>
 * @copyright  (c) 2012 Victor Butler
 * @license    MIT
 */
abstract class Kohana_Kotwilio {

	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Kotwilio
	 */
	public static function instance() {
		if (!isset(Kotwilio::$_instance)) {
			Kotwilio::$_instance = new Kotwilio();
		}
		return Kotwilio::$_instance;
	}

	protected $_config;

	protected $_twilio;

	/**
	 *
	 *
	 */
	public function __construct($config = array()) {
		// Get our Twilio identification
		$this->_config = (count($config) ? $config : Kohana::$config->load('kotwilio'));
		$this->_twilio = new Services_Twilio($this->_config['account_sid'], $this->_config['auth_token']);
	}

	/**
	 *
	 *
	 */
	public function sms($from, $to, $body, $status_callback = null, $application_sid = null) {
		$params = array();
		if ($status_callback !== null) {
			$params['StatusCallback'] = $status_callback;
		}
		if ($application_sid !== null) {
			$params['ApplicationSid'] = $application_sid;
		}
		return $this->_twilio->account->sms_messages->create($from, $to, $body, $params);
	}

}
