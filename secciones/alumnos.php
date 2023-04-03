<?php 

include_once '../configuraciones/bd.php';
$conexionDB=BD::crearInstancia();

$id=isset($_POST['id'])?$_POST['id']:'';
$nombre=isset($_POST['nombre'])?$_POST['nombre']:'';
$apellidos=isset($_POST['apellidos'])?$_POST['apellidos']:'';

$cursos=isset($_POST['cursos'])?$_POST['cursos']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';


if($accion !=""){
    switch($accion){
        case 'agregar':
            $sql="INSERT INTO alumnos (id,nombre,apellidos) VALUES (NULL,:nombre,:apellidos)";
            $consulta=$conexionDB->prepare($sql);
            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->execute();

            $idAlumno=$conexionDB->lastInsertId(); //esto va a recupera el ultimo id que se ha insertado en la tabla alumnos

            // vamos a insertar los cursos del alumno ya que recuperamos el id del alumno que se ha insertado y de acuerdo  a 
            // eso se va ir insertando los cursos que tiene el alumno

            foreach($cursos as $curso){
                $sql="INSERT INTO alumnos_cursos (id,idalumno,idcurso) VALUES (NULL,:idalumno,:idcurso)";
                $consulta=$conexionDB->prepare($sql);
                $consulta->bindParam(':idalumno',$idAlumno);
                $consulta->bindParam(':idcurso',$curso);
                $consulta->execute();
            }
           
        break;

        case 'Seleccionar':
            $sql="SELECT * FROM alumnos WHERE id=:id";
            $consulta=$conexionDB->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
            $alumno=$consulta->fetch(PDO::FETCH_ASSOC);
            $nombre=$alumno['nombre'];
            $apellidos=$alumno['apellidos'];

            // hacemos un select con inner join para recuperar los cursos que tiene el alumno
            $sql="SELECT cursos.id FROM alumnos_cursos
            INNER JOIN cursos ON cursos.id=alumnos_cursos.idcurso
            WHERE alumnos_cursos.idalumno=:idalumno";
            $consulta=$conexionDB->prepare($sql);
            $consulta->bindParam(':idalumno',$id); //enviamos un parametro que es el id del alumno
            $consulta->execute();
            $cursosAlumno=$consulta->fetchAll(PDO::FETCH_ASSOC);  //RECUPERAMOS LOS CURSOS QUE TIENE EL ALUMNO el FETCH_ASSOC es para que nos devuelva un arreglo asociativo
            
            // print_r($cursosAlumno);

            foreach($cursosAlumno as $curso){
                $arregloCursos[]=$curso['id'];
            }

        break;


        case 'editar':
            $sql="UPDATE alumnos SET nombre=:nombre,apellidos=:apellidos WHERE id=:id";
            $consulta=$conexionDB->prepare($sql);
            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->bindParam(':id',$id);
            $consulta->execute();

            // // ACTUALIZAR CURSOS
            // primero verificamos que existan cursos para actualizar 
            if(isset($cursos)){
                // hacemos el borrado de todos los cursos que se relacionaron con el alumno para poder ewscribir los nuevos cursos
                $sql="DELETE FROM alumnos_cursos WHERE idalumno=:idalumno";
                $consulta=$conexionDB->prepare($sql);
                $consulta->bindParam(':idalumno',$id);
                $consulta->execute();

                // con un foreach vamos a leer todos los datos que están relacionados
                foreach($cursos as $curso){
                    // luego hacemos la inserción de los nuevos cursos
                    $sql="INSERT INTO alumnos_cursos (id,idalumno,idcurso) VALUES (NULL,:idalumno,:idcurso)";
                    $consulta=$conexionDB->prepare($sql);
                    $consulta->bindParam(':idalumno',$id);
                    $consulta->bindParam(':idcurso',$curso);
                    $consulta->execute();
                }

                $arregloCursos=$cursos;

            }
        break;

        case 'borrar':
            $sql="DELETE FROM alumnos WHERE id=:id";
            $consulta=$conexionDB->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
        break;
    }
}



$sql="SELECT * FROM alumnos";
$listaAlumnos=$conexionDB->query($sql);
$alumnos=$listaAlumnos->fetchAll();

foreach($alumnos as $clave =>$alumno){
    // debemos tener en cuenta que los nombres idcurso y idalumno son los que están en la base de datos
    $sql="SELECT * FROM cursos  
    WHERE id IN (SELECT idcurso FROM alumnos_cursos WHERE idalumno=:idalumno)";
    
    $consulta=$conexionDB->prepare($sql);
    $consulta->bindParam(':idalumno',$alumno['id']);
    $consulta->execute();
    $cursosAlumno=$consulta->fetchAll();
    $alumnos[$clave]['cursos']=$cursosAlumno;
    

} 

$sql="SELECT * FROM cursos";  //se está consultado la tabla cursos que existen
$listaCursos=$conexionDB->query($sql);
$cursos=$listaCursos->fetchAll();  //se está recuperanndo la lista de los cursos que existen

?>