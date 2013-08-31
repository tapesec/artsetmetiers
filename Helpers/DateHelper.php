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

		$now = time();
		$strdate = strtotime($obj->format('Y-m-d H:i:s'));
		//debug($strdate);
		
		if($delay){
			$diff = $now - $strdate;
			$diff = ceil($diff/(3600*24));
			//debug($diff);
			if($diff > 30){
				$dateFinale = self::fr($date);
				return $dateFinale;
				//debug($dateFinale);
			}elseif($diff <= 30 && $diff > 1){
				return $dateFinale = 'Il y a '.$diff.' jours';
			}elseif($diff ==1){
				return $dateFinale = ucfirst(strftime('Hier à %H : %M', $strdate));
			}elseif($diff < 1){
				return $dateFinale = ucfirst(strftime('Aujourd\'hui à %H : %M', $strdate));
				//die('erreur date');
			}
		}else{
			$dateFinale = ucfirst(strftime('%a %d %b %Y', $strdate));
			return $dateFinale;
		}
		//debug($dateFinale);
		//return $dateFinale;

	}

	/**
	*@return la date et l'heure actuelle au format us pret à être inserer en base de données
	**/
	static function now(){
		$date = new DateTime('NOW', new DateTimeZone('EUROPE/Paris'));
		return $date->format('Y-m-d H:i');
	}
}
