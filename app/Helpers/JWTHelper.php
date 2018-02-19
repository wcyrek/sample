<?php

namespace App\Helpers;

use App\User, App\Helpers\JWTSigners\Sha256SignerClass;

/**
 *	This Helper class will handle creating new JWT, verifying integrity of JWT, and extracting user based on claims
 *	Class cannot store any token data because it is a singleton bound via ServiceProvider, but it will store some settings for easy access
 *
 */
class JWTHelper {
 
	/**
     * Holds the instance of signer
     *
     * @var class
     */
	protected $signer;

	/**
     * Store the secret key used in signing
     *
     * @var string
     */
	private $secret;

	/**
     * Store the token expiration; default 3600 seconds (1 hour)
     *
     * @var integer
     */
	private $expiry;

	public function __construct($secret, $expiry) {

		//bind this in constructor instead of service provider since we are only using one, and it is not reused anywhere else
		$this->signer = new Sha256SignerClass;
		$this->secret = $secret;
		$this->expiry = $expiry;
	}

	/**
	 * Will extract User from the token, if the token is valid and has the proper claim
	 * @param 	string $token
	 * @return 	mixed
	 */
	public function extractUser($token)
	{

		if ($this->verify($token)) 
		{
			$claims = $this->claims($token);
			if ($claims) {	
				$user = User::find($claims['id']);
				return $user;
			}		
		}
		return false;
	}

	/**
	 * This will create a token for given user, stuff it with proper claims, and return said token
	 * @param 	App\User $user
	 * @return 	string
	 */
	public function createToken($user)
	{
		$claims = [];
		$claims['expiry'] = time() + $this->expiry;
		$claims['id'] = $user['id'];
		return $this->signer->sign($claims,$this->secret);
	}

	/**
	 * This will verify if the token is valid or not;
	 * @param 	string $token
	 * @return 	boolean
	 */
	public function verify($token)
	{	

		$header = $this->headers($token);
		//reject if header is not what we expect; we should only get JWT header and only algo suported in this implementation and at this time is HMAC-SHA256
		if(!isset($header['alg']) || !isset($header['typ']) || $header['alg'] !== 'HS256' || $header['typ'] !== 'JWT')
			return false;

		$claims = $this->claims($token);
		$time = time();

		//reject if expired
		if (!isset($claims['expiry']) || $claims['expiry'] < $time)
			return false;
		
		return $this->signer->verify($token, $this->secret);
	}

	/**
	 * Grab claims from the token
	 * @param 	$token
	 * @return 	mixed
	 */
	function claims($token)
	{
		$claims = json_decode(base64_decode(strtr(explode(".",$token)[1], '~_', '+/')), TRUE);
		if (json_last_error() === JSON_ERROR_NONE)
			return $claims;
		return false;
	}

	/**
	 * Grab headers from the token
	 * @param 	$token
	 * @return 	mixed
	 */
	function headers($token)
	{
		$header = json_decode(base64_decode(strtr(explode(".",$token)[0], '~_', '+/')), TRUE);
		if (json_last_error() === JSON_ERROR_NONE)
			return $header;
		return false;
	}

	/**
	 * Splices the token for demo purposes
	 * @param 	$token
	 * @return 	mixed
	 */
	function disect($token)
	{
		$pieces = explode(".",$token);
		if (is_array($pieces) && count($pieces) === 3)
		{
			return [
				"header" 	=> [$pieces[0], base64_decode($pieces[0])],
				"payload"	=> [$pieces[1], base64_decode($pieces[1])],
				"signature" => [$pieces[2], 'HMACSHA256(base64UrlEncode(header) + "." + base64UrlEncode(payload), secret)']
			];
		}
		//just placeholder values so I can sue one view for whole restricted area
		return ['header'=>[1,2],'payload'=>[1,2],'signature'=>[1,2]];
			
	}

}