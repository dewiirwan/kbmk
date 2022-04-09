<?php
/**
* @author   Natan Felles <natanfelles@gmail.com>
*/
defined('BASEPATH') OR exit('No direct script access allowed');

function postapi($url=null,$postfield=null)
{
	$field= http_build_query($postfield);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS,
	// "secret=6Lf2NRYUAAAAABmmP2QB5JnjOEJFWXbCdyV1XvXM&response=".$key."");

	// in real life you should use something like:
	curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36");

	curl_setopt($ch, CURLOPT_USERPWD, "test:teste");

	curl_setopt($ch, CURLOPT_POSTFIELDS,$field);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);
	// do anything you want with your response
	return json_decode($server_output);
}
function getapi($url=null,$auth=null)
{

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36");
	curl_setopt($ch, CURLOPT_USERPWD, "test:test");
	// curl_setopt($ch, CURLOPT_POSTFIELDS,
	// "secret=6Lf2NRYUAAAAABmmP2QB5JnjOEJFWXbCdyV1XvXM&response=".$key."");

	// in real life you should use something like:
	// curl_setopt($ch, CURLOPT_POSTFIELDS,$field);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);
	// do anything you want with your response
	return json_decode($server_output);
}