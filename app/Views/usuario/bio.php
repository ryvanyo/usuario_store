<?php echo view("common/adminlte/header"); ?>
    <script src="<?php echo base_url("ckeditor5/ckeditor.js"); ?>"></script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><?php echo anchor("/", "Inicio"); ?></li>
              <li class="breadcrumb-item active">Lista de usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body table-responsive p-0">
            <?php echo form_open(""); ?>
            <textarea name="bio_content" id="editor"><?php echo esc($content); ?></textarea>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <?php echo form_close(); ?>
        </div>
      </div>
      <!-- /.card -->
      <script>
          var uploader_url = "<?php echo site_url("usuario/upload_image"); ?>";
      </script>
      <script src="<?php echo base_url("js/bio_editor.js"); ?>"></script>
    </section>
    
    <!-- /.content -->
<?php echo view("common/adminlte/footer"); ?>


<?php 
return;

echo view("common/header", ["title"=>"Lista de usuarios"]); 
?>

<h1>Lista de usuarios</h1>
<?php 
echo '<p>'.anchor("usuario/nuevo", "Registrar nuevo usuario").'</p>';

if (isset($_GET["deleted"])) {
    echo "<p>";
    if (empty($_GET["deleted"])) {
        echo "No se pudo borrar el usuario.";
    } else {
        echo "Usuario borrado.";
    }
    echo "</p>";
}

if (!empty($lista)) {
?>
<table class="data">
    <tr>
        <th></th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Acciones</th>
    </tr>
    <?php
    foreach($lista as $row){
    ?>
    <tr>
        <td><?php
        if (!empty($row["foto"])) {
            echo '<img src="'.$usuario_model->get_thumbnail($row["foto"], 20, 20).'" alt="" >';
        } else {
            echo '<img src="'. base_url("img/usuario_default.png").'" alt="" height="20" >';
        }
        ?></td>
        <td><?php echo esc($row["nombre"]); ?></td>
        <td><?php echo esc($row["apellido"]); ?></td>
        <td><?php echo esc($row["telefono"]); ?></td>
        <td><?php echo esc($row["direccion"]); ?></td>
        <td>
            <?php echo anchor("usuario/editar?id=".$row["id"], "Editar"); ?>
             -
            <?php echo anchor("usuario/borrar/".$row["id"], "Borrar"); ?>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
<?php  
} else {
?>
<p>No hay usuarios registrados</p>
<?php
}

echo view("common/footer");
?>