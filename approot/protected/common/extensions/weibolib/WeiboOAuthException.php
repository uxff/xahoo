<?php
/*
 * If the class OAuthException has not been declared, extend the Exception class.
 * This is to allow OAuth without the PECL OAuth library
 * 
 * @ignore
 */

namespace common\extensions\weiboauth;

class WeiboOAuthException extends \Exception {
    // pass
}
