<?php

namespace App\Helpers\JWTSigners;

/**
 *	Concrete class for signing and verifying tokens using SHA256 algorithm of the HMAC function
 * 	Due to some funky stuff with base64 encode I replace the 2 unsuported characters for URLS + and /  and trim the = sign
 */
class Sha256SignerClass extends SignerClass
{
	/**
	 * Verify returns true or false if the token can be verified
	 * 
	 * @param 	string $token
	 * @param 	string $secret
	 * @return 	boolean
	 */
	public function verify($token, $secret)
	{
		$pieces = explode('.',$token);

		//verify the token is in 3 pieces
		if (!is_array($pieces) && count($pieces) !== 3)
		{
			//I'd prefer to throw an exception here, however exception handling inside middleware is very buggy in Laravel
			return false;
		}

		//verify it is signed correctly
		$verify_signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $pieces[0].'.'.$pieces[1], $secret, TRUE)), '+/', '~_'), '=');

		return $verify_signature === $pieces[2];
	}

	/**
	 * Sign will take claims and create a token and sign it using the proper algorithm
	 * 
	 * @param 	array $claims
	 * @param 	string $secret
	 * @return 	string
	 *
	 */
	public function sign($claims, $secret)
	{
		//verify the claims
		if (!is_array($claims))
		{
			//likewise, I'd rather throw an exception here
			return "";
		}

		//craft header
		$header = rtrim(strtr(base64_encode(json_encode(['alg'=>'HS256','typ'=>'JWT'])),'+/', '~_'), '=');

		//craft claims
		$payload = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '~_'), '=');

		//finally we sign the token
		$verify_signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $header.'.'.$payload, $secret, TRUE)), '+/', '~_'), '=');
		return $header.'.'.$payload.'.'.$verify_signature;
	}

}