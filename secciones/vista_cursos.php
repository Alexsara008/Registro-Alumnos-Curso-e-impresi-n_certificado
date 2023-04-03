<?php include('../templates/cabecera.php');?>
<?php include('../secciones/cursos.php');?>


<!-- div para dividir el espacio del formulario -->
<div class="row">
        <div class="col-12">
          <br>
        <div class="row">
<div class="col-5">
    <br>
<form action="" method="post">

<div class="card">
    <div class="card-header">
        Cursos
    </div>
    <div class="card-body">
    <div class="mb-3 d-none">
        <!-- aqui para que se muestre los datos tanto el id como el nombre se debe poner el value e 
    mprimir la variable que se creo en el archivo cursos.php -->
  <label for="" class="form-label">ID</label>
  <input type="text"
    
    class="form-control" name="id" id="id" value="<?php  echo $id; ?>" aria-describedby="helpId" placeholder="ID">
</div>

<div class="mb-3">
  <label for="" class="form-label">NOMBRE</label>
  <input type="text"
    class="form-control" name="nombre_curso" id="nombre_curso"  value="<?php  echo $nombre_curso; ?>" aria-describedby="helpId" placeholder="Nombre">
</div>
    <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
    <button type="submit" name="accion" value="editar" class="btn btn-warning">Editar</button>
    <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>

    </div>

</div>

</form>

</div>

<!-- div para dividir el espacio de la tabla -->
<div class="col-7">
    <div class="table-responsive">
        <table class="table table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
<!-- 
                Esto me sirve para listar los registros de la base de datos
                el foreach es un metodo que me muestra todos los registros -->
                <?php foreach($listaCursos as $curso){ ?>
                <tr>
                    <td scope="row"> <?php echo $curso['id']; ?> </td> 
                    <td> <?php echo $curso['nombre_curso']; ?> </td>
                    <td>

                    <form action="" method="post">
                    <!-- El valor hidden es para que no se vea el id en la tabla, pero si se está enviando -->
                        <input type="hidden" name="id" id="id" value="<?php echo $curso['id']; ?>" > 
                        <input type="submit" value="Seleccionar" name="accion" class="btn btn-info" >
                    </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</div>
</div>
</div>
</div>


<?php include('../templates/pie.php');?>