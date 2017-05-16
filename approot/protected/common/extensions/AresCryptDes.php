<?php

class AresCryptDes {

    private static $_instance = NULL;
    
    private $key;// 秘钥
    private $iv;//随机种子
    private $iv_size;//种子长度
    
    public function __construct() { 
        $this->key = "972a624c";
    
        $this->iv = "972a624c";//初始>化向量
        //rijndael-128,ecb,2
    
    }
    
    /**
     * @return JoDES
     */
    public static function share() {
        if (is_null(self::$_instance)) {
            self::$_instance = new AresCryptDes();
        }
        return self::$_instance;
    }

    /**
     * 加密
     * @param string $str 要处理的字符串
     * @param string $key 加密Key，为8个字节长度
     * @return string
     */
    public function encrypt($str) {
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $str = $this->pkcs5Pad($str, $size);
        //$aaa = mcrypt_cbc(MCRYPT_DES, $key, $str, MCRYPT_ENCRYPT, $key);
        $aaa = mcrypt_encrypt(MCRYPT_DES, $this->key, $str, MCRYPT_MODE_CBC, $this->key);
        
        $ret = base64_encode($aaa);
        return $ret;
    }

    /**
     * 解密
     * @param string $str 要处理的字符串
     * @param string $key 解密Key，为8个字节长度
     * @return string
     */
    public function decrypt($str) {
        $strBin = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $this->key, $strBin, MCRYPT_MODE_CBC, $this->key);
        $str = $this->pkcs5Unpad($str);
        return $str;
    }

    function hex2bin($hexData) {
        $binData = "";
        for ($i = 0; $i < strlen($hexData); $i += 2) {
            $binData .= chr(hexdec(substr($hexData, $i, 2)));
        }
        return $binData;
    }

    function pkcs5Pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function pkcs5Unpad($text) {
        $pad = ord($text {strlen($text) - 1});
        if ($pad > strlen($text))
            return false;

        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;

        return substr($text, 0, - 1 * $pad);
    }

}

/**
 * Ares des加密解密 class
 *
 * @author liutao@lightinthebox.com
 * @date 2012/07/20 10:53:50
 */
/*
class AresCryptDes
{
	private $key;// 秘钥
	private $iv;//随机种子
	private $iv_size;//种子长度

	public function __construct() {

		//暂时写死秘钥

		$key = '972a624cd650267ea7bd4c5a68b2033604cb47ebc801e1efa59df6f453ba0b20' ;


		$this->key = $this->get_key($key);

		$this->iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_ECB),MCRYPT_RAND);//初始>化向量
		//rijndael-128,ecb,2

	}


	public function encrypt($str) {

		if(trim($str)!=""){
			$encrypt_str = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key,
			$str,MCRYPT_MODE_ECB, $this->iv);
			$string_base64 = base64_encode($encrypt_str);

			return $string_base64 ;
		}else{
			return $str;
		}

	}

	public function decrypt($str) {

		$decode_64_string = base64_decode($str);
		$decode_str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key,$decode_64_string, MCRYPT_MODE_ECB, $this->iv);

		//如果解密不成功返回空字符串
		if($decode_str !== false){
			return trim($decode_str);
		}else{
			return "";
		}

	}

	private function get_key($key){
		return pack('H*', $key);
	}

}
*/
