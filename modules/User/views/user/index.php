<HTML>
<BODY bgcolor="#ffffe0" text="#2f4f4f">
<?php
    echo  "<table><thead>";
    foreach ($request_result[0]->result as $k => $v) {
        echo "<th style='border: 1px solid;background: #002548;color: #ffffff; padding: 5px 10px;'>$k</th>";
    }
    echo "<thead><tbody>";
    foreach ($request_result as $key => $value) {
        echo "<tr>";
        foreach ($value->result as $k => $v) {
            echo "<td style='border: 1px solid;background: #fafafa; padding: 5px 10px;'>$v</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
    dd($request_result);

?>

</BODY>
</HTML>
