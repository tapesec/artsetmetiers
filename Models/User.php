<?php

class User extends Model{

	/**
	* définition des règles de validation des données posté par formulaire avant insertion en base de données dans la table User
	**/
	public $validate = array(
        'use_login' => array(
        	'alphaNumeric' => true,
        	'required' => true,
        	'message' => 'le login doit etre alphanuméric et etre compris entre 3 et 20 caractères<br><br>'),
        'use_mail' => array(
        	'email' => true,
        	'required' => true,
        	'message' => 'format de l\'adresse mail invalide<br><br>'),
        'use_password1' => array(
        	'required' => true,
        	'message' => 'ne doit pas être vide<br><br>'),
        'use_password2' => array(
        	'alphaNumeric' => true,
        	'message' => 'ne doit pas être vide<br><br>')
    );
}