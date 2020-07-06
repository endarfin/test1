<?PHP
$tables = [
    ['text' => 'Текст красного цвета',
        'cells' => '1,2,4,5',
        'align' => 'center',
        'valign' => 'center',
        'color' => 'FF0000',
        'bgcolor' => '0000FF'],
    ['text' => 'Текст зеленого цвета',
        'cells' => '8,9',
        'align' => 'right',
        'valign' => 'bottom',
        'color' => '00FF00',
        'bgcolor' => 'FFFFFF']
];

function table_gen(array $tables, $rows, $cols, $border = 1)
{
    foreach ($tables as &$table) {
        $rowOrCol = true;
        if (isset($table['cells']) && $table['cells'] !== '') {

            $table['cells'] = explode(',', $table['cells']);
            $lastEl = $table['cells'][count($table['cells']) - 1];
            $first = $table['cells'][0];
            $count = 0;

            for ($i = $first; $i <= $lastEl; $i++) {

                if ($table['cells'][$count] == $i) {

                    if ($rowOrCol) {

                        $table['colspan'] += 1;
                        $count++;

                    } else {

                        $table['rowspan'] += 1;
                        $count++;

                    }
                } else {

                    $rowOrCol = false;

                }
            }
        }
    }

    $www = "<table border=" . $border . ">";

    $tableSetting = 0;
    for ($col = 1; $col <= $cols; $col++) {
        $countRow = 0;
        $www .= '<tr>';
        for ($row = 1; $row <= $rows; $row++) {
            if (isset($tables[$tableSetting])) {
                //
                if (isset($tables[$tableSetting]['rowspan']) && isset($tables[$tableSetting]['colspan'])) {
                    $www .= '<td colspan="2" rowspan="2" 
                    align="'.$tables[$tableSetting]['align'].'"
                    valign="'.$tables[$tableSetting]['valign'].'"
                    bgcolor="'.$tables[$tableSetting]['bgcolor'].'"
                    style="color:'.$tables[$tableSetting]['color'].'">' .$tables[$tableSetting]['text']. '</td>';
                    $countRow = $rows - $tables[$tableSetting]['colspan'];
                    $row = $tables[$tableSetting]['colspan'];
                    $countCol = $cols - $tables[$tableSetting]['rowspan'];
                    for ($i = 0; $i < $countRow; $i++) {
                        $www .= '<td></td></tr>';
                        $row++;
                    }
                    for ($i = 0; $i < $countCol; $i++) {
                        $www .= '<tr><td></td></tr>';
                        $col++;
                    }
                }
                //
                if (isset($tables[$tableSetting]['colspan']) && empty($tables[$tableSetting]['rowspan'])) {
                    $countRow = $rows - $tables[$tableSetting]['colspan'];
                    for ($i = 0; $i < $countRow; $i++) {
                        $www .= '<td></td>';
                        $row = $tables[$tableSetting]['colspan'] + 1;
                    }
                    $www .= '<td  colspan="2" 
                    align="'.$tables[$tableSetting]['align'].'"
                    valign="'.$tables[$tableSetting]['valign'].'"
                    bgcolor="'.$tables[$tableSetting]['bgcolor'].'"
                    style="color:'.$tables[$tableSetting]['color'].'" >' .$tables[$tableSetting]['text']. '</td></tr>';
                }
            }else{
                $www .= '<td></td>';
            }
        }
        $tableSetting++;
        $www .= '</tr>';
    }
    $www .= '</table>';
    echo $www;
}

table_gen($tables, 3, 3);

?>

<style>
    table {
        height: 400px;
        width: 400px;

    }

    td {
        height: 100px;
        width: 100px;
    }
</style>



