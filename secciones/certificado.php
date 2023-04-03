<?php  

// ya no viene con método post si no con método get 
require('../librerias/fpdf/fpdf.php');

//linea de código que me permite conectar con la base de datos
include_once '../configuraciones/bd.php';
$conexionDB=BD::crearInstancia();

// vamos a crear una función que nos permite agregar el texto una y otra vez
function agregarTexto($pdf,$texto,$x,$y,$align='L',$fuente,$size=10,$r=0,$g=0,$b=0){
    $pdf->SetFont($fuente,"",$size);
    $pdf->SetXY($x, $y);  //es para las posiciones x y y para poder controlar
    $pdf->SetTextColor($r,$g,$b ); //es para el color del texto
    $pdf->Cell(0,10,$texto,0,0,$align); //es para el tamaño de la celda y alineacion - texto - ancho alto - alineacion
}

// vamos a crear una función que nos permite agregar una imagen
function agregarImagen($pdf, $imagen, $x, $y){
    $pdf->Image($imagen, $x, $y, 0);
}




$idcurso=isset($_GET['idcurso'])?$_GET['idcurso']:'';
$idalumno=isset($_GET['idalumno'])?$_GET['idalumno']:'';

$sql="SELECT alumnos.nombre, alumnos.apellidos, cursos.nombre_curso 
FROM alumnos, cursos WHERE alumnos.id=:idalumno AND cursos.id=:idcurso";
$consulta=$conexionDB->prepare($sql);   
$consulta->bindParam(':idalumno',$idalumno);
$consulta->bindParam(':idcurso',$idcurso);
$consulta->execute();
$alumno=$consulta->fetch(PDO::FETCH_ASSOC); 



// instansacion para crear el PDF en tamaño y medida
$pdf=new FPDF('L','mm',array(180,330)); //es para el tamaño de la hoja
$pdf->AddPage(); //es para agregar una pagina
$pdf->setFont('Arial','B',16); //es para el tipo de letra, negrita, tamaño
agregarImagen($pdf, '../src/certificado.jpg',0,0); //es para agregar una imagen con la función que creamos
agregarTexto($pdf,ucwords(utf8_decode($alumno['nombre']." ".$alumno['apellidos'])),120,75,'L',"Helvetica",30,0,84,115); //es para agregar el texto con la función que creamos
agregarTexto($pdf, $alumno['nombre_curso'],110,115,'L',"Helvetica",20,0,84,115);
agregarTexto($pdf,date("d/m/Y"),123,139,'L',"Helvetica",16,0,84,115);
$pdf->Output(); //es para que se muestre en pantalla el pdf o saque el pdf que tenemos

print_r();
print_r($alumno['nombre_curso']);

?>