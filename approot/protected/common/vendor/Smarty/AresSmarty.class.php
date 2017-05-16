<?php

/**
 * Project:     Smarty: the PHP compiling template engine
 * File:        SmartyBC.class.php
 * SVN:         $Id: $
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-discussion-subscribe@googlegroups.com
 *
 * @link http://www.smarty.net/
 * @copyright 2008 New Digital Group, Inc.
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author Uwe Tews
 * @author Rodney Rehm
 * @package Smarty
 */
/**
 * @ignore
 */
require_once(dirname(__FILE__) . '/Smarty.class.php');

/**
 * Smarty Backward Compatability Wrapper Class
 *
 * @package Smarty
 */
class AresSmarty extends Smarty {

        /**
         * Smarty 2 BC
         * @var string
         */
        public $_version = self::SMARTY_VERSION;

        /** @var string 模板所用layout */
        protected $_layout_ = 'default.tpl';

        public function display($page, $pid = null) {
                /** 使用 layout 机制 */
                $this->assign('NACHO_CONTENT_FOR_LAYOUT', $page);
                parent::display($this->_layout_, $pid); // 最后的smarty显示处理，调用Smarty原始函数
        }

        /**
         * Initialize new SmartyBC object
         *
         * @param array $options options to set during initialization, e.g. array( 'forceCompile' => false )
         */
        public function __construct(array $options = array()) {
                parent::__construct($options);
        }

}
