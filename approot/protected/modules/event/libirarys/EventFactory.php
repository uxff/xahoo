<?php

class EventFactory {

    public function __construct() {
        
    }
    
    // 生产类
    static public function createEvent($eventKey) {
        $eventClassMap = self::getEventClassMap();
        if (isset($eventClassMap[$eventKey]) && class_exists($eventClassMap[$eventKey])) {
            $eventObj = new $eventClassMap[$eventKey];
            $eventObj->model = EventTplModel::model()->find('event_key=:event_key', [':event_key'=>$eventKey]);
        }
        return $eventObj;
    }

    // 生产类
    static public function createEventByEventId($eventId) {
        $eventModel = EventTplModel::model()->findByPk($eventId);
        if ($eventModel) {
            $eventKey = $eventModel->event_key;
            $eventClassMap = self::getEventClassMap();
            if (isset($eventClassMap[$eventKey]) && class_exists($eventClassMap[$eventKey])) {
                $eventObj = new $eventClassMap[$eventKey];
                $eventObj->model = $eventModel;
            }
        }
        return $eventObj;
    }

    static public function getEventClassMap() {
        static $eventClassMap = [
            'check_in_nday'                => 'EventCheckInNday',
            'check_in'                     => 'EventCheckIn',
            'try_to_check_in_nday'         => 'EventTryToCheckInNday',
            'fill_avatar'                  => 'EventFillAvatar',
            'finish_invite_friend'         => 'EventFinishInviteFriend',
            'finish_task'                  => 'EventFinishTask',
            'level_up'                     => 'EventLevelUp',
            'points_change'                => 'EventPointsChange',
            'register_by_invite'           => 'EventRegisterByInvite',
            'register'                     => 'EventRegister',
            'share_clicked'                => 'EventShareClicked',
            'share'                        => 'EventShare',
            'event_test'                   => 'EventTest',
            'try_to_finish_invite_friend'  => 'EventTryToFinishInviteFriend',
            'try_to_finish_task'           => 'EventTryToFinishTask',
            'try_to_level_up'              => 'EventTryToLevelUp',
        ];
        return $eventClassMap;
    }
}
