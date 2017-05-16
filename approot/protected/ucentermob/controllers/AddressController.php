<?php

class AddressController extends Controller {

        /**
         * @return array action filters
         */
        public function filters() {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete', // we only allow deletion via POST request
                );
        }

        public function actionIndex() {
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();
                $objAddress = UcMemberAddress::model()->findAll("member_id=:member_id", array(":member_id" => $member_id));
                $arrAddress = $this->convertModelToArray($objAddress);
                $arrRender = array(
                    'gShowHeader' => true,
                    'arrAddress' => $arrAddress,
                    'return_url' => $this->createAbsoluteUrl('Profile/index'),
                    'headerTitle' => '地址管理',
                );
                $this->smartyRender("address/index.tpl", $arrRender);
        }

        /**
         * 修改地址
         */
        public function actionModAddress() {
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();

                if (isset($_POST['address'])) {
                        $id = $this->getString($_GET['id']);
                        $name = $this->getString($_POST['address']['name']);
                        $mobile = $this->getString($_POST['address']['mobile']);
                        $address = $this->getString($_POST['address']['address']);
                        if (!empty($_GET['id'])) {
                                $memberAddress = UcMemberAddress::model()->findByPk(array('id' => $id));
                                $memberAddress->consignee_name = $name;
                                $memberAddress->consignee_mobile = $mobile;
                                $memberAddress->address = $address;
                                $memberAddress->update_time = date('Y-m-d', time());
                                if (isset($_POST['address']['is_default'])) {
                                        UcMemberAddress::model()->updateAll(array('is_default' => '0'), 'member_id=:member_id', array(':member_id' => $member_id));
                                        $memberAddress->is_default = 1;
                                }
                                if ($memberAddress->update()) {
                                        $status = 'success'; //成功
                                        $this->redirect($this->createAbsoluteUrl('address/index'));
                                } else {
                                        $status = 'fail'; //失败
                                        $this->redirect($this->createAbsoluteUrl('address/modaddress'));
                                }
                        } else {
                                $memberAddress = new UcMemberAddress;
                                $memberAddress->consignee_name = $name;
                                $memberAddress->consignee_mobile = $mobile;
                                $memberAddress->address = $address;
                                $memberAddress->member_id = $member_id;
                                $memberAddress->create_time = date('Y-m-d', time());
                                $memberAddress->update_time = date('Y-m-d', time());
                                if (isset($_POST['address']['is_default'])) {
                                        UcMemberAddress::model()->updateAll(array('is_default' => '0'), 'member_id=:member_id', array(':member_id' => $member_id));
                                        $memberAddress->is_default = 1;
                                }
                                if ($memberAddress->save() > 0) {
                                        $status = 'success'; //成功
                                        $this->redirect($this->createAbsoluteUrl('address/index'));
                                } else {
                                        $status = 'fail'; //失败
                                        $this->redirect($this->createAbsoluteUrl('member/modaddress'));
                                }
                        }
                } else {
                        if (isset($_GET['id'])) {
                                $id = $this->getString($_GET['id']);
                                $addressArr = UcMemberAddress::model()->find("member_id=:member_id and id=:id", array(":member_id" => $member_id, ":id" => $id));
                                $addressData = $this->convertModelToArray($addressArr);
                                $arrRender = array(
                                    'gShowHeader' => true,
                                    'return_url' => $this->createAbsoluteUrl('address/index'),
                                    'address' => $addressData,
                                    'headerTitle' => '修改地址',
                                );
                        } else {
                                $arrRender = array(
                                    'gShowHeader' => true,
                                    'return_url' => $this->createAbsoluteUrl('address/index'),
                                    'address' => array('id' => '', 'consignee_name' => '', 'consignee_mobile' => '', 'address' => '', 'is_default' => ''),
                                    'headerTitle' => '添加地址',
                                );
                        }
                        $this->smartyRender('address/modaddress.tpl', $arrRender);
                }
        }

}
