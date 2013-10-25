<?php
session_start();
$nbtables = $_GET['nbtables'];
$tables = $_SESSION['tables'];

$colsByTable = array();
for ($i = 0; $i < $nbtables; $i++ ){
    $id = $id+1;
    $tb = $tables[$i];
    $cols = array();
    $infos = array();
    for ($j = 0; $j < $tb[1]; $j++){
        $col = array();
        $idcol = $j+1;
        $name = $_GET['colname'.$idcol.'-'.$id];
        $type = $_GET['typecol'.$idcol.'-'.$id];
        array_push($col, $name);
        array_push($col, $type);    
        array_push($cols, $col);
    }
    array_push($infos, $id);
    array_push($infos, $tb[0]);
    array_push($infos, $cols);
    array_push($colsByTable, $infos);
}

echo "<pre>";
print_r($colsByTable);     
echo "</pre>";
session_destroy();
?>