<?phpinclude "../db/functions.php";//Check if user is legitimately logged insession_start();if (!isset($_SESSION["valid_user"])){	// User not logged in, redirect to login page	header("Location: index.php");	exit();}$id = @$_POST["id"];$meallogid = @$_POST["mlid"];$category = @$_POST["category"];$dt = @$_POST["dt"];?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/search_results.dwt" codeOutsideHTMLIsLocked="false" --><head><title>Change Meal</title><meta name="HandheldFriendly" content="true" /><meta name="MobileOptimized" content="320" /><meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scaleable=no, width=device-width" /><link rel="stylesheet" href="storytapes.css"><link rel="icon" href="http://benkent.servehttp.com/mealmanager/favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="http://benkent.servehttp.com/mealmanager/favicon.ico" type="image/x-icon" /><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head><body><?php $mysqli = iConnect("mealmanager");echo "<table>";echo "<form method='post' action='updatemeal.php'>";echo "<tr><td colspan='2'><b>$name</b></td></tr>";echo "<tr><td align='right' width='auto'><input type='hidden' name='sentfrom' value='changemeal.php'/><b>Meal: </b></td><td width='auto'>";$dropdowndata = $mysqli->query("select id,title  from meals  where category like '%$category%'  order by title");  echo "<select name='id'>";echo "<option value='0' > &lt; None &gt; </option>";  $num_rows = $dropdowndata->num_rows;if ($num_rows > 0){	while ($row = $dropdowndata->fetch_array())	{		$meal = $row['title'];		$mid = $row['id'];		echo "<option value='$mid' >$meal</option>";	}}echo "<input type='hidden' name='mealid' value='$mid' />";echo "<input type='hidden' name='name' value='$name' />";echo "<input type='hidden' name='dt' value='$dt' />";echo "<input type='hidden' name='category' value='$category' />";echo "</select></tr>";echo "<tr><td><input type='submit' name='Submit' value='Change' /></form></td>";echo "<td></td></tr>";?></body></html>