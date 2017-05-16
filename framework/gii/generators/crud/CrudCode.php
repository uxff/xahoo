<?php

class CrudCode extends CCodeModel {

        public $model;
        public $controller;
        public $baseControllerClass = 'Controller';
        private $_modelClass;
        private $_table;

        public function rules() {
                return array_merge(parent::rules(), array(
                    array('model, controller', 'filter', 'filter' => 'trim'),
                    array('model, controller, baseControllerClass', 'required'),
                    array('model', 'match', 'pattern' => '/^\w+[\w+\\.]*$/', 'message' => '{attribute} should only contain word characters and dots.'),
                    array('controller', 'match', 'pattern' => '/^\w+[\w+\\/]*$/', 'message' => '{attribute} should only contain word characters and slashes.'),
                    array('baseControllerClass', 'match', 'pattern' => '/^[a-zA-Z_][\w\\\\]*$/', 'message' => '{attribute} should only contain word characters and backslashes.'),
                    array('baseControllerClass', 'validateReservedWord', 'skipOnError' => true),
                    array('model', 'validateModel'),
                    array('baseControllerClass', 'sticky'),
                ));
        }

        public function attributeLabels() {
                return array_merge(parent::attributeLabels(), array(
                    'model' => 'Model Class',
                    'controller' => 'Controller ID',
                    'baseControllerClass' => 'Base Controller Class',
                ));
        }

        public function requiredTemplates() {
                return array(
                    'controller.php',
                );
        }

        public function init() {

                if (Yii::app()->db === null)
                        throw new CHttpException(500, 'An active "db" connection is required to run this generator.');
                parent::init();
        }

        public function successMessage() {
                $link = CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target' => '_blank'));
                return "The controller has been generated successfully. You may $link.";
        }

        public function validateModel($attribute, $params) {
                if ($this->hasErrors('model'))
                        return;
                $class = @Yii::import($this->model, true);
                if (!is_string($class) || !$this->classExists($class))
                        $this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
                elseif (!is_subclass_of($class, 'CActiveRecord'))
                        $this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
                else {
                        $table = CActiveRecord::model($class)->tableSchema;
                        if ($table->primaryKey === null)
                                $this->addError('model', "Table '{$table->name}' does not have a primary key.");
                        elseif (is_array($table->primaryKey))
                                $this->addError('model', "Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
                        else {
                                $this->_modelClass = $class;
                                $this->_table = $table;
                        }
                }
        }

        public function prepare() {
                $this->files = array();
                $templatePath = $this->templatePath;
                $controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';

                $this->files[] = new CCodeFile(
                        $this->controllerFile, $this->render($controllerTemplateFile)
                );

                $files = scandir($templatePath);
                foreach ($files as $file) {
                        if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php') {
                                $this->files[] = new CCodeFile(
                                        $this->viewPath . DIRECTORY_SEPARATOR . str_replace(".php", ".tpl", $file), $this->render($templatePath . '/' . $file)
                                );
                        }
                }
                //print_r($this->files);
        }

        public function getModelClass() {
                return $this->_modelClass;
        }

        public function getControllerClass() {
                if (($pos = strrpos($this->controller, '/')) !== false)
                        return ucfirst(substr($this->controller, $pos + 1)) . 'Controller';
                else
                        return ucfirst($this->controller) . 'Controller';
        }

        public function getModule() {
                if (($pos = strpos($this->controller, '/')) !== false) {
                        $id = substr($this->controller, 0, $pos);
                        if (($module = Yii::app()->getModule($id)) !== null)
                                return $module;
                }
                return Yii::app();
        }

        public function getControllerID() {
                if ($this->getModule() !== Yii::app())
                        $id = substr($this->controller, strpos($this->controller, '/') + 1);
                else
                        $id = $this->controller;
                if (($pos = strrpos($id, '/')) !== false)
                        $id[$pos + 1] = strtolower($id[$pos + 1]);
                else
                        $id[0] = strtolower($id[0]);
                return $id;
        }

        public function getUniqueControllerID() {
                $id = $this->controller;
                if (($pos = strrpos($id, '/')) !== false)
                        $id[$pos + 1] = strtolower($id[$pos + 1]);
                else
                        $id[0] = strtolower($id[0]);
                return $id;
        }

        public function getControllerFile() {
                $module = $this->getModule();
                $id = $this->getControllerID();
                if (($pos = strrpos($id, '/')) !== false)
                        $id[$pos + 1] = strtoupper($id[$pos + 1]);
                else
                        $id[0] = strtoupper($id[0]);
                return $module->getControllerPath() . '/' . $id . 'Controller.php';
        }

        public function getViewPath() {
                //modify by xingkun 20141026 需要在全局配置并在此获取-调研
                //return Yii::app()->basePath . "/themes/tpl/" . strtolower($this->getControllerID());
                return $this->getModule()->getViewPath() . '/' . strtolower($this->getControllerID());
        }

        public function getTableSchema() {
                return $this->_table;
        }

        public function generateInputLabel($modelClass, $column) {
                return "CHtml::activeLabelEx(\$model,'{$column->name}')";
        }

        public function generateInputField($modelClass, $column) {
                if ($column->type === 'boolean')
                        return "CHtml::activeCheckBox(\$model,'{$column->name}')";
                elseif (stripos($column->dbType, 'text') !== false)
                        return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
                else {
                        if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
                                $inputField = 'activePasswordField';
                        else
                                $inputField = 'activeTextField';

                        if ($column->type !== 'string' || $column->size === null)
                                return "CHtml::{$inputField}(\$model,'{$column->name}')";
                        else {
                                if (($size = $maxLength = $column->size) > 60)
                                        $size = 60;
                                return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
                        }
                }
        }

