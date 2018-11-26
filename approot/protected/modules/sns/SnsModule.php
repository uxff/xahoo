<?php
/**
 * Sns 模块
 * author: coderxx@qq.com
 * 描述  : 主要涉及第三方登录时账号创建和管理
 */
class SnsModule extends CWebModule
{
	public function init() {
		$this->setImport(array(
            'application.common.extensions.*',
            'application.common.extensions.wechatlib.*',
            'application.ucentermob.api.*',
            'application.ucentermodels.*',
            'application.xahoomodels.*',
            'sns.libirarys.*',
			'sns.controllers.*',
			'sns.models.*',
		));
        Yii::app()->getModule('points');
	}

    /*
        获取sns登录账号
    */
    public function getSnsModel($snsid, $appid, $plat) {
        $snsModel = UcMemberBindSns::model()->find('sns_source=:source and sns_appid=:appid and sns_id=:oid', [
                ':oid'      =>$snsid,
                ':appid'    =>$appid,
                ':source'   =>$plat,
            ]);

        return $snsModel;
    }
    /*
        生成sns账户
            创建uc_member_bind_sns记录和uc_member记录
    */
    public function makeSnsAccount($snsid, $appid, $plat, $memberFrom) {
        $ret = false;
        $snsModel = $this->getSnsModel($snsid, $appid, $plat);
        if (!$snsModel) {
            $snsModel = new UcMemberBindSns;
            $snsModel->sns_id       = $snsid;
            $snsModel->sns_appid    = $appid;
            $snsModel->sns_source   = $plat;
            $snsModel->create_time  = date('Y-m-d H:i:s');
            try {
                if (!$snsModel->save()) {
                    throw new CException($snsModel->lastError());
                }
            } catch (CException $e) {
                Yii::log('save sns error:'.$e->getMessage().' ', 'error', __METHOD__);
                $ret = false;
            }
        }
        
        $snsInfo = $this->getSnsInfo($snsid, $appid, $plat);
        if (!$snsInfo['_info']) {
            Yii::log('no sns info from third part: snsid='.$snsid.' appid='.$appid.' plat='.$plat.' '.json_encode($snsInfo).' ', 'error', __METHOD__);
            $ret = false;
        }
        
        if ($snsModel->member_id) {
            //return true;
            $ucMember = UcMember::model()->findByPk($snsModel->member_id);
            if ($ucMember) {
                $ret = $ucMember;
            }
        } else {
            $ucMember = new UcMember;
            $ucMember->member_from = $memberFrom;
            $ucMember->create_time = $ucMember->last_modified = date('Y-m-d H:i:s');
            $ucMember->member_fullname = $snsInfo['nickname'];//$snsid;
            $ucMember->member_mobile = '';
            try {
                if (!$ucMember->save()) {
                    throw new CException($ucMember->lastError());
                }
                $snsModel->member_id = $ucMember->member_id;
                if (!$snsModel->save()) {
                    throw new CException($snsModel->lastError());
                }

                $ret = $ucMember;
            } catch (CException $e) {
                Yii::log('save ucMember error:'.$e->getMessage().' ', 'error', __METHOD__);
                $ret = false;
            }
        }
        
        return $ucMember;
    }
    public function getSnsInfo($snsid, $appid, $plat) {
        $info = [
            'acct'  => $snsid,
            '_info' => null,
        ];
        switch ($plat) {
            case UcMemberBindSns::SNS_SOURCE_WECHAT:
                $theInfo = $this->getWechatSnsInfo($snsid, $appid);
                if ($theInfo) {
                    $info['nickname']  = $theInfo['nickname'];
                    $info['_info']     = $theInfo;
                }
                break;
            case UcMemberBindSns::SNS_SOURCE_WEIBO:
                break;
            default:
                break;
        }
        return $info;
    }
    public function getWechatSnsInfo($snsid, $appid) {
        $info = null;
        $mpModel = FhPosterAccountsModel::model()->find('appid=:appid',array(':appid'=>$appid));
        if (!empty($mpModel)) {
            $wechatOptions = $mpModel->toWechatOption();
            $weObj = new Wechat($wechatOptions);
            $info = $weObj->getUserInfo($snsid);
        }
        return $info;
    }
    /*
        合并账户
            将tmp_id上的信息合并到master_id上 以后使用master_id,放弃tmp_id
            1 fh_member_total
            2 fh_member_money_history
            3 fh_member_points_history
            4 fh_money_withdraw
            5 fh_member_fans
            6 fh_member_haibao
            7 fh_member_haibao_log
    */
    public function combineAccount($master_id, $tmp_id, $openid) {
        if (empty($master_id) || empty($tmp_id)) {
            Yii::log('empty param'.' ', 'error', __METHOD__);
            return false;
        }

        $tmpModel = UcMember::model()->findByPk($tmp_id);
        if (empty($tmpModel)) {
            Yii::log('no model for tmp_id:'.$tmp_id.' ', 'error', __METHOD__);
            return false;
        }
        if ($tmpModel->status == UcMember::STATUS_DELETED) {
            Yii::log('already mark deleted tmp_id:'.$tmp_id.' ', 'error', __METHOD__);
            return false;
        }

        // 基本余额信息
        $masterTotal = Yii::app()->getModule('points')->getMemberTotalModel($master_id);
        $tmpTotal = Yii::app()->getModule('points')->getMemberTotalModel($tmp_id);
        try {
            $masterTotal->points_total      += $tmpTotal->points_total;
            $masterTotal->points_gain       += $tmpTotal->points_gain;
            $masterTotal->points_consume    += $tmpTotal->points_consume;
            //$masterTotal->level           += $tmpTotal->level;
            $masterTotal->money_total       += $tmpTotal->money_total;
            $masterTotal->money_gain        += $tmpTotal->money_gain;
            $masterTotal->money_withdraw    += $tmpTotal->money_withdraw;
            $masterTotal->login_times       += $tmpTotal->login_times;
            if (!$masterTotal->save()) {
                throw new CException($masterTotal->lastError());
            }
        } catch (CException $e) {
            Yii::log('combile total error:'.$e->getMessage().' ', 'error', __METHOD__);
        }

        // 交易记录
        $tmpMoneyHistory = FhMemberMoneyHistoryModel::model()->findAll('member_id=:mid', [':mid'=>$tmp_id]);
        try {
            foreach ($tmpMoneyHistory as $his) {
                $his->isNewRecord = true;
                //去掉自动更新时间的行为
                $his->detachBehavior('CTimestampBehavior');
                $his->member_id = $master_id;
                $his->id = null;
                if (!$his->save()) {
                    throw new CException($his->lastError());
                }
            }
        } catch (CException $e) {
            Yii::log('combile money history error:'.$e->getMessage().' ', 'error', __METHOD__);
        }

        // 交易记录
        $tmpPointsHistory = MemberPointsHistoryModel::model()->findAll('member_id=:mid', [':mid'=>$tmp_id]);
        try {
            foreach ($tmpPointsHistory as $his) {
                $his->isNewRecord = true;
                $his->detachBehavior('CTimestampBehavior');
                $his->member_id = $master_id;
                $his->id = null;
                if (!$his->insert()) {
                    throw new CException($his->lastError());
                }
            }
        } catch (CException $e) {
            Yii::log('combile points history error:'.$e->getMessage().' ', 'error', __METHOD__);
        }

        // 标记为已经同步过的用户
        try {
            UcMember::model()->updateByPk($tmp_id, ['status'=>UcMember::STATUS_DELETED]);
        } catch (CException $e) {
            Yii::log('mark tmp_id('.$tmp_id.') deleted error:'.$e->getMessage().' ', 'error', __METHOD__);
        }

        Yii::log('combile account done'.' ', 'warning', __METHOD__);
        return true;
    }
    public function combineFans($master_id, $tmp_id, $openid) {
        if (empty($master_id) || empty($tmp_id)) {
            Yii::log('empty param'.' ', 'error', __METHOD__);
            return false;
        }
        // 粉丝关系
        try {
            $ret = FhMemberFansModel::model()->updateAll(['member_id'=>$master_id], 'member_id=:mid', [':mid'=>$tmp_id]);
            Yii::log('up member_id (master_id='.$master_id.',tmp_id='.$tmp_id.') ret='.$ret.' ', 'warning', __METHOD__);
            $ret = FhMemberFansModel::model()->updateAll(['fans_id'=>$master_id], 'fans_openid=:openid', [':openid'=>$openid]);
            Yii::log('up fans_id (master_id='.$master_id.',fans_openid='.$openid.') ret='.$ret.' ', 'warning', __METHOD__);

            $masterModel = UcMember::model()->findByPk($master_id);
            $ret = FhMemberHaibaoModel::model()->updateAll(['member_id'=>$master_id, 'member_mobile'=>$masterModel->member_mobile], 'openid=:openid', [':openid'=>$openid]);
            Yii::log('up haobai member_id (master_id='.$master_id.',fans_openid='.$openid.') ret='.$ret.' ', 'warning', __METHOD__);

            return true;
        } catch (CException $e) {
            Yii::log('combile fans error:'.$e->getMessage().' ', 'error', __METHOD__);
        }
    }
    public function stasticSns($appid) {
        $ret = Yii::app()->UCenterDb->createCommand()
            ->select('count(bind_id) cnt')
            ->from('uc_member_bind_sns')
            ->where('sns_appid=:appid', [':appid'=>$appid])
            ->queryAll();
        return $ret[0];
    }
}
