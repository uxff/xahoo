<?php
/**
 * 常用公共方法类
 *
 * @author liutao@fangfull.com
 * @date 2014/11/11 09:53:50
 */

class AresApiUtil extends AresUtil {

	/**
	 * generate app key
	 *
	 */
	public static function generateAppKey($app_id='', $length=8) {
 		$app_key = '';
 	
		$chars = 'ABCDEFGHIJKMNOPQRSTUVWXYZ0123456789';
 		$max = strlen($chars) - 1;
		//
		mt_srand((double)microtime() * 1000000);
		//
		for($i = 0; $i < $length; $i++) {
			$app_key .= $chars[mt_rand(0, $max)];
		}

 		return $app_key;
	}

	/**
	 * generate app secret
	 *
	 */
	public static function generateAppSecret($app_id='', $length=16) {
		$app_secret = '';
		
		/**
		 * STEP_1: 私钥先加上16位app_id的md5密文
		 */
		$app_secret .= substr( md5($app_id), 8, 16 );

		/**
		 * STEP_2: 在加上16为随机字母数字串
		 */
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
 		$max = strlen($chars) - 1;
		//播下一个更好的随机数发生器种子	
		mt_srand((double)microtime() * 1000000);
		//
		for($i = 0; $i < $length; $i++) {
  			$app_secret .= $chars[mt_rand(0, $max)];
		}

 		return $app_secret;
	}


	/**
	 * 对url参数进行签名(md5)
	 * 签名规则: 所有url参数按字典排序后key-value以,连接，最后加上签名密钥(app_secrect)，然后对生成的String进行md5加密；转为大写
	 * 
	 * @param array  $params         待签名参数
	 * @param array  $excludeFields  不参与签名字段
	 * @param string $secrect        签名密钥
	 */
	public static function signURLParameters($params, $excludeFields=array(), $secrect='') {		
		$params_string = '';
		
		//按key字典排序
		ksort($params);
		//以keyvalue的形式将参数拼成url参数字符串,keys不参与签名
		foreach ($params as $key => $value) {
			// 跳过不参与签名的key
			if (!empty($excludeFields) && in_array($key, $excludeFields)) {
				continue;
			}
			$params_string .= $key.$value;
		}
		//url参数字符串最后要加入appSecrect
		if (!empty($secrect)) {
			$params_string .= $secrect;
		}
		//将md5后的字符串字母转为大写
		$signed_params_string = strtoupper(md5($params_string));
		
		//echo '<BR>';
		//print_r( $params );
		//print_r($params_string.PHP_EOL);
		//print_r($secrect.PHP_EOL);
		//print_r($signed_params_string.PHP_EOL);
		//print_r($params['sign'].PHP_EOL);
		
		$result = array(
			'params_string' => $params_string,
			'app_secrect' => $secrect,
			'signed_params_string' => $signed_params_string,
		);
		// add log
        AresLogManager::log_bi(array('logKey' => '[API]['.__METHOD__.']', 'desc' => 'get signature', 'parameters' => $params, 'response' => $result));
		
		return $signed_params_string;
	}



}