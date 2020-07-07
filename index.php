<?PHP
$tables = [
    ['text' => 'Текст красного цвета',
        'cells' => '1,4,7',
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

function table_gen(array $tables, int $matrix, int $border = 1)
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
    $finTable = [];
    $continue = [];
    $tablesSize = $matrix * $matrix;

    for ($i = 1; $i <= $tablesSize; $i++){
        if (!in_array($i, $continue)){
            foreach ($tables as $tabl){
                if (in_array($i, $tabl['cells'])){
                    $finTable[$i]['cells'] = $i;
                    $finTable[$i]['align'] = $tabl['align'];
                    $finTable[$i]['valign'] = $tabl['valign'];
                    $finTable[$i]['color'] = $tabl['color'];
                    $finTable[$i]['bgcolor'] = $tabl['bgcolor'];
                    $finTable[$i]['text'] = $tabl['text'];
                    $finTable[$i]['rowspan'] = $tabl['rowspan'];
                    $finTable[$i]['colspan'] = $tabl['colspan'];
                    $passElement = count($tabl['cells']) - 1;
                    for ($p = 1; $p <= $passElement; $p++){
                        $finTable[$tabl['cells'][$p]]['cells'] = 'pass';
                        $continue[] = $tabl['cells'][$p];
                    }
                }
                else{
                    $finTable[$i]['cells'] = $i;
                }
            }
        }else{
            $finTable[$i]['cells'] = 'pass';
        }

    }
$cell = 1;
print_r($tables);
print_r($finTable);
    $www = "<table border=" . $border . ">";

    for ($i = 0; $i < $matrix; $i++){
        $www .= '<tr>';
        for ($k = 0; $k < $matrix; $k++, $cell++){
            if ($finTable[$cell]['cells'] !== 'pass'){
                if (count($finTable[$cell]) !== 1){
                    $www .= '<td colspan="'.$finTable[$cell]['colspan'].'" rowspan="'.$finTable[$cell]['rowspan'].'" 
                    align="'.$finTable[$cell]['align'].'"
                    valign="'.$finTable[$cell]['valign'].'"
                    bgcolor="'.$finTable[$cell]['bgcolor'].'"
                    style="color:'.$finTable[$cell]['color'].'">' .$finTable[$cell]['text']. '</td>';
                }else{
                    $www .= '<td></td>';
                }
            }
        }
        $www .= '</tr>';
    }
    $www .= '</table>';
    echo $www;
}

table_gen($tables, 3);

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



