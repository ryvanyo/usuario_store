<?php 
echo view("common/header", ["title"=>"Notificaciones"]); 
?>
<h1>Notificaciones</h1>
<p><?php echo $descripcion; ?></p>
<?php
if (!empty($success)) {
    echo '<p>Su mensaje fue enviado</p>';
}
echo form_open("", ["class"=>"frm"]);
?>
<table class="table-form">
    <tr>
        <td>Asunto</td>
        <td><?php echo form_input("m[subject]", $message["subject"], ["required"=>1]); ?></td>
    </tr>
    <tr>
        <td>Mensaje</td>
        <td><?php echo form_textarea("m[message]", $message["message"], ["required"=>1]); ?></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button type="submit">Enviar</button>
        </td>
    </tr>
</table>
<p>
    Para que funcione no olvides completar la configuración de correo con los datos de tu cuenta de gmail en el archivo
    <code>app/config/Email.php</code>
</p>
<p>
    También va ser necesario realizar la siguiente configuración en tu cuenta de Gmail, como se muestra en la siguiente imagen.
</p>
<img src="<?php echo base_url("/img/gmail.gif"); ?>" alt="">
<?php
echo form_close();
echo view("common/footer");
?>