<?php

/**
 * CSmartyValidatorJs class file.
 *
 * @author xingkun <wangxingkun@fangfull.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
class CSmartyValidatorJs extends CWidget {

        /**
         * @var mixed the form action URL (see {@link CHtml::normalizeUrl} for details about this parameter).
         * If not set, the current page URL is used.
         */
        public $action = '';

        /**
         * @var string the form submission method. This should be either 'post' or 'get'.
         * Defaults to 'post'.
         */
        public $method = 'post';

        /**
         * @var boolean whether to generate a stateful form (See {@link CHtml::statefulForm}). Defaults to false.
         */
        public $stateful = false;

        /**
         * @var string the CSS class name for error messages. 
         * Since 1.1.14 this defaults to 'errorMessage' defined in {@link CHtml::$errorMessageCss}.
         * Individual {@link error} call may override this value by specifying the 'class' HTML option.
         */
        public $errorMessageCssClass;

        /**
         * @var array additional HTML attributes that should be rendered for the form tag.
         */
        public $htmlOptions = array();
        public $clientOptions = array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        );
        public $enableAjaxValidation = false;

        /**
         * @var boolean whether to enable client-side data validation. Defaults to false.
         *
         * When this property is set true, client-side validation will be performed by validators
         * that support it (see {@link CValidator::enableClientValidation} and {@link CValidator::clientValidateAttribute}).
         *
         * @see error
         * @since 1.1.7
         */
        public $enableClientValidation = true;

        /**
         * @var mixed form element to get initial input focus on page load.
         *
         * Defaults to null meaning no input field has a focus.
         * If set as array, first element should be model and second element should be the attribute.
         * If set as string any jQuery selector can be used
         *
         * Example - set input focus on page load to:
         * <ul>
         * <li>'focus'=>array($model,'username') - $model->username input filed</li>
         * <li>'focus'=>'#'.CHtml::activeId($model,'username') - $model->username input field</li>
         * <li>'focus'=>'#LoginForm_username' - input field with ID LoginForm_username</li>
         * <li>'focus'=>'input[type="text"]:first' - first input element of type text</li>
         * <li>'focus'=>'input:visible:enabled:first' - first visible and enabled input element</li>
         * <li>'focus'=>'input:text[value=""]:first' - first empty input</li>
         * </ul>
         *
         * @since 1.1.4
         */
        public $focus;

        /**
         * @var array the javascript options for model attributes (input ID => options)
         * @see error
         * @since 1.1.7
         */
        protected $attributes = array();

        /**
         * @var string the ID of the container element for error summary
         * @see errorSummary
         * @since 1.1.7
         */
        protected $summaryID;

        /**
         * @var string[] attribute IDs to be used to display error summary.
         * @since 1.1.14
         */
        private $_summaryAttributes = array();

        /**
         * Initializes the widget.
         * This renders the form open tag.
         */
        public function init() {
                
        }

        /**
         * Runs the widget.
         * This registers the necessary javascript code and renders the form close tag.
         */
        public function run() {
                $cs = Yii::app()->clientScript; //develope 输出页面的js初始化
                $options = $this->clientOptions;

                foreach ($this->_summaryAttributes as $attribute)
                        $this->attributes[$attribute]['summary'] = true;
                $options['attributes'] = array_values($this->attributes); //develope set value at line:525
                if ($this->summaryID !== null)
                        $options['summaryID'] = $this->summaryID;

                if ($this->focus !== null)
                        $options['focus'] = $this->focus;

                if (!empty(CHtml::$errorCss))
                        $options['errorCss'] = CHtml::$errorCss;

                $options = CJavaScript::encode($options);
                $cs->registerCoreScript('yiiactiveform');
                $id = $this->id;
                $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').yiiactiveform($options);"); //develope 输出页面的js
        }

        /**
         * Displays the first validation error for a model attribute.
         * This is similar to {@link CHtml::error} except that it registers the model attribute
         * so that if its value is changed by users, an AJAX validation may be triggered.
         * @param CModel $model the data model
         * @param string $attribute the attribute name
         * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
         * Besides all those options available in {@link CHtml::error}, the following options are recognized in addition:
         */
        public function error($model, $attribute, $htmlOptions = array(), $enableAjaxValidation = true, $enableClientValidation = true) {
                if (!$this->enableAjaxValidation)
                        $enableAjaxValidation = false;
                if (!$this->enableClientValidation)
                        $enableClientValidation = false;

                if (!isset($htmlOptions['class']))
                        $htmlOptions['class'] = $this->errorMessageCssClass;

                if (!$enableAjaxValidation && !$enableClientValidation) {
                        return CHtml::error($model, $attribute, $htmlOptions);
                }
                $id = CHtml::activeId($model, $attribute);
                $inputID = isset($htmlOptions['inputID']) ? $htmlOptions['inputID'] : $id;
                unset($htmlOptions['inputID']);
                if (!isset($htmlOptions['id']))
                        $htmlOptions['id'] = $inputID . '_em_';

                $option = array(
                    'id' => $id,
                    'inputID' => $inputID,
                    'errorID' => $htmlOptions['id'],
                    'model' => get_class($model),
                    'name' => $attribute,
                    'enableAjaxValidation' => $enableAjaxValidation,
                );

                $optionNames = array(
                    'validationDelay',
                    'validateOnChange',
                    'validateOnType',
                    'hideErrorMessage',
                    'inputContainer',
                    'errorCssClass',
                    'successCssClass',
                    'validatingCssClass',
                    'beforeValidateAttribute',
                    'afterValidateAttribute',
                );
                foreach ($optionNames as $name) {
                        if (isset($htmlOptions[$name])) {
                                $option[$name] = $htmlOptions[$name];
                                unset($htmlOptions[$name]);
                        }
                }
                if ($model instanceof CActiveRecord && !$model->isNewRecord)
                        $option['status'] = 1;

                if ($enableClientValidation) {//develope 输出页面的js by xingkun 20141029
                        $validators = isset($htmlOptions['clientValidation']) ? array($htmlOptions['clientValidation']) : array();
                        unset($htmlOptions['clientValidation']);

                        $attributeName = $attribute;
                        if (($pos = strrpos($attribute, ']')) !== false && $pos !== strlen($attribute) - 1) { // e.g. [a]name
                                $attributeName = substr($attribute, $pos + 1);
                        }
                        foreach ($model->getValidators($attributeName) as $validator) {
                                if ($validator->enableClientValidation) {
                                        if (($js = $validator->clientValidateAttribute($model, $attributeName)) != '')
                                                $validators[] = $js;
                                }
                        }
                        if ($validators !== array())
                                $option['clientValidation'] = new CJavaScriptExpression("function(value, messages, attribute) {\n" . implode("\n", $validators) . "\n}");
                }
                $html = CHtml::error($model, $attribute, $htmlOptions);
                if ($html === '') {
                        if (isset($htmlOptions['style']))
                                $htmlOptions['style'] = rtrim($htmlOptions['style'], ';') . ';display:none';
                        else
                                $htmlOptions['style'] = 'display:none';
                        $html = CHtml::tag(CHtml::$errorContainerTag, $htmlOptions, '');
                }

                $this->attributes[$inputID] = $option;
                return $html;
        }

}
