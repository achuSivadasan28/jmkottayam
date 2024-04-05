<?php
	$domain_val = '';
  $url = 'https://jmwell.in/offlineconsultation/demo1';
  $pieces = parse_url($url);
	return $pieces;
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    $domain_val =  $regs['domain'];
  }
?>