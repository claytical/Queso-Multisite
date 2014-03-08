<?php
/**
 * @author Daniel Schniepp < http://daniel-schniepp.com/ >
 * @copyright 2012 daniel-schniepp.com
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 * @package Vimeo Advanced API (Laravel Bundle)
 * @version 1.0 - 2012-08-22
 */

Autoloader::map(array(
	'phpVimeo' => Bundle::path('vimeo-api').'vimeo/vimeo.php',
));

Laravel\IoC::singleton('vimeo-api', function()
{
    $consumer_key 		= Config::get('vimeo.consumer_key');
    $consumer_secret	= Config::get('vimeo.consumer_secret');
    $access_token		= Config::get('vimeo.access_token');
    $access_token_secret= Config::get('vimeo.access_token_secret');            

	return new phpVimeo($consumer_key, $consumer_secret, $access_token, $access_token_secret);
});