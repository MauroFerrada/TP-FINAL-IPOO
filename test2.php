<?php
require_once 'viaje.php';
require_once 'responsableV.php';
require_once 'BaseDatos.php';
require_once 'empresa.php';

// Crear una instancia de la clase Empresa
$oriNombre = readline("Ingrese nuevo nombre: ");
$oriDireccion = readline("Ingrese nueva dirección: ");
$empresa = new Empresa();
$empresa->cargar(1, $oriNombre, $oriDireccion);
//$empresa2 = new Empresa();
//$empresa2->cargar(2, "Empresa 2", "Direccion 2");
 //Insertar la empresa en la base de datos
$inserto = $empresa->insertar();
if (!$inserto) {
    echo 'no se pudo realizar';
}else {
    echo 'se inserto con exito';
}
/*$objEmp = new Empresa();
$id = 3;
$objEmp->buscar($id);

$nuevoNombre = readline("Ingrese nuevo nombre: ");
$nuevoDireccion = readline("Ingrese nueva dirección: ");

// Asignar los nuevos valores a la instancia de la clase Empresa
$objEmp->setEmpnombre($nuevoNombre);
$objEmp->setEmpdireccion($nuevoDireccion);

// Llamar al método modificar() para guardar los cambios en la base de datos
$modificado = $objEmp->modificar();

if (!$modificado) {
    echo 'No se pudo realizar la modificación.';
} else {
    echo 'Se modificó la empresa con éxito.';
}

$objEmp2 = new Empresa();
$id = 5;
$objEmp2->buscar($id);
$eliminado = $objEmp2->eliminar();
if (!$eliminado) {
    echo 'No se pudo realizar la modificación.';
} else {
    echo 'Se modificó la empresa con éxito.';
}*/
?>