<?php
/**
 * Created by PhpStorm.
 * User: MemberAdministrator
 * Date: 15-1-6
 * Time: 上午10:46
 */

class MemberAdminWebUser extends CWebUser {

    public function __get($name) {
        if ($this->hasState('__MemberAdminInfo')) {
            $user = $this->getState('__MemberAdminInfo', array());
            if (isset($user[$name])) {
                return $user[$name];
            }
        }

        return parent::__get($name);
    }

    public function login($identity, $duration='') {
        $this->setState('__MemberAdminInfo', $identity->getUser());
        parent::login($identity, $duration);
    }

    public function getIsGuest() {

        //var_dump($this->getState('__id'));
        return $this->getState('__id') === null;
    }

}
