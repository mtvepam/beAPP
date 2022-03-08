<?php
include 'db_connect.php';

$sql = "SELECT * FROM Weather.Days ORDER BY applicable_date";
$result = mysqli_query($connect, $sql);

echo '<h3> <b style="color:red"> Weather day-by-day log for Moscow city (Earth ID location: 2122265 ) </b> </h3>';
echo "<h7>  Information has been provided by ".$getenv('HOSTNAME')." </b> </h7>";
echo '<h5>     *The table may contain data of previouse requests. Use Tab Config to clear DataBase </h5>';
echo '<h7>  </h7>';

if (mysqli_num_rows($result) > 0) 
{
  echo "<table class='table table-bordered'>";
  echo "<tr>";
  echo "<td>#</td>";
  echo "<td>ID</td>";
  echo "<td>Weather</td>";
  echo "<td>Wind</td>";
  echo "<td>CreateTime</td>";
  echo "<td>Date</td>";
  echo "<td>T min</td>";
  echo "<td>T max</td>";
  echo "<td>T average</td>";
  echo "</tr>";

  $i=0;
  while($row = mysqli_fetch_array($result)) 
  {
      $tclass = "danger";
      if ($row["the_temp"] < -5) {
          $tclass = "info";
      } elseif ($row["the_temp"] < 5) {
          $tclass = "success";
      } elseif ($row["the_temp"] < 20) {
          $tclass = "warning";
      } elseif ($row["the_temp"] > 19.9) {
          $tclass = "danger";
      }
      echo "<tr class=$tclass >";
      echo "<td>".($i+1)."</td>";
      echo "<td>".$row["id"]."</td>";
      echo "<td>".$row["weather_state_name"]."</td>";
      echo "<td>".$row["wind_direction_compass"]."</td>";
      echo "<td>".$row["created"]."</td>";
      echo "<td><b>".$row["applicable_date"]."</b></td>";
      echo "<td>".$row["min_temp"]."</td>";
      echo "<td>".$row["max_temp"]."</td>";
      echo "<td>".$row["the_temp"]."</td>";
      echo "</tr>";
      $i++;
  }
  echo "</table>";
}
else
{
  echo "<br /> No records found in DataBase.";
}
?>
