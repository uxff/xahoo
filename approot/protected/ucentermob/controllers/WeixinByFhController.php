<?php
class WeixinByFhController extends Controller {

        public $token = '';
		public $postArr = array();

        public function actionIndex() {
                if (isset($_GET['echostr'])) {
						$this->token = 'fanghu';
                        $echoStr = $_GET["echostr"];
                        if ($this->checkSignature()) {
                                echo $echoStr;
                                exit;
                        }
                } else {
                        $this->responseMsg();
                }
                return FALSE;
        }

        public function receiveEvent() {
                switch ($this->postArr['event']) {
                        case "subscribe":
                                $this->follow();
                                break;
                }
        }

        public function responseMsg() {
                $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
                if (!empty($postStr)) {
                        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
						$postArr = array('fromusername' => $postObj->FromUserName, 'tousername' => $postObj->ToUserName,'event' => $postObj->Event);
                        $this->postArr = $postArr;
						$RX_TYPE = trim($postObj->MsgType);
                        switch ($RX_TYPE) {
                                case "event":
                                        $result = $this->receiveEvent();
                                        breadk;
                        }
                        echo $result;
                } else {
                        echo "";
                        exit;
                }
        }

        public function checkSignature() {
                if (empty($this->token)) {
                        throw new Exception('TOKEN is not defined!');
                }

                $signature = $_GET["signature"];
                $timestamp = $_GET["timestamp"];
                $nonce = $_GET["nonce"];

                $token = $this->token;
                $tmpArr = array($token, $timestamp, $nonce);
                sort($tmpArr, SORT_STRING);
                $tmpStr = implode($tmpArr);
                $tmpStr = sha1($tmpStr);

                if ($tmpStr == $signature) {
                        return true;
                } else {
                        return false;
                }
        }


		//根据关注者的微信号查有没有这个会员，如果有返回会员id并给其加积分，如果没有不做加积分处理
        public function follow() {
                $openid = $this->postArr['fromusername'];
				$ucThirdPartLogin = UcThirdPartLogin::model()->find("uid=:openid", array('openid' => $openid));
                if ($ucThirdPartLogin) {
                        $member_id = $ucThirdPartLogin->member_id;
						//file_put_contents('12.txt',$member_id);
                        $objpointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => 'fh_weixin'));
                        if ($objpointRule) {
                                $rule_id = $objpointRule->rule_id;
                                $total = UcMemberPointLog::model()->count("member_id={$member_id} and rule_id={$rule_id}");
                                if ($total <= 0) {
                                        $this->addPoint($member_id, 'fh_weixin');
                                }
                        }
                }
        }
}
