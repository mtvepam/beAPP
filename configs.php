<?php
include 'db_connect.php';
echo '<h3><b style="color:red"> Moscow Weather Config </b> </h3>';
echo '<h7>Application gets data about weather in Moscow from www.metaweather.com for the current month corresponded with a date you set below... </h7>';
echo '<h7>  </h7>';
?>

<form action="" method="post">
<p>Please enter date: <input type="date" name="tdate" /></p>
<table class='table'>
<caption> Please choose following actions </caption>
<tr>
<th> </th>
<th> </th>
<th> </th>
</tr>
<tr>
<td><input type=submit name="tget" class="button" value="Get results to the buffer"></td>
<td><input type=submit name="tput" class="button" value="Put results into the DataBase"></td>
<td><input type=submit name="tdelete" class="button" value="Clear the DataBase"></td>
</tr>
</table>
</form>

<?php
$delbuff = 'TRUNCATE TABLE Weather.Buffer';
if(array_key_exists('tget', $_POST))  
{
    echo "Getting data from API for day: ".$_REQUEST['tdate']."<br />";
    if ( mysqli_query($connect, $delbuff) ===false ) 
    { 
              echo "Invalid query for the buffer preparing: ".$mysqli->error." <br />";
    }
    $ti=intval(substr($_REQUEST['tdate'],-2));
    while($ti>0) 
    {
       $turl = 'https://www.metaweather.com/api/location/2122265/'.substr($_REQUEST['tdate'],0,4).'/'.substr($_REQUEST['tdate'],5,2).'/'.str_pad($ti,2,"0",STR_PAD_LEFT);
       $tjson = file_get_contents($turl);
       $array = json_decode($tjson, true);
       if($array[0]["applicable_date"] == '')
       {
          echo "No data found in API database for request: ".$turl."<br />";
       }
       else 
       {
          $tvalue = "'".$array[0]["id"] ."','". $array[0]["weather_state_name"] ."','". $array[0]["wind_direction_compass"] ."','". $array[0]["created"] ."','". $array[0]["applicable_date"] ."',". $array[0]["min_temp"] .",". $array[0]["max_temp"] .",". $array[0]["the_temp"];
          $sonarneeds = "INSERT INTO Weather.Buffer VALUES (".$tvalue.")";
          if ( mysqli_query($connect, $sonarneeds) ===false ) 
          {
             echo "Invalid query for the results buffer: ".$mysqli->error." <br />";
          }
          else
          {
             echo "Data has been loaded into the buffer. Date: ".$array[0]["applicable_date"]." State: ".$array[0]["weather_state_name"]." Temperature: ".$array[0]["the_temp"]."<br />";
          }
       }
       $ti--;
    }
}

if(array_key_exists('tput', $_POST))  
{
    if ( mysqli_query($connect, "INSERT INTO Weather.Days SELECT * FROM Weather.Buffer ") ===false ) 
    {
       echo "Invalid query for the uploading into DataBase: ".$mysqli->error." <br />";
    }
    else
    { 
       echo "Data has been loaded into DataBase. <br />";
       if ( mysqli_query($connect, $delbuff) ===false ) 
       {
            echo "Invalid query for the buffer erasing: ".$mysqli->error." <br />";
       }
    }
}

if(array_key_exists('tdelete', $_POST))  
{
    if ( mysqli_query($connect, "TRUNCATE TABLE Weather.Days") ===false ) 
    {
       echo "Invalid query for Database cleaning: ".$mysqli->error." <br />";
    }
    else 
    { 
       echo "DataBase has been cleaned. <br />";
       if ( mysqli_query($connect, $delbuff) ===false ) 
       {
              echo "Invalid query for the buffer cleaning: ".$mysqli->error." <br />";
       }
    }
}

?>
