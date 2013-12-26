<?php
namespace Ovh\Ip;

class FirewallRule {
	public $ip;
	public $ipOnMitigation;
	public $action;
	public $destinationPort;
	public $protocol;
	public $sequence;
	public $source;
	public $sourcePort;
	public $tcpOption;
	public $udpOption;
	
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
	
	function set(){
		self::getClient()->setFirewallRule($this->ip, $this->ipOnMitigation, $this->action, $this->destinationPort, $this->protocol, 
				$this->sequence, $this->source, $this->sourcePort, $this->tcpOption, $this->udpOption);
	}
	
	function delete(){
		self::getClient()->setFirewallRuleDelete($this->ip, $this->ipOnMitigation, $this->sequence);
	}
}