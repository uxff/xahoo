<?php

class MemberAdminUser extends CWebUser {

        const LOGIN_USER_INFO_KEY = '__adminUser';
        const LOGIN_USER_ID_KEY = '__uid';
        const LOGIN_USER_ROLE_KEY = '__role';
        const COOKIE_LIFETIME = 432000; // 3600 * 24 * 5day;

        public function __get($name) {
                if ($this->hasState(self::LOGIN_USER_INFO_KEY)) {
                        $loginData = $this->getState(self::LOGIN_USER_INFO_KEY, array());
                        if (isset($loginData[$name])) {
                                return $loginData[$name];
                        }
                }
                return parent::__get($name);
        }

        public function login($identity, $duration = 0) {
                // set state
                $this->setState(self::LOGIN_USER_INFO_KEY, $identity->getUser());
                $this->setState(self::LOGIN_USER_ID_KEY, $identity->getUserId());
                parent::login($identity, self::COOKIE_LIFETIME);
        }

        public function getIsGuest() {
                return $this->getState(self::LOGIN_USER_ID_KEY) === null;
        }

        public function getRole() {
                $role_id = 0;

                if ($this->hasState(self::LOGIN_USER_ROLE_KEY)) {
                        $role_id = $this->getState(self::LOGIN_USER_ROLE_KEY, 0);
                }
                
                return $role_id;
        }

}
