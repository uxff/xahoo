<?php
/**
 * money 模块
 * xuduorui@qq.com
 */
class FhmoneyModule extends CWebModule
{
	const MEMBER_POINTS_HISTORY = 'fh_member_points_history';
	
	public function init()
	{
		$this->setImport(array(
            'application.common.extensions.*',
            'application.ucentermob.api.*',
            'application.ucentermodels.*',
            'application.xahoomodels.*',
            'fhmoney.libirarys.*',
			'fhmoney.controllers.*',
			'fhmoney.models.*',
		));
	}

	public function welcome() 
	{
		echo "welcome to ".__CLASS__."\n";
		return false;
	}

    /*
        @param @member_id
        @param @money
    */
    public function dispatchMoneyToMember($member_id, $money, $remark) {
        $ret = false;
        $trans = Yii::app()->db->beginTransaction();
        try {

            if ($money*1.00 == 0) {
                throw new CException('money cannot be zero');
            }
            if (empty($remark)) {
                $remark = '奖励';
            }

            $memberInfo = MemberTotalModel::model()->find('member_id=:member_id', array(':member_id'=>$member_id));
            if (!$memberInfo) {
                throw new CException('no MemberTotalModel');
            }

            // 判断上下限
            list($gainMin, $gainMax) = $this->getMoneyGainCeilling($member_id);
            if ($memberInfo->money_gain + $money > $gainMax) {
                throw new CException('cannot gain enough money');
            }

            $memberInfo->money_total   += $money;
            $memberInfo->money_gain    += $money;
            if (!$memberInfo->save()) {
                throw new CException($memberInfo->lastError());
            }

            // 个人财富记录
            $moneyHistory = new FhMemberMoneyHistoryModel;
            $moneyHistory->member_id    = $member_id;
            $moneyHistory->money        = $money;
            $moneyHistory->type         = FhMemberMoneyHistoryModel::TYPE_REWARD;
            $moneyHistory->remark       = $remark;
            $moneyHistory->create_time  = date('Y-m-d H:i:s', time());
            if (!$moneyHistory->save()) {
                throw new CException($moneyHistory->lastError());
            }

            // 提交
            $trans->commit();
            Yii::log('dispatch success!'.' mid='.$member_id.' money='.$money.' remark='.$remark.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            $ret = $moneyHistory->id;
        } catch (CException $e) {
            Yii::log('dispatch error:'.$e->getMessage().' mid='.$member_id.' remark='.$remark.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            $trans->rollback();
        }

        return $ret;
    }
    /*
        获取上下限
        @return array(min, max)
    */
    public function getMoneyGainCeilling($member_id) {
        $model = FhMemberHaibaoModel::model()->find('member_id=:mid', ['mid'=>$member_id]);
        if ($model) {
            return array($model->withdraw_min, $model->withdraw_max);
        }
        $model = FhPosterModel::model()->getPosterApi();
        if ($model) {
            return array($model->lowest_withdraw_sum, $model->highest_withdraw_sum);
        }
    }
}
