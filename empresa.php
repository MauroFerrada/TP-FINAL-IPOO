<?php

class Empresa {
    private $idEmpresa;
    private $enombre;
    private $edireccion;
    private $mensajeOperacion;

    public function __construct()
    {
        $this-> idEmpresa = 0;
        $this-> enombre = "";
        $this-> edireccion = "";
      
    }
    public function getIdEmpresa(){
        return  $this-> idEmpresa;
    }

    public function setIdEmpresa($idEmpresaCargar) {
        $this->idEmpresa = $idEmpresaCargar;
      }

    public function getEmpnombre(){
        return  $this-> enombre;
    }

    public function setEmpnombre($enombreCargar) {
        $this->enombre = $enombreCargar;
      }

    public function getEmpdireccion(){
        return  $this-> edireccion;
    }

    public function setEmpdireccion($empDireccionCargar) {
        $this->edireccion = $empDireccionCargar;
      }
      public function getMensajeOperacion(){
        return  $this-> mensajeOperacion;
    }
    
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
      }


      public function cargar($idEmpresaCargar, $enombreCargar, $empDireccionCargar) {
        $this->idEmpresa=$idEmpresaCargar;
        $this->enombre=$enombreCargar;
        $this->edireccion=$empDireccionCargar;
    }



    /**
	 * Recupera los datos de una empresa por id
	 * @param int $idEmpresa
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function buscar($idEmpresa){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idEmpresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($row2=$base->Registro()){
					$this->cargar($idEmpresa,$row2['enombre'],$row2['edireccion']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setMensajeOperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setMensajeOperacion($base->getError());
		 	
		 }		
		 return $resp;
	}

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(enombre, edireccion)
				VALUES ('".$this->getEmpnombre()."','".$this->getEmpdireccion()."')";
		
		if($base->Iniciar()){
            $id = $base->devuelveIDInsercion($consultaInsertar);
			if($id != null){
				$resp=  true;
				$this->setIdEmpresa($id);
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
* @return array $arregloEmpresa
*/	
	public function listar($condicion=""){
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresa = "Select * FROM empresa";
        if($condicion !=""){
            $consultaEmpresa = $consultaEmpresa. ' where ' .$condicion;
        }
        $consultaEmpresa .=" order by enombre";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaEmpresa)){
                $arregloEmpresa = array();
                while($row2 = $base->Registro()){

                    $idEmpresa = $row2['idempresa'];
                    $nombre = $row2['enombre'];
                    $direccion = $row2['edireccion'];

                   // $objViaje = new Viaje();
                   //$colViajes = $objViaje->listar('idempresa='.$idEmpresa);

                    $empre= new Empresa();
                    $empre->cargar($idEmpresa, $nombre, $direccion, []);

                    array_push($arregloEmpresa, $empre);
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloEmpresa;
    }
    

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModificar="UPDATE empresa SET enombre='".$this->getEmpnombre()."', edireccion='".$this->getEmpdireccion()."' WHERE idempresa=".$this->getIdEmpresa();
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
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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
	    return "\nID empresa: ".$this->getIdEmpresa(). "\n Nombre de la empresa:".$this->getEmpnombre()."\n Direccion: ".$this->getEmpdireccion()."\n";
			
	}
    }