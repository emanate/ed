<?php// Encryption.php//// routines to encrypt data based on a routine developed// by LoyaltyOne IT dept.//// written by: David Fudge [rkstar@mac.com]// created on: May 17, 2012// last modified: May 22, 2012////class Encryption{	// these values were provided by IT @ LoyaltyOne	// NOTE: see init() function	private static $key;	private static $iv;	public static function encrypt( $plaintext_string )	{		// init encryption		if( !($td = self::init()) ) { return null; }		// add padding		$block	 = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);		$padding = $block - (strlen($plaintext_string) % $block);		$plaintext_string = $plaintext_string.str_repeat(chr($padding), $padding);		// encrypt		$encrypted_string = trim( base64_encode( mcrypt_generic($td, $plaintext_string) ) );		self::gc($td);		return trim($encrypted_string);	}	public static function decrypt( $encrypted_string )	{		// init encryption		if( !($td = self::init()) ) { return null; }		// un-binary it		$decoded	= base64_decode($encrypted_string);		$decrypted	= mdecrypt_generic($td, $decoded);		$padding	= ord($decrypted{strlen($decrypted)-1});		// sanity		if( $padding > strlen($decrypted) ) { return null; }		if( strspn($decrypted, chr($padding), strlen($decrypted) - $padding) != $padding ) { return null; }		$plaintext_string = substr($decrypted, 0, (-1 * $padding));		self::gc($td);		return trim($plaintext_string);	}	private static function init()	{		// we need to do this here because we can't have a function call		// in our var definition above.		self::$key	= "hotgat3s";		self::$iv	= pack('C8', 0x8E, 0x12, 0x39, 0x9C, 0x07, 0x72, 0x6F, 0x5A);		// open the cipher and get a resource descriptor back		if( !($td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_CBC, "")) ) { return null; }		// init encryption		mcrypt_generic_init($td, self::$key, self::$iv);		return $td;	}	private static function gc( $td )	{		if( is_null($td) ) { return; }		mcrypt_generic_deinit($td);		mcrypt_module_close($td);	}}?>