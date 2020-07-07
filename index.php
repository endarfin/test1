<?PHP
function table_gen(array $tables, int $matrix, int $border = 1)
{
    $tablesSize = $matrix * $matrix;

    foreach ($tables as &$table) {
        $rowOrCol = true;
        if (isset($table['cells']) && $table['cells'] !== '') {
            $table['cells'] = explode(',', $table['cells']);
            $count = count($table['cells']) - 1;
            for ($i = 0; $i < $count; $i++){
                if ($table['cells'][$i + 1] == $table['cells'][$i] + 1 && $rowOrCol){
                    if ($table['cells'][0] % $matrix == 0){
                        echo 'Некорректные входные данные 5';
                        return;
                    }
                    if (empty($table['colspan'])){
                        $table['colspan'] = 2;
                        continue;
                    }else{
                        $table['colspan'] += 1;
                        continue;
                    }
                }else{
                    $rowOrCol = false;
                }
                if ($table['cells'][$i + 1] == $table['cells'][$i] + 1 && !$rowOrCol){
                    if (empty($table['rowspan'])){
                        $table['rowspan'] = 2;
                        continue;
                    }else{
                        $table['rowspan'] += 1;
                        continue;
                    }
                }
                if ($table['cells'][$i + 1] == $table['cells'][$i] + $matrix && !$rowOrCol){
                    if (empty($table['rowspan'])){
                        $table['rowspan'] = 2;
                        continue;
                    }else{
                        $table['rowspan'] += 1;
                        continue;
                    }
                }
                if ($table['cells'][$i + 1] !== $table['cells'][$i] + $matrix && !$rowOrCol && empty($table['colspan'])){
                        echo 'Некорректные входные данные 5';
                        return;
                }

            }
        }
    }

    //
    $allCells = [];
    foreach($tables as $cells){
        $allCells = array_merge($allCells,$cells['cells']);
        $count = count($cells['cells']) - 1;
        for ($i = 0; $i < $count; $i++){
            if ($cells['cells'][$i + 1] < $cells['cells'][$i]){
                echo 'Некорректные входные данные 1';
                return;
            }
        }
    }

    if (!(count($allCells) == count(array_unique($allCells)))){
        echo 'Некорректные входные данные 2';
        return;
    }

    if (array_pop($allCells) > $tablesSize){
        echo 'Некорректные входные данные 3';
        return;
    }



    $finTable = [];
    $continue = [];


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

    $www = "<table border=" . $border . ">";

    for ($i = 0; $i < $matrix; $i++){
        $www .= '<tr>';
        for ($k = 0; $k < $matrix; $k++, $cell++){
            if ($finTable[$cell]['cells'] != 'pass'){
                if (count($finTable[$cell]) != 1){
                    $www .= '<td colspan="'.$finTable[$cell]['colspan'].'" rowspan="'.$finTable[$cell]['rowspan'].'" 
                    align="'.$finTable[$cell]['align'].'"
                    valign="'.$finTable[$cell]['valign'].'"
                    bgcolor="'.$finTable[$cell]['bgcolor'].'"
                    style="color:'.$finTable[$cell]['color'].'">' .$finTable[$cell]['text']. '</td>';
                }else{
                    $www .= '<td>'.$cell.'</td>';
                }
            }
        }
        $www .= '</tr>';
    }
    $www .= '</table>';
    echo $www;
}

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

$tables2 = [
    ['text' => 'Текст красного цвета',
        'cells' => '1,2,3',
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
$tables3 = [
    ['text' => 'Текст красного цвета',
        'cells' => '1,4,7',
        'align' => 'center',
        'valign' => 'center',
        'color' => 'FF0000',
        'bgcolor' => '0000FF'],
    ['text' => 'Текст зеленого цвета',
        'cells' => '5,6,8,9',
        'align' => 'right',
        'valign' => 'bottom',
        'color' => '00FF00',
        'bgcolor' => 'FFFFFF']

];
$tables4 = [
    ['text' => 'Текст красного цвета',
        'cells' => '2,5,8',
        'align' => 'center',
        'valign' => 'center',
        'color' => 'FF0000',
        'bgcolor' => '0000FF'],
    ['text' => 'Текст зеленого цвета',
        'cells' => '6,9',
        'align' => 'right',
        'valign' => 'bottom',
        'color' => '00FF00',
        'bgcolor' => 'FFFFFF']

];
$tables5 = [
    ['text' => 'Текст красного цвета',
        'cells' => '1,2,3',
        'align' => 'center',
        'valign' => 'center',
        'color' => 'FF0000',
        'bgcolor' => '0000FF'],
    ['text' => 'Текст зеленого цвета',
        'cells' => '5,6,8,9',
        'align' => 'right',
        'valign' => 'bottom',
        'color' => '00FF00',
        'bgcolor' => 'FFFFFF']

];

table_gen($tables3, 3);
table_gen($tables2, 3);
table_gen($tables4, 3);
table_gen($tables5, 3);
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



