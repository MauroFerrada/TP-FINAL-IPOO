<?php



class Viaje {
  private $codeViaje;

  private $destino;

  private $cantMaxPasajeros;

  private $responsableV; 

  private $pasajeros;

  private $costo;

  private $sumaCostos;

  private $empresa;

  private $mensajeOperacion;

  public function __construct() {
    $this->codeViaje = 0;
    $this->destino = "";
    $this->cantMaxPasajeros = 0;
    $this->responsableV = new ResponsableV();
    $this->costo = 0;
    $this->empresa = new empresa();
    $this->pasajeros = []; 
  }
/** Devuelve el valor actual almacenado en el atributo responsable
    * @return Empresa $empresa
    */
  public function getEmpresa(){
    return $this->empresa;
  }
/** Coloca el valor pasado por parámetro en el atributo responsable 
    *@param Empresa $empresa
    */
  public function setEmpresa($empresa){
    $this->empresa = $empresa;
  }

  public function getSumaCostos(){
    return $this->sumaCostos;
  }
  

  public function setSumaCostos($sumaCostos){
    $this->sumaCostos = $sumaCostos;
  }
/** Devuelve el valor actual almacenado en el atributo costo
    * @return $costo
    */
  public function getCosto(){
    return $this->costo;
  }
/** Coloca el valor pasado por parámetro en el atributo costo 
    *@param float $costo 
    */
  public function setCosto($costo){
    $this->costo = $costo;
  }
/** Coloca el valor pasado por parámetro en el atributo responsable 
    *@param Responsable $responsableV
    */
  public function setResponsableV($responsableV){

    $this->responsableV = $responsableV;

  }
/** Devuelve el valor actual almacenado en el atributo responsable
    * @return Responsable $responsableV
    */
  public function getResponsableV(){

    return $this->responsableV;

  }
/** Devuelve el valor actual almacenado en el atributo cod_viaje
    * @return int */
  public function getCodigoViaje() {

    return $this->codeViaje;

  }
/** Coloca el valor pasado por parámetro en el atributo cod_viaje
    *@param int $codeviaje */
  public function setCodigoViaje($codeViaje) {

    $this->codeViaje = $codeViaje;

  }
/*Devuelve el valor actual almacenado en el atributo destino
    @return string $destino*/
  public function getDestino() {

    return $this->destino;

  }
/** Coloca el valor pasado por parámetro en el atributo destino
    * @param string $destino */
  public function setDestino($destino) {

    $this->destino = $destino;

  }
/** Devuelve el valor actual almacenado en el atributo cantMaximaPasajeros
    * @return int $cantMaxPasajeros
    */
  public function getCantMaxPasajeros() {

    return $this->cantMaxPasajeros;

  }
 /** Coloca el valor pasado por parámetro en el atributo cantMaximaPasajeros
    * @param int $cantMaxPasajeros 
    */
  public function setCantMaxPasajeros($cantMaxPasajeros) {

    $this->cantMaxPasajeros = $cantMaxPasajeros;

  }
/** Devuelve el valor actual almacenado en el atributo pasajeros
    * @return array $pasajeros
    */
  public function getPasajeros(){

    return $this->pasajeros;

  }
 /** Coloca el valor pasado por parámetro en el atributo pasajeros 
    *@param array $pasajeros 
    */
  public function setPasajeros ($pasajeros){

    $this->pasajeros = $pasajeros;

  }
  public function getMensajeOperacion(){
    return  $this-> mensajeOperacion;
}


public function setMensajeOperacion($mensajeOperacion) {
    $this->mensajeOperacion = $mensajeOperacion;
  }


