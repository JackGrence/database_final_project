<?PHP
function print_table($columns, $data)
{
    echo '<table class="table table-dark">
        <thead>
        <tr>
        <th scope="col">#</th>';
    foreach($columns as $row => $value)
    {
        foreach($value as $col => $value2)
        {
            echo "<th scope=\"col\">".$value2."</td>";
        }
    }
    echo '</tr>
        </thead>
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
