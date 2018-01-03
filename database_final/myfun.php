<?PHP
function subquery($link, $func)
{
    $querys = array(
        "select std.學號, std.姓名, sel.選科數目 from (select 學號, count(課號) as 選科數目 from 選課資料表 group by 學號) as sel, 學生資料表 as std where sel.學號 = std.學號;",
        "select c.課號, c.課名, num.選修人數 from 課程資料表 as c, (select 課號, count(學號) as 選修人數 from 選課資料表 group by 課號) as num where c.課號 = num.課號;",
        "select std.學號, std.姓名, score.平均 from (select 學號, avg(成績) as 平均 from 選課資料表 group by 學號) as score, 學生資料表 as std where std.學號 = score.學號;",
        "select c.課號, c.課名, score.平均 from (select 課號, avg(成績) as 平均 from 選課資料表 group by 課號) as score, 課程資料表 as c where c.課號 = score.課號;",
        "select a.學號, 姓名, 課名, 成績 from 學生資料表 as a, 課程資料表 as b, 選課資料表 as c where a.學號 = c.學號 and b.課號 = c.課號 order by 學號;",
        "select s.課號, s.課名, s.學分數 from 課程資料表 as s, (select 課號 from 選課資料表 group by 課號 having count(學號) = (select count(學號) from 學生資料表)) as c where c.課號 = s.課號;",
    );

    $columns_ary = array(
        array( array("學號"), array("姓名"), array("選科目數")),
        array( array("課號"), array("課名"), array("選修人數")),
        array( array("學號"), array("姓名"), array("平均")),
        array( array("課號"), array("課名"), array("平均")),
        array( array("學號"), array("姓名"), array("課名"), array("成績")),
        array( array("課號"), array("課名"), array("學分數")),
    );
    if(isset($querys[$func]))
    {
        $q = $querys[$func];
        $columns = $columns_ary[$func];
    }
    else
    {
        $q = $func;
        $columns = NULL;
    }
    $stmt = $link->prepare($q);
    if(!$stmt)
    {
        printf('errno: %d, error: %s', $link->errno, $link->error);
        die();
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all();
    print_table($columns, $data);
    return $q;
}
function print_table($columns, $data)
{
    echo '<table class="table table-dark">
        <thead>';
if($columns != NULL)
{
    echo '<tr>
        <th scope="col">#</th>';
    foreach($columns as $row => $value)
    {
        foreach($value as $col => $value2)
        {
            echo "<th scope=\"col\">".$value2."</td>";
        }
    }
    echo '</tr>';
}
echo '</thead>
    <tbody>';
foreach($data as $row => $value)
{
    echo "<tr>";
    echo "<th scope=\"row\">".($row + 1)."</th>";
    foreach($value as $col => $value2)
    {
        echo "<td>".$value2."</td>";
    }
    echo "</tr>";
}
echo '</tbody>
    </table>';
}
?>
