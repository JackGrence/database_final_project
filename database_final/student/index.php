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
$q = "select 系碼, 系名 from 科系代碼表;";
$result = mysqli_query($link, $q);
$data = $result->fetch_all();
?>
<div class="container">
  <!-- Content here -->
<form action="." method="post">
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">學號</label>
    <div class="col-sm-10">
    <input name="code" class="form-control" type="text" placeholder="請輸入學號">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">姓名</label>
    <div class="col-sm-10">
    <input name="name" class="form-control" type="text" placeholder="請輸入姓名">
    </div>
  </div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01">系名</label>
  </div>
  <select name="department" class="custom-select" id="inputGroupSelect01">
<?PHP
foreach($data as $row => $value)
{
    echo '<option value="'.$value[0].'">'.$value[1].'</option>';
}
?>
  </select>
</div>
  <div class="form-group row">
    <div class="col-sm-10">
  <button name="action" value="add" type="submit" class="btn btn-primary">新增</button>
  <button name="action" value="edit" type="submit" class="btn btn-primary">修改</button>
  <button name="action" value="del" type="submit" class="btn btn-primary">刪除</button>
  <button name="action" value="search" type="submit" class="btn btn-primary">查詢</button>
  </div>
  </div>
</form>
<?PHP
if(isset($_POST["action"]))
{
    $q = "";
    switch ($_POST["action"])
    {
    case "add":
        $q = "insert into 學生資料表 values(?, ?, ?);";
        $stmt = $link->prepare($q);
        $stmt->bind_param('sss', $_POST["code"], $_POST["name"], $_POST["department"]);
        break;
    case "edit":
        $q = "UPDATE 學生資料表 SET 姓名 = ?, 系碼 = ? WHERE 學號 = ?;";
        $stmt = $link->prepare($q);
        $stmt->bind_param('sss', $_POST["name"], $_POST["department"], $_POST["code"]);
        break;
    case "del":
        $q = "DELETE FROM 學生資料表 WHERE 學號 = ?;";
        $stmt = $link->prepare($q);
        $stmt->bind_param('s', $_POST["code"]);
        break;
    case "search":
        $q = "SELECT * FROM 學生資料表 WHERE 學號 = ?;";
        $stmt = $link->prepare($q);
        $stmt->bind_param('s', $_POST["code"]);
        break;
    }
    $status = array(
        "add" => "新增",
        "edit" => "修改",
        "del" => "刪除",
        "search" => "查詢",
    );
    if(!$stmt->execute())
    {
        echo '<div class="alert alert-danger" role="alert">'.$status[$_POST["action"]].'失敗('.$stmt->error.')</div>';
    }
    else
    {
        echo '<div class="alert alert-success" role="alert">'.$status[$_POST["action"]].'成功</div>';
    }
}
if($_POST["action"] != "search")
{
    $q = "select * from 學生資料表;";
    $result = mysqli_query($link, $q);
}
else
{
    $result = $stmt->get_result();
}
$data = $result->fetch_all();
$q = "SELECT `COLUMN_NAME` 
    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA`='final' 
    AND `TABLE_NAME`='學生資料表';";
$result = mysqli_query($link, $q);
$columns = $result->fetch_all();
print_table($columns, $data);
mysqli_close($link);
?>
</div>
  </body>
</html>
