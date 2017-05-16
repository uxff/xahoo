<?php

class OBJTool extends CApplicationComponent {

        /**
         * 将Yii模型对象转为数组(多维)
         * 
         * @param  object $models          [description]
         * @param  array $filterAttributes [description]
         * @return array                   [description]
         *
         * @todo 格式化
         */
        public static function convertModelToArray($models, array $filterAttributes = null) {
                if (!$models) {
                        return null;
                }
                if (is_array($models))
                        $arrayMode = TRUE;

                else {

                        $models = array($models);

                        $arrayMode = FALSE;
                }

                $result = array();

                foreach ($models as $model) {

                        $attributes = $model->getAttributes();

                        if (isset($filterAttributes) && is_array($filterAttributes)) {

                                foreach ($filterAttributes as $key => $value) {

                                        if (strtolower($key) == strtolower($model->tableName()) && strpos($value, '*') === FALSE) {

                                                $value = str_replace(' ', '', $value);

                                                $arrColumn = explode(",", $value);

                                                foreach ($attributes as $key => $value)
                                                        if (!in_array($key, $arrColumn))
                                                                unset($attributes[$key]);
                                        }
                                }
                        }

                        $relations = array();

                        foreach ($model->relations() as $key => $related) {

                                if ($model->hasRelated($key)) {

                                        if (($model->$key instanceof CModel) || is_array($model->$key)) {

                                                $relations[$key] = self::convertModelToArray($model->$key, $filterAttributes);
                                        } else {

                                                $relations[$key] = $model->$key;
                                        }
                                }
                        }

                        $all = array_merge($attributes, $relations);

                        if ($arrayMode)
                                array_push($result, $all);
                        else
                                $result = $all;
                }

                return $result;
        }

        /**
         * 创建父节点树形数组 
         * 参数 $ar 数组，邻接列表方式组织的数据 
         * $id 数组中作为主键的下标或关联键名 
         * $pid 数组中作为父键的下标或关联键名 
         * 返回 多维数组
         * by www.jbxue.com
         * */
        public static function find_parent($ar, $id = 'id', $pid = 'pid') {
                foreach ($ar as $v)
                        $t [$v [$id]] = $v;
                foreach ($t as $k => $item) {
                        if ($item [$pid]) {
                                if (!isset($t [$item [$pid]] ['parent'] [$item [$pid]]))
                                        $t [$item [$id]] ['parent'] [$item [$pid]] = & $t [$item [$pid]];
                        }
                }
                return $t;
        }

        /**
         * * 创建子节点树形数组 * 参数 * 
         * $ar 数组，邻接列表方式组织的数据 
         * $id 数组中作为主键的下标或关联键名 
         * $pid
         * 数组中作为父键的下标或关联键名 * 返回 多维数组 *
         */
        public static function find_child($ar, $id = 'id', $pid = 'pid') {
                foreach ($ar as $v) {
                        $t [$v [$id]] = $v;
                }
                foreach ($t as $k => $item) {
                        if ($item [$pid]) {
                                $t [$item [$pid]] ['child'] [$item [$id]] = &$t [$k];
                        }
                }
                foreach ($t as $key => $value) {
                        if ($value['pid'] != 0) {
                                unset($t[$key]);
                        }
                }
                return $t;
        }

        /**
         * 获取指定尺寸图片
         * @param type $url 图片URL
         * @param type $identify 暂时无用 用来确认替换操作的字段
         * @param type $target 替换的目标尺寸 如：640x320
         * @return type
         */
        public static function changeImageSize($url, $identify = '', $target = '') {
                if (!$target) {
                        return $url;
                }
                if ($identify) {
                        $new = str_replace($identify, $target, $url);
                        return $new;
                }
                $xPos = stripos($url, "x");
                $prex = substr($url, $xPos - 2, 2);
                $suffix = substr($url, $xPos + 1, 2);
                $old = $prex . "x" . $suffix;
                $new = str_replace($old, $target, $url);
                return $new;
        }

        /**
         * 来自discuz的可逆加密函数
         * @param type $string
         * @param type $operation ENCODE|DECODE
         * @param type $key
         * @param type $expiry
         * @return string
         */
        public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
                $ckey_length = 4;
                $key = md5($key != '' ? $key : getglobal('authkey'));
                $keya = md5(substr($key, 0, 16));
                $keyb = md5(substr($key, 16, 16));
                $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

                $cryptkey = $keya . md5($keya . $keyc);
                $key_length = strlen($cryptkey);

                $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
                $string_length = strlen($string);

                $result = '';
                $box = range(0, 255);

                $rndkey = array();
                for ($i = 0; $i <= 255; $i++) {
                        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
                }

                for ($j = $i = 0; $i < 256; $i++) {
                        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
                        $tmp = $box[$i];
                        $box[$i] = $box[$j];
                        $box[$j] = $tmp;
                }

                for ($a = $j = $i = 0; $i < $string_length; $i++) {
                        $a = ($a + 1) % 256;
                        $j = ($j + $box[$a]) % 256;
                        $tmp = $box[$a];
                        $box[$a] = $box[$j];
                        $box[$j] = $tmp;
                        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
                }

                if ($operation == 'DECODE') {
                        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                                return substr($result, 26);
                        } else {
                                return '';
                        }
                } else {
                        return $keyc . str_replace('=', '', base64_encode($result));
                }
        }

        public static function is_weixin() {
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
                        return true;
                }
                return false;
        }

    static public function objToArray($stdclassobject)
    {
        $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
     
        foreach ($_array as $key => $value) {
            $value = (is_array($value) || is_object($value)) ? self::objToArray($value) : $value;
            $array[$key] = $value;
        }
     
        return $array;
    }
}

function setglobal($key, $value, $group = null) {
        global $_G;
        $key = explode('/', $group === null ? $key : $group . '/' . $key);
        $p = &$_G;
        foreach ($key as $k) {
                if (!isset($p[$k]) || !is_array($p[$k])) {
                        $p[$k] = array();
                }
                $p = &$p[$k];
        }
        $p = $value;
        return true;
}

function getglobal($key, $group = null) {
        global $_G;
        $key = explode('/', $group === null ? $key : $group . '/' . $key);
        $v = &$_G;
        foreach ($key as $k) {
                if (!isset($v[$k])) {
                        return null;
                }
                $v = &$v[$k];
        }
        return $v;
}

/**
 * Returns the url query as associative array 
 * 
 * @param    string    query 
 * @return    array    params 
 */
function convertUrlQuery($query) {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
                $item = explode('=', $param);
                $params[$item[0]] = $item[1];
        }

        return $params;
}

?>