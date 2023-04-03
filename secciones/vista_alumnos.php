<?php include('../templates/cabecera.php');?>
<?php include('../secciones/alumnos.php');?>

<div class="row">
    <div class="col-5">
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    Alumnos
                </div>
                <div class="card-body">

                    <div class="mb-3" hidden >
                      <label for="id" class="form-label">ID</label>
                      <input type="text"
                        class="form-control" name="id" id="id"   value="<?php  echo $id; ?>" aria-describedby="helpId" placeholder="ID">
                    </div>
               
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text"
                    class="form-control" name="nombre" id="nombre"  value="<?php  echo $nombre;?>"  aria-describedby="helpId" placeholder="nombre">

                </div>

                <div class="mb-3">
                  <label for="apellidos" class="form-label">Apellido</label>
                  <input type="text"
                    class="form-control" name="apellidos" id="apellidos" value="<?php  echo $apellidos;?>"  aria-describedby="helpId" placeholder="Escriba los apellidos">

                </div>

                <!-- este es el select que me permite seleccionar el curso del alumno -->
                <div class="mb-3">
                    <label for="" class="form-label">Curso del alumno</label>
                    <!-- el multiple class es para que se pueda seleccionar mas de una opcion -->
                    <select  multiple class="form-control" name="cursos[]" id="listaCursos"> 

                        <!-- este foreach es para que me muestre los cursos que existen en la base de datos  -->
                        <?php foreach($cursos as $curso){ ?>
                            <!-- ponemos el value para que me muestre o coja el id del curso para que se relacione y se inserte 
                        se recuepra el id y se inserta en alumnos_curso -->
                        <option
                        <?php 
                        // estamos preguntando si arregloCursos tienen algo y si tiene algo vamos a buscar
                        // en el id que le pertenece al curso y si lo encuentra lo va a seleccionar
                        //esta parte es para que cuando seleccionamos nos liste en el formulario los cursos que tiene el alumno
                            if(!empty($arregloCursos)):
                                if(in_array($curso['id'], $arregloCursos)):
                                    echo 'selected';
                                endif;


                            endif;
                        ?>
                        value="<?php echo $curso['id'];?>" >
                        <?php echo $curso['id'];?> - <?php echo $curso['nombre_curso'];?> </option>
                        </option>
                        
                        <?php }?>

                    </select>
                </div>

                <div class="btn-group" role="group" aria-label="Button group name">
                    <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="editar" class="btn btn-warning">Editar</button>
                    <button type="submit" name="accion" value="borrar" class="btn btn-danger">Borrar</button>
                </div>


                </div>
            </div>
        </form>
    </div>


    <div class="col-7">
        <form action="" method="post">
            <div class="table-responsive">
                <table class="table table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- name="accion"  -->
                        <?php foreach($alumnos as $alumno): ?>
                        <tr class="">
                            <td><?php echo $alumno['id'];?></td>
                            <td> 
                                <?php echo $alumno['nombre']; ?> <?php echo $alumno['apellidos']; ?> 
                                <br>
                                <!-- este forecah es para que me muestre los cursos que tiene el alumno -->
                                <?php foreach($alumno['cursos'] as $curso){ ?>
                                            <!-- // la variable nombre_curso es la que está en la base de datos -->
                                            - <a href="certificado.php?idcurso=<?php echo $curso['id']; ?>&idalumno=<?php echo $alumno['id'];?> " >
                                             <i class="bi bi-filetype-pdf text-danger"> </i> <?php echo $curso['nombre_curso']; ?>
                                        </a> <br>
                                            <!-- ponemos el enlace para que me lleve al certificado.php y le enviamos un parámetro del id del curso y del nombre para recueprar datos-->
                                            
                                <?php } ?> 
                            </td>


                            <td>
                            <form action="" method="post">

                            <input type="hidden" name="id" value=" <?php echo $alumno['id'];?>" >
                            <input name="accion" class="btn btn-info" type="submit" value="Seleccionar">
                        
                            </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            
        </form>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    //  con el TomSelect debemos convertir el id que es de los crusps
    new TomSelect('#listaCursos');
</script>

<?php include('../templates/pie.php');?>