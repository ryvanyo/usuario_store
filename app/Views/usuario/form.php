<?php
echo form_open("", ["enctype"=>"multipart/form-data"]);
echo csrf_field();
?>
    <?php
    if (!empty($success)) {
        echo '<div class="success">'.$success.'</div>';
    }
    
    ?>
    <table class="table-form">
        <tr>
            <td>
                <label>Nombre:</label>
            </td>
            <td>
                <?php
                echo form_input("u[nombre]", $usuario["nombre"], ["required"=>1]);
                if (isset($errores["nombre"])) {
                    echo '<div class="error">'.esc($errores["nombre"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label>Apellido:</label>
            </td>
            <td>
                <?php
                echo form_input("u[apellido]", $usuario["apellido"], ["required"=>1]);
                if (isset($errores["apellido"])) {
                    echo '<div class="error">'.esc($errores["apellido"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label>Sexo:</label>
            </td>
            <td>
                <label>
                    <?php
                    echo form_radio("u[sexo]", 'hombre', ($usuario["sexo"]=="hombre"));
                    ?>
                    Hombre
                </label>
                <label>
                    <?php 
                    echo form_radio("u[sexo]", 'mujer', ($usuario["sexo"]=="mujer"));
                    ?>
                    Mujer
                </label>
                <?php
                if (isset($errores["sexo"])) {
                    echo '<div class="error">'.esc($errores["sexo"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label>Teléfono:</label>
            </td>
            <td>
                <?php
                echo form_input("u[telefono]", $usuario["telefono"], ["required"=>1]);
                if (isset($errores["telefono"])) {
                    echo '<div class="error">'.esc($errores["telefono"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label>Dirección:</label>
            </td>
            <td>
                <?php
                echo form_textarea("u[direccion]", $usuario["direccion"]);
                if (isset($errores["direccion"])) {
                    echo '<div class="error">'.esc($errores["direccion"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <label>
                    <?php 
                    echo form_checkbox("u[extranjero]", 1, !empty($usuario["extranjero"]));
                    ?>
                    Es extranjero
                </label>
                <label>
                    <?php 
                    echo form_checkbox("u[becado]", 1, !empty($usuario["becado"]));
                    ?>
                    Es becado
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Carrera(s)</label>
            </td>
            <td>
                <?php
                echo form_dropdown("u[carrera]", [
                            "med" => "Medicina",
                            "der" => "Derecho",
                            "arq" => "Arquitectura",
                            "sis" => "Sistemas"
                        ], 
                        [$usuario["carrera"]]
                    );
                if (isset($errores["carrera"])) {
                    echo '<div class="error">'.esc($errores["carrera"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label>Foto</label>
            </td>
            <td>
                <?php
                echo form_upload("foto", "", ["accept"=>"image/png, image/jpeg"]);
                if (isset($errores["foto"])) {
                    echo '<div class="error">'.esc($errores["foto"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label>Título de Bachiller</label>
            </td>
            <td>
                <?php
                echo form_upload("titulo", "", ["accept"=>"image/png, image/jpeg"]);
                if (isset($errores["titulo"])) {
                    echo '<div class="error">'.esc($errores["titulo"]).'</div>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Registrar">
                &nbsp;&nbsp;&nbsp;<?php echo anchor("usuario/lista", "Volver a la lista"); ?>
            </td>
        </tr>
    </table>
<?php
echo form_close();