<?php
/**
 * task 模块
 * xuduorui@qq.com
 */
class TaskTypeFactory
{
    /*
        生产 TaskTypeAbs 的子类
        @param $taskType
    */
	static public function create($taskType)
	{
        $class = null;
        switch ($taskType) {
            case MemberTaskModel::TYPE_OTHER:
            case MemberTaskModel::TYPE_SHARE_ACTIVITY:
            case MemberTaskModel::TYPE_SHARE_PROJECT:
            case MemberTaskModel::TYPE_SHARE_ARTICLE:
                $class = new TaskTypeShare;
                break;
            case MemberTaskModel::TYPE_FILLAVATAR:
                $class = new TaskTypeFillAvatar;
                break;
            case MemberTaskModel::TYPE_INVITE:
                $class = new TaskTypeInvite;
                break;
            default:
                break;
        }
        return $class;
	}
    

}
