<?php
namespace Ovh\Ip;

class ReverseDns {
	private $ip;
	private static $ipClient;
	/**
	 * Return Dedicated Server client
	 *
	 * @return null|IpClient
	 */
	private static function getClient()
	{
		if (!self::$ipClient instanceof IpClient){
			self::$ipClient = new IpClient();
		};
		return self::$ipClient;
	}
	
	function __construct($ip){
		$this->ip = $ip;
	}
	
	function getIp(){
		return $this->ip;
	}
	
	public function setReverse($ipReverse, $reverse){
		self::getClient()->setReverse($ipReverse, $this->getIp(), $reverse);
		return true;
	}
	
	public function getReverse($ipReverse){
		return self::getClient()->getReverse($ipReverse, $this->getIp());
	}
}