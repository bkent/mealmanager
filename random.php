<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>Randomise meals</title><meta name="HandheldFriendly" content="true" /><meta name="MobileOptimized" content="320" /><meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scaleable=no, width=device-width" /><link rel="stylesheet" href="storytapes.css"><link rel="icon" href="http://benkent.servehttp.com/mealmanager/favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="http://benkent.servehttp.com/mealmanager/favicon.ico" type="image/x-icon" /></head><body><?phpinclude "../db/functions.php";//Check if user is legitimately logged insession_start();if (!isset($_SESSION["valid_user"])){	// User not logged in, redirect to login page	header("Location: index.php");	exit();}$now=date("Y-m-d");$dayno=date("w",strtotime($now));switch($dayno){	case 0://sunday		$start = date('Y-m-d', strtotime($now. " -6 days"));		$end = date('Y-m-d', strtotime($now));	break;	case 1://monday		$start = date('Y-m-d', strtotime($now));		$end = date('Y-m-d', strtotime($now. " +6 days"));	break;	case 2://tuesday		$start = date('Y-m-d', strtotime($now. " -1 days"));		$end = date('Y-m-d', strtotime($now. " +5 days"));	break;	case 3://wednesday		$start = date('Y-m-d', strtotime($now. " -2 days"));		$end = date('Y-m-d', strtotime($now. " +4 days"));	break;	case 4://thursday		$start = date('Y-m-d', strtotime($now. " -3 days"));		$end = date('Y-m-d', strtotime($now. " +3 days"));	break;	case 5://friday			$start = date('Y-m-d', strtotime($now. " -4 days"));		$end = date('Y-m-d', strtotime($now. " +2 days"));	break;	case 6://saturday		$start = date('Y-m-d', strtotime($now. " -5 days"));		$end = date('Y-m-d', strtotime($now. " +1 days"));	break;}$mysqli = iConnect("mealmanager");$data = $mysqli->query("select id from meals  where category like '%E%'  order by rand() limit 7"); // any evening meal$i = 0;   while ($row = $data->fetch_array()){  	$mealid = $row['id'];		$current=(date('Y-m-d', strtotime($start. " +$i days")));    $mysqli->query("insert into meallog(mealid,meal,dt) 	    values('$mealid','E','$current 00:00:00')");	$i++;}header("Location: home.php");	?>