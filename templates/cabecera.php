<?php
// vamos a validar para que no se ingresen poniendo la direccion, es una norma de seguridad
// se lo hace en la cabecera porque ahi se encuentra en todos los módulos
session_start();
// el SESSION sirve para que no se pueda ingresar a la pagina sin haber iniciado sesion
if (!isset($_SESSION['usuario'])) {
    header('Location:../index.php');
}


?>



<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- Bootstrap Icons v1.10.3 Enlace íconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body>
  <!-- barra de navegación -->
<nav class="navbar navbar-expand navbar-light bg-light">
              <div class="nav navbar-nav">
                  <a class="nav-item nav-link active" href="index.php" >Inicio</a>
                  <a class="nav-item nav-link" href="vista_alumnos.php">Alumnos</a>
                  <a class="nav-item nav-link" href="vista_cursos.php">Cursos</a>
                  <a class="nav-item nav-link" href="cerrar.php">Cerrar sesión</a>
              </div>
          </nav>


    <div class="container">

