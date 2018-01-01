<!doctype html>
<html lang="en">
  <head>
<?PHP
include "../header.php";
?>
    <title>科系管理</title>
  </head>
  <body>
<?PHP
include "../connect_sql.php";
include "../myfun.php";
if(isset($_POST["action"]))
{
    switch ($_POST["action"])
    {
    case "add":
        $q = "insert into 選課資料表 values(?, ?, NULL);";
        $stmt = $link->prepare($q);
        if($stmt == false)
        {
            printf('errno: %d, error: %s', $link->errno, $link->error);
        }
        $stmt->bind_param('ss', $_POST["std_code"], $_POST["add_course"]);
        $stmt->execute();
        break;
    case "del":
        $q = "DELETE FROM 選課資料表 WHERE 學號 = ? and 課號 = ?;";
        $stmt = $link->prepare($q);
        $stmt->bind_param('ss', $_POST["std_code"], $_POST["del_course"]);
        $stmt->execute();
        break;
    }
}

$q = "select 學號, 姓名 from 學生資料表;";
$result = mysqli_query($link, $q);
$data = $result->fetch_all();
?>
<div class="container">
  <!-- Content here -->
<form action="." method="post">

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <button name="select_std" class="btn btn-outline-secondary" type="submit">選擇</button>
  </div>
  <select name="std_code" class="custom-select" id="select_std">
<?PHP
foreach($data as $row => $value)
{
    echo '<option value="'.$value[0].'">'.$value[1].'</option>';
}
?>
  </select>
</div>

<div class="container">
  <div class="row">
    <div class="col">未選清單</div>
    <div class="w-100"></div>
    <div class="col">
<?PHP
$q = "SELECT `COLUMN_NAME` 
    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA`='final' 
    AND `TABLE_NAME`='課程資料表';";
$result = mysqli_query($link, $q);
$columns = $result->fetch_all();

if(isset($_POST["std_code"]))
{
    $q = "select * from 課程資料表 where 課號 not in (select 課號 from 選課資料表 where 學號 = ?);";
    $stmt = $link->prepare($q);
    $stmt->bind_param('s', $_POST["std_code"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all();
    print_table($columns, $data);
}
?>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <button name="action" value="add" class="btn btn-outline-secondary" type="submit">加選</button>
  </div>
  <select name="add_course" class="custom-select">
<?PHP
if(isset($_POST["std_code"]))
{
    foreach($data as $row => $value)
    {
        echo '<option value="'.$value[0].'">'.$value[1].'</option>';
    }
}
?>
  </select>
</div>

    </div>
    <div class="w-100"></div>
    <div class="col">已選清單</div>
    <div class="w-100"></div>
    <div class="col">
<?PHP
if(isset($_POST["std_code"]))
{
    $q = "select * from 課程資料表 where 課號 in (select 課號 from 選課資料表 where 學號 = ?);";
    $stmt = $link->prepare($q);
    $stmt->bind_param('s', $_POST["std_code"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all();
    print_table($columns, $data);
}
?>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <button name="action" value="del" class="btn btn-outline-secondary" type="submit">退選</button>
  </div>
  <select name="del_course" class="custom-select">
<?PHP
if(isset($_POST["std_code"]))
{
    foreach($data as $row => $value)
    {
        echo '<option value="'.$value[0].'">'.$value[1].'</option>';
    }
}
?>
  </select>
</div>

    </div>
  </div>
</div>
  
</form>
</div>
<script>
<?PHP
if(isset($_POST["std_code"]))
{
    echo '$("#select_std").val("'.$_POST["std_code"].'");';
}
?>
</script>
  </body>
</html>
