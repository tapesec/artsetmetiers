<?php
class Comment extends Model{
	/**
	* définition des règles de validation des données posté par formulaire avant insertion en base de données dans la table Comment
	**/
	public $validate = array(
        'com_content' => array(
        	'required' => true,
        	'between' => '2',
        	'message' => 'Votre commentaire ne doit pas être vide et doit faire au moins 3 caractères'));
}