        public function generateJsContent($modelClass, $attribute, $htmlOptions = array(), $enableAjaxValidation = false, $enableClientValidation = true) {
                
        }

        public function generateActiveLabel($modelClass, $column) {
                return "\$form->labelEx(\$model,'{$column->name}')";
        }

        public function generateActiveField($modelClass, $column) {
                /**
                  Yii::app()->clientScript->registerScript('search'.$column->name, "
                  $('.search-button').click(function(){
                  $('.search-form').toggle();
                  return false;
                  });
                  $('.search-form form').submit(function(){

                  return false;
                  });
                  ");
                 */
                //develope 输出页面的js初始化
                if ($column->autoIncrement) {
                        return '';
                }
                if (in_array($column->name, array('last_modified'))) {
                        return '';
                }
                //对comment进行处理
                //首先判断comment是否有> 有的为选项
                //如果有选项的均为下拉框，如果没有的按照下面的逻辑判断
                $comment = $optstr = '';
                if (stripos($column->comment, '>') !== false) {
                        list($comment, $optstr) = explode(">", str_replace(array(">", "》"), array(">", '>'), $column->comment));
                } elseif ($column->comment) {
                        $comment = $column->comment;
                } else {
                        $comment = ucwords(str_replace("_", " ", $column->name));
                }

                $options = array();
                if ($optstr) {
                        //获取options 1|普通,10|置顶
                        $tmparr = explode(",", $optstr);
                        foreach ($tmparr as $value) {
                                list($v, $text) = explode("|", $value);
                                $options[] = array('value' => $v, 'text' => $text);
                        }
                }


                $html = '';
                $html .= '
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="' . "{$this->_modelClass}_{$column->name}" . '">' . $comment . '</label>
                    <div class="col-xs-8">';
                if ($options) {

                        $html .='<select class="form-control" id="' . "{$this->_modelClass}_{$column->name}" . '" name="' . "{$this->_modelClass}[{$column->name}]" . '" style="width:120px;">';
                        $html .= '<option value="">请选择</option>';
                        foreach ($options as $value) {
                                $html.= '   <option value="' . $value['value'] . '"';
                                $html .= '{if $dataObj.' . $column->name . ' eq "' . $value['value'] . '"} selected="selected"{/if}';
                                $html .='>' . $value['text'] . '</option>';
                        }
                        $html .= '</select>';
                } else {
                        if (stripos($column->dbType, 'text') !== false) {
                                $html .='<textarea id="' . "{$this->_modelClass}_{$column->name}" . '" name="' . "{$this->_modelClass}[{$column->name}]" . '" class="col-xs-10 col-sm-5" placeholder="' . $comment . '">{$dataObj.' . $column->name . '}</textarea>';
                        } elseif (($column->dbType=='timestamp') || ($column->dbType=='datetime')) {
                                $html .='                                <div class="input-group lablediv1" style="width:250px;" style="float:right;">
                                    <input type="text" class="form-control year-picker xdr_time_start" data-date-format="yyyy-mm-dd"
                                           id="'.$column->name.'_start" name="condition['.$column->name.'_start]" size="50" maxlength="20"
                                           value="{$condition.'.$column->name.'_start}"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input type="text" class="form-control year-picker xdr_time_end" data-date-format="yyyy-mm-dd"
                                           id="'.$column->name.'_end" name="condition['.$column->name.'_end]" size="50" maxlength="20"
                                           value="{$condition.'.$column->name.'_end}"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                </div>
';
                        } else {
                                $html .= '<input type="text" id="' . "{$this->_modelClass}_{$column->name}" . '" name="' . "{$this->_modelClass}[{$column->name}]" . '" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.' . $column->name . '}" />';
                        }
                }
                $html .= '</div>';
                /*
                $html .= '
                    <div class="col-sm-2"> <span class="help-inline middle" id="' . "{$this->_modelClass}_{$column->name}" . '_em_">  </span> </div>';
                */
                $html .= '
                </div>';
                return $html;
                if ($column->type === 'boolean') {//多选框
                        //return CHtml::checkBox($model, $column->name);
                        $html = "\$form->checkBox(\$model,'{$column->name}')";
                } elseif (stripos($column->dbType, 'text') !== false) {

                        $html = "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
                } else {
                        if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
                                $inputField = 'passwordField'; //密码
                        else
                                $inputField = 'textField';

                        if ($column->type !== 'string' || $column->size === null) {
                                //return CHtml::textField($model, $column->name);
                                $html = "\$form->{$inputField}(\$model,'{$column->name}')";
                        } else {
                                if (($size = $maxLength = $column->size) > 60)
                                        $size = 60;
                                $html = "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
                        }
                }
                $html .= "\n";
                return $html;
        }

        public function guessNameColumn($columns) {
                foreach ($columns as $column) {
                        if (!strcasecmp($column->name, 'name'))
                                return $column->name;
                }
                foreach ($columns as $column) {
                        if (!strcasecmp($column->name, 'title'))
                                return $column->name;
                }
                foreach ($columns as $column) {
                        if ($column->isPrimaryKey)
                                return $column->name;
                }
                return 'id';
        }

}
