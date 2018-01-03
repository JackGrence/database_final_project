<!doctype html>
<html lang="en">
  <head>
<?PHP
include "../header.php";
?>
    <title>科系管理</title>
  </head>
  <body>
<?php
include "../connect_sql.php";
include "../myfun.php";
?>
<div class="container">
  <!-- content here -->
<form action="." method="post">

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <button name="action" value="buildin" class="btn btn-outline-secondary" type="submit">選擇</button>
  </div>
  <select name="select" class="custom-select" id="select">
    <option value="0">查詢各位同學選科目數</option>
    <option value="1">查詢每門課程選修人數</option>
    <option value="2">查詢各位同學平均成績</option>
    <option value="3">查詢每門課程平均分數</option>
    <option value="4">查詢學生選課紀錄</option>
    <option value="5">查詢皆有選的課程</option>
  </select>
</div>

<div class="form-group">
    <label for="exampleFormControlTextarea1">SQL 指令</label>
    <textarea class="form-control" id="sql_cmd" name="sql_cmd" rows="5"></textarea>
</div>
  <div class="form-group row">
      <div class="col-sm-10">
          <button name="action" value="exec" type="submit" class="btn btn-primary">執行 SQL</button>
      </div>
  </div>
</form>
<?php
switch($_POST["action"])
{
case "buildin":
    $cmd = subquery($link, $_POST["select"]);
    break;
case "exec":
    $cmd = subquery($link, $_POST["sql_cmd"]);
}
?>
</div>
<script>
<?php
if(isset($_POST["select"]))
{
    echo '$("#select").val("'.$_POST["select"].'");';
}
if(isset($cmd))
{
    echo '$("#sql_cmd").val(\''.$cmd.'\');';
}
?>
</script>
  </body>
</html>
