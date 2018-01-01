<?PHP
include "connect_sql.php";
$q = "select * from 學生資料表;";
$result = mysqli_query($link, $q);
echo $result->current_field."</br>";
echo $result->field_count."</br>";
echo $result->lengths."</br>";
echo $result->num_rows."</br>";
echo $result->fetch_row()[1]."</br>";
echo $result->fetch_row()[1]."</br>";
echo $result->fetch_row()[1]."</br>";
echo $result->fetch_row()[1]."</br>";
echo $result->fetch_row()[1]."</br>";
mysqli_close($link);
?>
