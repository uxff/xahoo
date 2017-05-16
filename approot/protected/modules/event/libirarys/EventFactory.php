<?php

class EventFactory {

    public function __construct() {
        
    }
    
    // 生产类
    static public function createEvent($event_key, $event_class) {
        $event_obj = new EventTest;
        if (class_exists($event_class)) {
            $event_obj = new $event_class;
        }
        return $event_obj;
    }
}
