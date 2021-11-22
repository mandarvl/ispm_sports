<?php
function dateEnvoi($date1, $date2){
	$ajd = time();
	$diff = abs($date1 - $date2);
	$retour = array();
	
	$tmp = $diff;
	$retour['seconde'] = $tmp % 60;
	
	$tmp = floor(($tmp -$retour['seconde']) / 60);
	$retour['minute'] = $tmp % 60;
	
	$tmp = floor(($tmp -$retour['minute']) / 60);
	$retour['heure'] = $tmp % 24;
	
	$tmp = floor(($tmp -$retour['heure']) / 24);
	$retour['jour'] = $tmp ;
	
	if ($diff >= 0 && $diff < 20)
	{
		echo 'A l\'instant';
	}
	else
		
		if ($diff >= 20 && $diff < 60)
		{
			echo 'Il y a '.$retour['seconde'].'s';
		}
	else
		if($diff >= 60 && $diff < 3600)
		{
			echo 'Il y a ' .$retour['minute'].'min';
		}
	else	
		if ($diff >= 3600 && $diff < 3600*24)
		{
			echo 'Il y a '.$retour['heure'].'h';
		}
	else
		if ($diff >= 3600*24 && $diff < 3600*24*10)
		{
			echo 'Il y a '.$retour['jour'].'j';
		}
	else
	{
		echo date("d/m/Y", $date2) ; 
		echo ' à ';
		echo date("H:i:s", $date2) ;  
	}
}

function temps($date1,$date2,$choix = "jour"){
	
	$diff = abs($date1 - $date2);
	$reste = array();
	$tmp = $diff;
	$reste['seconde'] = $tmp % 60;
	
	$tmp = floor(($tmp -$reste['seconde']) / 60);
	$reste['minute'] = $tmp % 60;
	
	$tmp = floor(($tmp -$reste['minute']) / 60);
	$reste['heure'] = $tmp % 24;
	
	$tmp = floor(($tmp -$reste['heure']) / 24);
	$reste['jour'] = $tmp ;
	$choix = strtolower($choix);
	
	if ($choix == 'heure')
	{
		return $reste['heure'];
	}
	elseif ($choix == 'minute')
	{
		return $reste['minute'];
	}
	elseif ($choix == 'seconde')
	{
		return $reste['seconde'];
	}
	else
	{
		return $reste['jour'];
	}
}

?>
