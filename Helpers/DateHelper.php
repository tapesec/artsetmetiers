<?php
class DateHelper extends DateTime{

	
	/**
	*@param $date la date à formater et les paramètres à appliquer
	*@return la date formaté
	**/
	static function fr($date, $param=null){
		setlocale(LC_ALL, "fr_FR.utf8", 'fra');
		$obj = new DateTime($date, new DateTimeZone('EUROPE/Paris'));

		$js = (isset($param['Jsemaine']))? $param['Jsemaine'] : '';
		$m = (isset($param['mois']))? $param['mois'] : '';
		$delay = (isset($param['delay']))? $param['delay'] : false;
		$short = (isset($param['short']))? $param['short'] : '';
		$strdate = strtotime($obj->format('Y-m-d H:i:s'));
		
		if($delay){
			$now = new DateTime();
			$interval = $now->diff($obj);
			
			if($interval->i < 1){
				$out = ($interval->s == 1)? 'seconde' : 'secondes';
				return 'Il y a '.$interval->format('%s '.$out);
			}
			if($interval->h < 1){
				$out = ($interval->i == 1)? 'minute' : 'minutes';
				return 'Il y a '.$interval->format('%i '.$out);
			}	
			if($interval->days < 1){
				$out = ($interval->h == 1)? 'heure' : 'heures';
				return 'Il y a '.$interval->format('%h '.$out);
			}else{
				return $dateFinale = ucfirst(strftime('%A %d %B %Y', $strdate));
			}
		}else{
			$dateFinale = ucfirst(strftime('%A %d %B %Y', $strdate));
			return $dateFinale;
		}	
	}

	/**
	*@return la date et l'heure actuelle au format us pret à être inserer en base de données
	**/
	static function now(){
		$date = new DateTime('NOW', new DateTimeZone('EUROPE/Paris'));
		return $date->format('Y-m-d H:i');
	}
}
