<?php
namespace Ovh\Ip;

class Firewall {
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
		return self::$serverClient;
	}
	
	function __construct($ip){
		$this->ip = $ip;
	}
	
	function getIp(){
		return $this->ip;
	}
	
	
	
	public function setFirewallOn($ipblock){
		self::getClient()->setFirewallOn($this->getIp(),$ipblock);
		return true;
	}
	
	public function setFirewallOff($ipblock){
		self::getClient()->setFirewallOff($this->getIp(),$ipblock);
		return true;
	}
	
	public function getFirewall($ipblock){
		return self::getClient()->getFirewall($this->getIp(), $ipblock);
	}
}