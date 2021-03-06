<?php

/**
 * User: abejarano
 * Date: 17/10/19
 * Time: 6:30 AM
 */

namespace fw_Klipso\kernel\Views;


use fw_Klipso\kernel\classes\abstracts\aController;
use fw_Klipso\kernel\engine\middleware\Request;
use fw_Klipso\kernel\Views\forms\ValidateForms;
use fw_Klipso\kernel\Views\interfaces\ViewInterface;
use fw_Klipso\kernel\Views\forms\Forms;

class CreateView extends aController implements ViewInterface
{
    public $model_name = '';
    public $template_name = '';
    public $redirect = '';
    public $settings_form = [];
    private $html_form = '';

    private $_validate_form;

    public function __construct($app)
    {
        parent::__construct($app);

        Forms::setPathApp($app);
        $this->_validate_form = new ValidateForms($app);
    }

    public function save_post(Request $request)
    {
        $this->_validate_form->__loadFieldMoel($this->model_name);

        $response = $this->_validate_form->fieldRequired($request->_postAll());
        if ($response['status'] == 'failed') {
            redirect($this->redirect, $response['message']);
        }
    }

    public function update_post(Request $request)
    {
        // TODO: Implement update_post() method.
    }

    public function get_paginate(Request $request)
    {
        // TODO: Implement get_paginate() method.
    }

    public function make()
    {

        if(empty($this->redirect)) {
            pr('Define a redirect URL using the redirect attribute');
        }

        if(empty($this->model_name)) {
            pr('You must define the name of the model that will be used to generate the form');
        }

        Forms::setModel($this->model_name);
        $this->setFieldForm();
        $this->render($this->template_name,['form' => $this->html_form, 'saludo' => 'hola']);
    }

    private function setFieldForm() {
        if (empty($this->settings_form)) {
            pr('vacio');
        }
        $this->html_form = '<form method="post" >';
        foreach ($this->settings_form as $field) {
            $this->html_form .= Forms::setField($field);
        }
        $this->html_form .= '</form>' .Forms::getKeypad();
    }

}