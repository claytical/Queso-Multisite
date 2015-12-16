<?php

class Filepicker {

	public static function metadata($url) {
		if ($url) {
			$metadata = $url . "/metadata";
			$contents = @file_get_contents($metadata);
			if ($contents === FALSE) {
				return NULL;
			}
			return json_decode($contents);
			}
		else {
			return NULL;
		}
	}
}