  public function cargar($empresaCargar, $destinoCargar, $cantMaxPasajerosCargar ,$codeViajeCargar, $responsableCargar, $costoCargar, $pasajerosCargar) {
    $this->empresa=$empresaCargar;
    $this->destino=$destinoCargar;
    $this->cantMaxPasajeros=$cantMaxPasajerosCargar;
    $this->codeViaje=$codeViajeCargar;
    $this->costo=$costoCargar;
    $this->responsableV=$responsableCargar;
    $this->pasajeros=$pasajerosCargar;
}

public function mostrarPasajeros(){
    $mensaje = '';
    $colPasajeros = $this->getPasajeros();
    if(count($colPasajeros)>0){
        for ($i=0; $i < count($colPasajeros); $i++) { 
            $mensaje .= '---------------' . "\n" . $colPasajeros[$i]."\n";
        }
}
return $mensaje;
}

public function buscar($codeViaje){
    $base=new BaseDatos();
    $consultaViaje="Select * from viaje where idviaje=".$codeViaje;
    $resp= false;
    if($base->Iniciar()){
        if($base->Ejecutar($consultaViaje)){
            if($row2=$base->Registro()){
               $objEmpresa = new Empresa();
               $objEmpresa-> buscar($row2['idempresa']);
               $objResponsable = new ResponsableV();
               $objResponsable-> buscarResponsable($row2['rnumeroempleado']);
               $this->cargar($objEmpresa, $row2['vdestino'],$row2['vcantmaxpasajeros'],$codeViaje ,$objResponsable, $row2['vimporte'],[]);
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
//esta funcionn trae los datos de los pasajeros de la base de datos, y los setea en la clase
public function traePasajeros(){
    $pasajero = new Pasajero();
    $condicion = "idviaje =".$this->getCodigoViaje();
    $colPasajeros = $pasajero->listar($condicion);
    $this->setPasajeros($colPasajeros);
}

public function insertar(){
    $base = new BaseDatos();
    $resp = false;
    $consultaInsentar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
    VALUES ('" . $this->getDestino() . "', " . $this->getCantMaxPasajeros() . ", " . $this->getEmpresa()->getIdEmpresa() . ", " . $this->getResponsableV()->getNroEmpleado() . ", " . $this->getCosto() . ")";
    if($base->Iniciar()){
        $id = $base->devuelveIDInsercion($consultaInsentar);
        if($id !=null){
            $resp=  true;
            $this->setCodigoViaje($id);
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
* @return array $arregloViajes
*/	
public function listar($condicion=""){
    $arregloViajes = null;
    $base = new BaseDatos();
    $consultaViaje = "Select * FROM viaje";
    if($condicion !=""){
        $consultaViaje = $consultaViaje. ' WHERE ' .$condicion;
    }
    $consultaViaje .=" order by idviaje";

    if($base->Iniciar()){
        if($base->Ejecutar($consultaViaje)){
            $arregloViajes = array();
            while($row2 = $base->Registro()){
                $ObjViaje = new Viaje();
                $ObjViaje ->buscar($row2['idviaje']);
                array_push($arregloViajes, $ObjViaje);
                
                
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }

    }else{
        $this->setMensajeOperacion($base->getError());
    }
    return $arregloViajes;
}

public function modificar(){
    $resp =false; 
    $base=new BaseDatos();
    $consultaModificar="UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros='".$this->getCantMaxPasajeros()."'
                       ,idempresa='".$this->getEmpresa()->getIdEmpresa()."',rnumeropasajero=". $this->getResponsableV()->getNroEmpleado()."' WHERE idviaje".$this->getCodigoViaje();
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
      $consultaEliminaPasajeros = "DELETE FROM pasajero WHERE idviaje = " . $this->getCodigoViaje();
      if ($base->Ejecutar($consultaEliminaPasajeros)) {
            $consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getCodigoViaje();
            if($base->Ejecutar($consultaBorra)){
                $resp=  true;
            }else{
                    $this->setmensajeoperacion($base->getError());
                
            }
          }else {
            $this->setmensajeoperacion($base->getError());
          }
    }else{
            $this->setmensajeoperacion($base->getError());
        
    }
    return $resp; 
}
public function __toString(){
  
  return "Código de viaje: " . $this->getCodigoViaje() . "\n".
  "Destino: " . $this->getDestino() . "\n" .
  "Cantidad máxima de pasajeros: " . $this->getCantMaxPasajeros() . "\n".
  "Costo: " . $this->getCosto() . "\n" . 

  "Empresa: " . $this->getEmpresa() . "\n" .
  "Responsable: " . "\n" .$this->getResponsableV() . "\n" ;
}
}