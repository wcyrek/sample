<?php

namespace App\Helpers\JWTSigners;

use Config;

/**
 *	Abstract class of what a signer should look like, regardless of the algorithm used to verify
 */
abstract class SignerClass
{

	abstract public function verify($token, $secret);
	abstract public function sign($claims, $secret);

}