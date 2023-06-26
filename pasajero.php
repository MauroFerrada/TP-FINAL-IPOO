<?php

class Pasajero {
    private $nombre;
    private $apellido;
    private $numDoc;
    private $telefono;
    private $mensajeOperacion;
    private $objViaje;

    public function __construct()
    {
        $this-> nombre = "";
        $this-> apellido = "";
        $this-> numDoc = "";
        $this-> telefono = "";
        $this-> objViaje = new Viaje();
    }
    public function getNombre(){
        return  $this-> nombre;
    }

    public function setNombre($nombreCargar) {
        $this->nombre = $nombreCargar;
      }

    public function getApellido(){
        return  $this-> apellido;
    }

    public function setApellido($apellidoCargar) {
        $this->apellido = $apellidoCargar;
      }

    public function getNumDoc(){
        return  $this-> numDoc;
    }

    public function setNumDoc($dniCargar) {
        $this->numDoc = $dniCargar;
      }

    public function getTelefono(){
        return  $this-> telefono;
    }

    public function setTelefono($telCargar) {
        $this->telefono = $telCargar;
      }

    public function getMensajeOperacion(){
        return  $this-> mensajeOperacion;
    }
    

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
      }

      public function getObjViaje(){
        return  $this-> objViaje;
    }

    public function setObjViaje($objViaje) {
        $this->objViaje = $objViaje;
      }





    public function cargar($dniCargar, $nombreCargar, $apellidoCargar ,$telCargar) {
        $this->numDoc=$dniCargar;
        $this->nombre=$nombreCargar;
        $this->apellido=$apellidoCargar;
        $this->telefono=$telCargar;
    }

    public function buscarPasajero($dni){
        $base=new BaseDatos();
		$consultaPasajero="Select * from pasajero where pdocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($row2=$base->Registro()){
				   $objViaje = new Viaje();
                   $objViaje-> buscar($row2['idviaje']);
                   $this->cargar($dni, $row2['pnombre'],$row2['papellido'], $objViaje, $row2['ptelefono'],);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsentar = "INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje)
        VALUES (".$this->getNumDoc().", '".$this->getNombre()."', '".$this->getApellido()."', '".$this->getTelefono()."', '".$this->getObjViaje()->getCodigoViaje()."')";
        if($base->Iniciar()){

			if($base->Ejecutar($consultaInsentar)){
			    $resp=  true;

			}	else {
					$this->setMensajeOperacion($base->getError());
					
			}

		} else {
				$this->setMensajeOperacion($base->getError());
			
		}
		return $resp;
	
    }

/**
* Lista a los pasajeros, se le puede pasar una condiciÃ³n para filtrar la lista
* @param string $condicion
* @return array $arregloPasajero
*/	
    public function listar($condicion=""){
        $arregloPasajero = null;
        $base = new BaseDatos();
        $consultaPasajero = "Select * from pasajero";
        if($condicion !=""){
            $consultaPasajero = $consultaPasajero. ' where ' .$condicion;
        }
        $consultaPasajero .=" order by papellido";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                $arregloPasajero = array();
                while($row2 = $base->Registro()){

                    $numDoc = $row2 ['pdocumento'];
                    $nombre = $row2 ['pnombre'];
                    $apellido = $row2 ['papellido'];
                    $telefono = $row2 ['ptelefono'];

                    $objViaje = new Viaje();
                    $objViaje->buscar($row2 ['idviaje']);

                    $pasaj = new Pasajero();
                    $pasaj->cargar($numDoc, $nombre, $apellido, $telefono, $objViaje);

                    array_push($arregloPasajero, $pasaj);
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloPasajero;
    }


    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModificar="UPDATE pasajero SET pnombre='".$this->getNombre()."',papellido='".$this->getApellido()."'
                           ,ptelefono='".$this->getTelefono()."',idviaje=". $this->getObjViaje()->getCodigoViaje()."' WHERE pdocumento=".$this->getNumDoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModificar)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM pasajero WHERE pdocumento=".$this->getNumdoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    public function __toString(){
	    return "\nNombre: ".$this->getNombre(). "\n Apellido:".$this->getApellido()."\n DNI: ".$this->getNumdoc()."\n Telefono: ".$this->getTelefono()."\n";
			
	}
}