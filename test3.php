<?php
require_once 'viaje.php';
require_once 'responsableV.php';
require_once 'BaseDatos.php';
require_once 'empresa.php';



// Crear una instancia de la clase Viaje
$viaje = new Viaje();

// Crear una instancia de la clase Empresa
$responsable = new ResponsableV();
$responsable->cargarResponsable("1","1","Mauro", "Ferrada");
$empresa = new Empresa();
$empresa->cargar(1, "Empresa 1", "Dirección 1");

// Asignar la empresa al objeto Viaje
$viaje->setEmpresa($empresa);
$viaje->setResponsableV($responsable);
$viaje->cargar(0,"ameri",0,0,$empresa, $responsable, 0 );

// Llamar al método insertar()
$inserto = $viaje->insertar();
if (!$inserto) {
    echo 'No se pudo realizar';
} else {
    echo 'Se insertó con éxito';
}
$objVia = new viaje();
$id = 3;
$objVia->buscar($id);

$nuevoNombre = readline("Ingrese nuevo destimo: ");
$nuevoDireccion = readline("Ingrese nuevo importe: ");

// Asignar los nuevos valores a la instancia de la clase Empresa
$objVia->setDestino($nuevoNombre);
$objVia->setCosto($nuevoDireccion);

// Llamar al método modificar() para guardar los cambios en la base de datos
$modificado = $objVia->modificar();

if (!$modificado) {
    echo 'No se pudo realizar la modificación.';
} else {
    echo 'Se modificó la empresa con éxito.';
}
?>
/*$objEmp2 = new Empresa();
$id = 5;
$objEmp2->buscar($id);
$eliminado = $objEmp2->eliminar();
if (!$eliminado) {
    echo 'No se pudo realizar la modificación.';
} else {
    echo 'Se modificó la empresa con éxito.';
}
?>