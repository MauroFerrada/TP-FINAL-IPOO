<?php

class ResponsableV {
    private $nroEmpleado;
    private $nroLicencia;
    private $nombre;
    private $apellido;
    private $mensajeoperacion;

    public function __construct() {
        $this->nroEmpleado = "";
        $this->nroLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
        
    }

    public function getNroEmpleado() {
        return $this->nroEmpleado;
    }

    public function setNroEmpleado($nroEmpleado) {
        $this->nroEmpleado = $nroEmpleado;
    }

    public function getNroLicencia() {
        return $this->nroLicencia;
    }

    public function setNroLicencia($nroLicencia) {
        $this->nroLicencia = $nroLicencia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

  
    public function getSetMensajeOperacion() {
        return $this->mensajeoperacion;
    }
    public function setMensajeOperacion($mensajeoperacion) {
		$this->mensajeoperacion = $mensajeoperacion;
	}

    public function __toString() {
        return "Número de empleado: " . $this->getNroEmpleado() . "\n" . 
               "Número de licencia: " . $this->getNroLicencia() . "\n" . 
               "Nombre: " . $this->nombre . "\n" . 
               "Apellido: " . $this->apellido . "\n\n"; 
    }

    public function cargarResponsable($nroEmpleadoCargar, $nroLicenciaCargar,$nombreCargar, $apellidoCargar) {
        $this->nroEmpleado=$nroEmpleadoCargar;
        $this->nroLicencia=$nroLicenciaCargar;
        $this->nombre=$nombreCargar;
        $this->apellido=$apellidoCargar;   
    }



/**
* Lista a los pasajeros, se le puede pasar una condiciÃ³n para filtrar la lista
* @param string $condicion
* @return array $arregloResponsable
*/	
    public function listarResponsable($condicion = "") {
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable";
        if ($condicion != "") {
            $consultaResponsable = $consultaResponsable. ' where ' .$condicion;
        }
        $consultaResponsable .=" order by rnumeroempleado";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                $arregloResponsable = array();
                while ($row2 = $base->Registro()) {
                    $objResp = new ResponsableV();
                    $objResp->buscarResponsable($row2['rnumeroempleado']);
                    
                    array_push($arregloResponsable, $objResp);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloResponsable;
    }

    public function buscarResponsable($nroEmp) {
        $base= new BaseDatos();
        $consultaResponsable = "select * from responsable where rnumeroempleado=".$nroEmp;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row2 = $base->Registro()) {
                   
                    $this->cargarResponsable($nroEmp,$row2['rnumerolicencia'], $row2['rnombre'], $row2['rapellido']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function insertarResponsable() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido)
        VALUES (".$this->getNroLicencia().", '".$this->getNombre()."', '".$this->getApellido()."')";
      if($base->Iniciar()){
        $id = $base->devuelveIDInsercion($consultaInsertar);
        if($id != null){
            $resp=  true;
            $this->setNroEmpleado($id);
        }	else {
                $this->setMensajeOperacion($base->getError());
                
        }

    } else {
            $this->setMensajeOperacion($base->getError());
        
    }
    return $resp;
}

    public function modificarResponsable(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE responsable SET rnumerolicencia='".$this->getNroLicencia()."',rnombre='".$this->getNombre()."'
                           ,rapellido='".$this->getApellido()."' WHERE rnumeroempleado=". $this->getNroEmpleado();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function eliminarResponsable(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNroEmpleado();
				if($base->Ejecutar($consultaBorra)){
				    $resp = true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
}