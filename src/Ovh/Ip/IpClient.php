<?php
/**
 * Copyright 2013 Stéphane Depierrepont (aka Toorop)
 *
 * Authors :
 *  - Stéphane Depierrepont (aka Toorop)
 *  - Florian Jensen (aka flosoft) : https://github.com/flosoft
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */


namespace Ovh\Ip;

#use Guzzle\Http\Exception\ClientErrorResponseException;
#use Guzzle\Http\Exception\BadResponseException;
#use Guzzle\Http\Exception\CurlException;
use Guzzle\Http\Message\Response;

use Ovh\Common\AbstractClient;
use Ovh\Common\Exception\BadMethodCallException;

#use Ovh\Common\Exception\NotImplementedYetException;

//use Ovh\Vps\Exception\VpsNotFoundException;
use Ovh\Dedicated\Server\Exception\ServerException;


class IpClient extends AbstractClient
{
	public function getReverse($ip,$ipReverse)
	{
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
		$ip = (string)$ip;
		
		if (!$ipReverse)
			throw new BadMethodCallException('Parameter $ipReverse is missing.');
		$ipReverse = (string)$ipReverse;
	
		$payload = array();
		try {
			$r = $this->get('ip/' . urlencode($ip).'/reverse/'.$ipReverse, array('Content-Type' => 'application/json;charset=UTF-8'))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function setReverse($ip,$ipReverse,$reverse)
	{
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
		$ip = (string)$ip;
		
		if (!$ipReverse)
			throw new BadMethodCallException('Parameter $ipReverse is missing.');
		$ipReverse = (string)$ipReverse;
		
		if (!$reverse)
			throw new BadMethodCallException('Parameter $reverse is missing.');
		$reverse = (string)$reverse;
	
		$payload = array('ipReverse'=>$ipReverse, 'reverse'=>$reverse);
		try {
			$r = $this->post('ip/' . urlencode($ip).'/reverse', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function setFirewallOn($ip,$ipOnFirewall)
	{
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
		$ip = (string)$ip;
		
		if (!$ipOnFirewall)
			throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
		$ipOnFirewall = (string)$ipOnFirewall;
		
		$payload = array('ipOnFirewall'=>$ipOnFirewall);
		try {
			$r = $this->put('ip/' . $ip.'/firewall', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function setFirewallOff($ip,$ipOnFirewall)
	{
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
		$ip = (string)$ip;
	
		if (!$ipOnFirewall)
			throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
		$ipOnFirewall = (string)$ipOnFirewall;
	
		$payload = array('ipOnFirewall'=>$ipOnFirewall);
		try {
			$r = $this->delete('ip/' . $ip.'/firewall', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function setMitigation($ip,$ipOnMitigation)
	{
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
		$ip = (string)$ip;
	
		if (!$ipOnMitigation)
			throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
		$ipOnFirewall = (string)$ipOnMitigation;
	
		$payload = array('ipOnMitigation'=>$ipOnMitigation);
		try {
			$r = $this->post('ip/' . $ip.'/mitigation', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function setMitigationOff($ip,$ipOnMitigation)
	{
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
		$ip = (string)$ip;
	
		if (!$ipOnMitigation)
			throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
		$ipOnMitigation = (string)$ipOnMitigation;
	
		$payload = array('ipOnMitigation'=>$ipOnMitigation);
		try {
			$r = $this->delete('ip/' . $ip.'/mitigation', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function getMitigation($ip,$ipOnMitigation)
	{
		$ip = (string)$ip;
		if (!$ip)
			throw new BadMethodCallException('Parameter $domain is missing.');
	
		if (!$ipOnMitigation)
			throw new BadMethodCallException('Parameter $ipOnMitigation is missing.');
		$ipOnMitigation = (string)$ipOnMitigation;
	
		$payload = array('ipOnMitigation'=>$ipOnMitigation);
		try {
			$r = $this->get('ip/' . urlencode($ip) . '/mitigation', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
	public function getMitigationStats($ip, $ipOnMitigation, $from, $scale ,$to)
	{
		$ip = (string)$ip;
		if (!$ip)
			throw new BadMethodCallException('Parameter $domain is missing.');
	
		if (!$ipOnMitigation)
			throw new BadMethodCallException('Parameter $ipOnMitigation is missing.');
		$ipOnMitigation = (string)$ipOnMitigation;
	
		$payload = array('ipOnMitigation'=>$ipOnMitigation,'from'=>$from, 'scale'=>$scale, 'to'=>$to);
		try {
			$r = $this->get('ip/' . urlencode($ip) . '/mitigation/stats', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
		} catch (\Exception $e) {
			throw new ServerException($e->getMessage(), $e->getCode(), $e);
		}
		return json_decode($r->getBody(true));
	}
	
    public function getFirewall($ip,$ipOnFirewall)
    {
        $ip = (string)$ip;
        if (!$ip)
            throw new BadMethodCallException('Parameter $domain is missing.');
        
        if (!$ipOnFirewall)
        	throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
        $ipOnFirewall = (string)$ipOnFirewall;
        
        $payload = array('ipOnFirewall'=>$ipOnFirewall);
        try {
            $r = $this->get('ip/' . urlencode($ip) . '/firewall', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
        } catch (\Exception $e) {
            throw new ServerException($e->getMessage(), $e->getCode(), $e);
        }
		return json_decode($r->getBody(true));
    }
    
    public function getFirewallRules($ip,$ipOnFirewall)
    {
    	$ip = (string)$ip;
    	if (!$ip)
    		throw new BadMethodCallException('Parameter $domain is missing.');
    
    	if (!$ipOnFirewall)
    		throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
    	$ipOnFirewall = (string)$ipOnFirewall;
    
    	try {
    		$r = $this->get('ip/' . urlencode($ip) . '/firewall/'.$ipOnFirewall.'/rule')->send();
    	} catch (\Exception $e) {
    		throw new ServerException($e->getMessage(), $e->getCode(), $e);
    	}
		return json_decode($r->getBody(true));
    }
    
    public function getFirewallRule($ip,$ipOnFirewall,$seq)
    {
    	$ip = (string)$ip;
    	if (!$ip)
    		throw new BadMethodCallException('Parameter $domain is missing.');
    
    	if (!$ipOnFirewall)
    		throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
    	$ipOnFirewall = (string)$ipOnFirewall;
    
    	try {
    		$r = $this->get('ip/' . urlencode($ip) . '/firewall/'.$ipOnFirewall.'/rule/'.$seq)->send();
    	} catch (\Exception $e) {
    		throw new ServerException($e->getMessage(), $e->getCode(), $e);
    	}
		return json_decode($r->getBody(true));
    }
    
    public function setFirewallRuleDelete($ip,$ipOnFirewall,$seq)
    {
    	$ip = (string)$ip;
    	if (!$ip)
    		throw new BadMethodCallException('Parameter $domain is missing.');
    
    	if (!$ipOnFirewall)
    		throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
    	$ipOnFirewall = (string)$ipOnFirewall;
    
    	try {
    		$r = $this->delete('ip/' . urlencode($ip) . '/firewall/'.$ipOnFirewall.'/rule/'.$seq)->send();
    	} catch (\Exception $e) {
    		throw new ServerException($e->getMessage(), $e->getCode(), $e);
    	}
		return json_decode($r->getBody(true));
    }
    
    
    public function setFirewallRule($ip,$ipOnFirewall,$action,$destinationPort,
    		$protocol,$sequence,$source,$sourcePort,$fragments,$tcpOption)
    {
    	if (!$ip)
    		throw new BadMethodCallException('Parameter $ip is missing.');
    	$ip = (string)$ip;
    
    	if (!$ipOnFirewall)
    		throw new BadMethodCallException('Parameter $ipOnFirewall is missing.');
		$ipOnFirewall = (string)$ipOnFirewall;
    
    	$payload = array('action' =>$action, 'destinationPort'=>$destinationPort, 'source'=>$source,
    					'protocol'=>$protocol,'sequence'=>$sequence,'sourcePort'=>$sourcePort, 'tcpOption'=>array('fragments'=>$fragments, 'option'=>$tcpOption));
		//die(var_dump($payload));
    	try {
    		$r = $this->post('ip/' . urlencode($ip) . '/firewall/'.$ipOnFirewall.'/rule', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
    	} catch (\Exception $e) {
    		throw new ServerException($e->getMessage(), $e->getCode(), $e);
    	}
		return json_decode($r->getBody(true));
    }
}