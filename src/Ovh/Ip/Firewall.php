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
		return self::$ipClient;
	}
	
	function __construct($ip){
		$this->ip = $ip;
	}
	
	function getIp(){
		return $this->ip;
	}
	
	
	
	public function setFirewallOn(){
		self::getClient()->setFirewallOn($this->getIp(),$this->ip);
		return true;
	}
	
	public function setFirewallOff(){
		self::getClient()->setFirewallOff($this->getIp(),$this->ip);
		return true;
	}
	
	public function getFirewall(){
		return self::getClient()->getFirewall($this->getIp(), $this->ip);
	}

	public function addFirewallRule($ipOnMitigation,$action,$destinationPort,
									$protocol,$sequence,$source,$sourcePort,$fragments,$tcpOption){
		return
			self::getClient()->setFirewallRule($this->ip,$ipOnMitigation,$action,$destinationPort,
				$protocol,$sequence,$source,$sourcePort,$fragments,$tcpOption);
	}

	public function deleteFirewallRule($ipOnMitigation,$sequence){
		return
			self::getClient()->setFirewallRuleDelete($this->ip,$ipOnMitigation,$sequence);
	}

	public function getFirewallRules($ipOnMitigation){
		$client = self::getClient();
		$rules = $client->getFirewallRules($this->ip,$ipOnMitigation);
		$ret = array();
		foreach($rules as $seq){
			$rule = null;
			try {
				$rule = $client->getFirewallRule($this->ip, $ipOnMitigation, $seq);
			}catch (\Exception $ex){

			}
			$ret[$seq] = $rule;
		}
		return $ret;
	}
}