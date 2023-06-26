<?php
require_once 'viaje.php';
require_once 'responsableV.php';
require_once 'BaseDatos.php';
require_once 'empresa.php';
require_once 'pasajero.php';

// Crear una nueva empresa de viajes
$empresa = new Empresa();
$empresa->setEmpnombre("Empresa XYZ");
$empresa->setEmpdireccion("Calle Principal 123");

if ($empresa->insertar()) {
    echo "Empresa creada exitosamente. ID de empresa: " . $empresa->getIdEmpresa() . "\n";
} else {
    echo "Error al crear la empresa: " . $empresa->getMensajeOperacion() . "\n";
}

// Modificar la información de la empresa
$empresa->setEmpdireccion("Empresa ABC");
$empresa->setEmpDireccion("Calle Secundaria 456");

if ($empresa->modificar()) {
    echo "Información de la empresa modificada exitosamente.\n";
} else {
    echo "Error al modificar la información de la empresa: " . $empresa->getMensajeOperacion() . "\n";
}

// Eliminar la empresa de viajes
if ($empresa->eliminar()) {
    echo "Empresa eliminada exitosamente.\n";
} else {
    echo "Error al eliminar la empresa: " . $empresa->getMensajeOperacion() . "\n";
}
?>