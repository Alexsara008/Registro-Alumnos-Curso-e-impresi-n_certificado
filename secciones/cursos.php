<?php

//INSERT INTO `cursos` (`id`, `nombre_curso`) VALUES (NULL, 'Sitio Web con PHP');

include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();

// si detectamos si el post id tiene información la asignamos
// de lo contrario le ponemos nulo o vacío
$id=isset($_POST['id'])?$_POST['id']:'';
$nombre_curso=isset($_POST['nombre_curso'])?$_POST['nombre_curso']:'';
$accion = isset($_POST['accion'])?$_POST['accion']:'';          

// print_r($_POST);


if($accion!=''){

    switch($accion){
        

        case 'agregar':
                
            $sql="INSERT INTO cursos (id, nombre_curso) VALUES (NULL,:nombre_curso)";  //se pone dos puntos porque hace referencia que viene del valor de abajo linea 19
            $consulta=$conexionBD->prepare($sql);  //prepara la consulta
            $consulta->bindParam(':nombre_curso',$nombre_curso);  //le pasa un parámetro
            $consulta->execute(); //la ejecuta

            echo $sql;
        break;

        case 'editar': 
            // actualiza cursos cambiando el valor que viene en nombre cursos cuando el id sea igual a id
            $sql="UPDATE cursos SET nombre_curso=:nombre_curso WHERE id=:id ";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->bindParam(':nombre_curso',$nombre_curso);
            $consulta->execute();

        break;

        case 'eliminar':
            $sql="DELETE FROM cursos WHERE id=:id"; //se ejecuta la instriccuopm em cursos de aceurdo al id pasado
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
            echo $sql;
        break;
        
        //esto me permite que cuando aplaste el boton de seleccionar se tomen los datos que estan en la tabla, pero aun no muestro en el formulario
        case 'Seleccionar';
            $sql="SELECT * FROM cursos WHERE id=:id";  //seleccionamos el registro se busca por el id para acceder a la innformacion
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);  //se pasa el id que se está seleccionando
            $consulta->execute(); //se ejecuta la consulta
            $curso=$consulta->fetch(PDO::FETCH_ASSOC); //el fetch es para que me devuelva un solo registro
            $nombre_curso=$curso['nombre_curso'];  //se le asigna el nombre del curso 
            echo $nombre_curso;
        break;
    }
}




// consulta de datos
$consulta=$conexionBD->prepare("SELECT * FROM cursos");
$consulta->execute();
$listaCursos=$consulta->fetchAll();




?>


