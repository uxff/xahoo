<?php

class EventFactory {

    public function __construct() {
        
    }
    
    // 生产类
    static public function createEvent($event_key, $event_class = null) {
        //$event_obj = new EventTest;
        if (class_exists($event_class)) {
            $event_obj = new $event_class;
        }
        $eventClassMap = self::getEventClassMap();
        if (isset($eventClassMap[$event_key]) && class_exists($eventClassMap[$event_key])) {
            $event_obj = new $eventClassMap[$event_key];
        }
        return $event_obj;
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
