<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><link rel="icon" href="http://benkent.servehttp.com/mealmanager/favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="http://benkent.servehttp.com/mealmanager/favicon.ico" type="image/x-icon" /><meta name="HandheldFriendly" content="true" /><meta name="MobileOptimized" content="320" /><meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scaleable=no, width=device-width" /><title>Meal Manager</title><link rel="stylesheet" href="mealmanager.css"></head><body><?phpinclude "../db/functions.php";include "day.php";//Check if user is legitimately logged insession_start();function GetMealTitle($id){	$_mysqli = iConnect("mealmanager");	$_qdata = "SELECT title		FROM meals		WHERE id=$id";    	$_data = $_mysqli->query($_qdata);  	$_num_rows = $_data->num_rows;  	if ($_num_rows > 0)	{		$_row = $_data->fetch_array();		return $_row['title'];	}	else 		return "";}/*ini_set('display_errors',1);ini_set('display_startup_errors',1);error_reporting(-1);*/if (!isset($_SESSION["valid_user"])){	// User not logged in, redirect to login page	header("Location: index.php");	exit();}echo "<body><div align='left'><div class='searchbar'>Logged in as <a href='userstats.php'>". $_SESSION["short_name"] ."</a>&nbsp;</div>	  <div class='searchbar'><form name='flibrary' method='post' action='library.php'>      <input type='submit' name='library' value='Library' /></form></div>	  <div class='searchbar'><form name='frandom' method='post' action='random.php'>      <input type='submit' name='random' value='Randomise' /></form></div>	  <div class='searchbar'><form name='fshoppinglist' method='post' action='shoppinglist.php'>      <input type='submit' name='shoppinglist' value='Shopping List' /></form></div>	  <div class='searchbar'><form name='formlogout' method='post' action='logout.php'>      <input type='submit' name='logout' value='Log Out' /></form></div></div>      <div class='maintabdiv'>	  ";$datetoday = date('d/m/Y');$q = @$_POST["q"];$pagenum = @$_POST["p"];if (!isset($_POST["p"])){	$pagenum  = 1;}$now=date("Y-m-d");$dayno=date("w",strtotime($now));//echo "Now=$now";//echo "Dayno=$dayno";switch($dayno){	case 0://sunday		$start = date('Y-m-d', strtotime($now. " -6 days"));		$end = date('Y-m-d', strtotime($now));	break;	case 1://monday		$start = date('Y-m-d', strtotime($now));		$end = date('Y-m-d', strtotime($now. " +6 days"));	break;	case 2://tuesday		$start = date('Y-m-d', strtotime($now. " -1 days"));		$end = date('Y-m-d', strtotime($now. " +5 days"));	break;	case 3://wednesday		$start = date('Y-m-d', strtotime($now. " -2 days"));		$end = date('Y-m-d', strtotime($now. " +4 days"));	break;	case 4://thursday		$start = date('Y-m-d', strtotime($now. " -3 days"));		$end = date('Y-m-d', strtotime($now. " +3 days"));	break;	case 5://friday			$start = date('Y-m-d', strtotime($now. " -4 days"));		$end = date('Y-m-d', strtotime($now. " +2 days"));	break;	case 6://saturday		$start = date('Y-m-d', strtotime($now. " -5 days"));		$end = date('Y-m-d', strtotime($now. " +1 days"));	break;}$Monday = new Day("Monday",$start);$Tuesday = new Day("Tuesday",(date('Y-m-d', strtotime($start. " +1 days"))));$Wednesday = new Day("Wednesday",(date('Y-m-d', strtotime($start. " +2 days"))));$Thursday = new Day("Thursday",(date('Y-m-d', strtotime($start. " +3 days"))));$Friday = new Day("Friday",(date('Y-m-d', strtotime($start. " +4 days"))));$Saturday = new Day("Saturday",(date('Y-m-d', strtotime($start. " +5 days"))));$Sunday = new Day("Sunday",(date('Y-m-d', strtotime($start. " +6 days"))));$mysqli = iConnect("mealmanager");/*$qdata = "SELECT l.mealid,l.meal,l.dt,m.title  FROM meallog l, meals m  WHERE l.dt BETWEEN '$start' AND '$end'  AND l.mealid=m.id";*/$qdata = "SELECT mealid,meal,dt  FROM meallog  WHERE dt BETWEEN '$start' AND '$end'";    $data = $mysqli->query($qdata); //echo "$qdata"; $num_rows = $data->num_rows; echo "<div class='maintabdiv'>";  //$Monday = new Day("Monday",$start); // monday is the start of the week period  if ($num_rows > 0){    $i = 1;	while ($row = $data->fetch_array())	{	    if ($i % 2 == 0) {  // if i is an even number            $trclass = "class='tabdataeven'";        }		else {		    $trclass="class='tabdataodd'";		}		$meal = $row['meal'];		$date = $row['dt'];		$ukdate = date('d/m/Y',strtotime($date));		$mealid = $row['mealid'];				/*if ($Monday->getDT()==date('Y-m-d', strtotime($date)))		{			$Monday->setMealData($mealid);		}*/				//echo $Monday->getDT();				switch(date('Y-m-d', strtotime($date)))		{			case $Sunday->getDT()://sunday				$Sunday->setMealData($meal,$mealid);				$break=GetMealTitle($Sunday->getBreak());				$lunch=GetMealTitle($Sunday->getLunch());				$dinner=GetMealTitle($Sunday->getDinner());				$day="Sun";			break;			case $Monday->getDT()://monday				$Monday->setMealData($meal,$mealid);				$break=GetMealTitle($Monday->getBreak());				$lunch=GetMealTitle($Monday->getLunch());				$dinner=GetMealTitle($Monday->getDinner());				$day = "Mon";							break;			case $Tuesday->getDT()://tuesday				$Tuesday->setMealData($meal,$mealid);				$break=GetMealTitle($Tuesday->getBreak());				$lunch=GetMealTitle($Tuesday->getLunch());				$dinner=GetMealTitle($Tuesday->getDinner());				$day = "Tue";			break;			case $Wednesday->getDT()://wednesday				$Wednesday->setMealData($meal,$mealid);				$break=GetMealTitle($Wednesday->getBreak());				$lunch=GetMealTitle($Wednesday->getLunch());				$dinner=GetMealTitle($Wednesday->getDinner());				$day = "Wed";			break;			case $Thursday->getDT()://thursday				$Thursday->setMealData($meal,$mealid);				$break=GetMealTitle($Thursday->getBreak());				$lunch=GetMealTitle($Thursday->getLunch());				$dinner=GetMealTitle($Thursday->getDinner());				$day = "Thu";			break;			case $Friday->getDT()://friday				$Friday->setMealData($meal,$mealid);				$break=GetMealTitle($Friday->getBreak());				$lunch=GetMealTitle($Friday->getLunch());				$dinner=GetMealTitle($Friday->getDinner());				$day = "Fri";			break;			case $Saturday->getDT()://saturday				$Saturday->setMealData($meal,$mealid);				$break=GetMealTitle($Saturday->getBreak());				$lunch=GetMealTitle($Saturday->getLunch());				$dinner=GetMealTitle($Saturday->getDinner());				$day = "Sat";			break;		}								/*$dayno = date('w',strtotime($date));		switch($dayno)		{			case 0://sunday				$day = "Sun";			break;			case 1://monday				$day = "Mon";			break;			case 2://tuesday				$day = "Tue";			break;			case 3://wednesday				$day = "Wed";			break;			case 4://thursday				$day = "Thu";			break;			case 5://friday				$day = "Fri";			break;			case 6://saturday				$day = "Sat";			break;		}				echo "<div class='tabrow'>";		echo "<div class='tabdataeven-narrow'>";		echo "$day $ukdate";		echo "</div>";		echo "<div class='tabdataodd-narrow'>";		echo "	$break";		echo "</div>";		echo "<div class='tabdataeven-narrow'>";		echo "	$lunch";		echo "</div>";		echo "<div class='tabdataodd-narrow'>";		echo "	$dinner";		echo "</div>";		echo "</div>";		*/	}	}  ?></div><table>    <tr>	    <td rowspan="3">			Monday<br/>		    <? echo date('d/m/Y',strtotime($Monday->getDT()));?>		</td>		<td>			<table>			<tr>			<td><? echo GetMealTitle($Monday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Monday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>			<table>			<tr>			<td><? echo GetMealTitle($Monday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td rowspan="3">			Tuesday <br/>			<? echo date('d/m/Y',strtotime($Tuesday->getDT()));?>		</td>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Tuesday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Tuesday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Tuesday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td rowspan="3">			Wednesday <br/>			<? echo date('d/m/Y',strtotime($Wednesday->getDT()));?>		</td>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Wednesday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Wednesday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Wednesday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td rowspan="3">			Thursday <br/>			<? echo date('d/m/Y',strtotime($Thursday->getDT()));?>		</td>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Thursday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Thursday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>        </td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Thursday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td rowspan="3">			Friday <br/>			<? echo date('d/m/Y',strtotime($Friday->getDT()));?>		</td>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Friday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Friday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Friday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td rowspan="3">			Saturday <br/>			<? echo date('d/m/Y',strtotime($Saturday->getDT()));?>        </td>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Saturday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Saturday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Saturday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td rowspan="3">			Sunday <br/>			<? echo date('d/m/Y',strtotime($Sunday->getDT()));?>		</td>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Sunday->getBreak());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Sunday->getLunch());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr>	<tr>		<td>						<table>			<tr>			<td><? echo GetMealTitle($Sunday->getDinner());?></td>			<form method='post' action='changemeal.php'>				<td>				<input type='submit' name='change' value='Change' />				</td>				<td>				<input type='submit' name='delete' value='Delete' />				</td>			</form>			</tr>			</table>		</td>	</tr></table></body></html>