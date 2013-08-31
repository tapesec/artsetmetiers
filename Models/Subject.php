<?php
class Subject extends Model{


	public $validate = array(
        'sub_content' => array(
        	'required' => true,
        	'between' => '40',
        	'message' => 'Votre sujet doit contenir au moins 40 caractères...'));



	
}