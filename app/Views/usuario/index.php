<?php
echo view("store/header");

echo '<table border=1>';
echo '<tr>';
echo '<th>Nombre</th>';
echo '<th>Apellido</th>';
echo '<th>Sexo</th>';
echo '</tr>';
foreach($usuarios as $usuario){
    echo '<tr>';
    echo '<td>'.$usuario['nombre'].'</td>';
    echo '<td>'.$usuario['apellido'].'</td>';
    echo '<td>'.$usuario['sexo'].'</td>';
    echo '</tr>';
}
echo '</table>';

echo view("store/footer");
?>