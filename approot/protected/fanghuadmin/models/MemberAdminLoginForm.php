<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MemberAdminLoginForm extends CFormModel {

        public $username;
        public $password;
        public $rememberMe;
        private $_identity;

        /**
         * Declares the validation rules.
         * The rules state that username and password are required,
         * and password needs to be authenticated.
         */
        public function rules() {
                return array(
                    // username and password are required
                    array('username, password', 'required'),
                );
        }

        /**
         * Declares attribute labels.
         */
        public function attributeLabels() {
                return array(
                    'rememberMe' => 'Remember me next time',
                );
        }

        /**
         * Authenticates the password.
         * This is the 'authenticate' validator as declared in rules().
         */
        public function authenticate($attribute, $params) {
                if (!$this->hasErrors()) {
                        $this->_identity = new UserIdentity($this->username, $this->password);
                        if (!$this->_identity->authenticate())
                                $this->addError('password', 'Incorrect username or password.');
                }
        }

        /**
         * Logs in the user using the given username and password in the model.
         * @return boolean whether login is successful
         */
        public function login() {
                if ($this->_identity === null) {
                        $this->_identity = new MemberAdminIdentity($this->username, $this->password);
                        $this->_identity->authenticate();
                }
                if ($this->_identity->errorCode === MemberAdminIdentity::ERROR_NONE) {
                        $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                        Yii::app()->memberadmin->login($this->_identity, $duration);
                        return true;
                } else {
                        return false;
                }
        }

}
