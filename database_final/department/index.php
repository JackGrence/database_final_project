<!doctype html>
<html lang="en">
  <head>
<?PHP
include "../header.php";
?>
    <title>科系管理</title>
  </head>
  <body>
<div class="container">
  <!-- Content here -->
<form action="." method="post">
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">系碼</label>
    <div class="col-sm-10">
    <input name="code" class="form-control" type="text" placeholder="請輸入系碼">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">系名</label>
    <div class="col-sm-10">
    <input name="name" class="form-control" type="text" placeholder="請輸入系名">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">系主任</label>
    <div class="col-sm-10">
    <input name="teacher" class="form-control" type="text" placeholder="請輸入系主任">
    </div>
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
include "../connect_sql.php";
include "../myfun.php";
if(isset($_POST["action"]))
{
    $q = "";
    switch ($_POST["action"])
    {
    case "add":
        $q = "insert into 科系代碼表 values(?, ?, ?);";
        $stmt = $link->prepare($q);
        $stmt->bind_param('sss', $_POST["code"], $_POST["name"], $_POST["teacher"]);
        break;
    case "edit":
        $q = "UPDATE 科系代碼表 SET 系名 = ?, 系主任 = ? WHERE 系碼 = ?;";
        $stmt = $link->prepare($q);
        $stmt->bind_param('sss', $_POST["name"], $_POST["teacher"], $_POST["code"]);
        break;
    case "del":
        $q = "DELETE FROM 科系代碼表 WHERE 系碼 = ?;";
        $stmt = $link->prepare($q);
        $stmt->bind_param('s', $_POST["code"]);
        break;
    case "search":
        $q = "SELECT * FROM 科系代碼表 WHERE 系碼 = ?;";
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
    $q = "select * from 科系代碼表;";
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
    AND `TABLE_NAME`='科系代碼表';";
$result = mysqli_query($link, $q);
$columns = $result->fetch_all();
print_table($columns, $data);
mysqli_close($link);
?>
</div>
  </body>
</html>
