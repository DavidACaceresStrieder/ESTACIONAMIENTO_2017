<?php 
	require_once('../lib/nusoap.php');	
	$server = new nusoap_server(); 
	$server->configureWSDL('WEB-SERVICE Loggin', 'urn:testWS'); 

	$server->wsdl->addComplexType(  'Numeros',
									'complexType',
									'struct',
									'all',
									'',
									array('n1' => array('name' => 'n1', 'type' => 'xsd:int'),
										  'n2' => array('name' => 'n2', 'type' => 'xsd:int'),
									)
								);
    
	

	$server->register('LogIn',                	// METODO
				array(),  						// PARAMETROS DE ENTRADA
				array(),    					// PARAMETROS DE SALIDA
				'urn:WebService',               // NAMESPACE
				'urn:WebService#LogIn',         // ACCION SOAP
				'rpc',                        	// ESTILO
				'encoded',                    	// CODIFICADO
				'Busca en la DB los empleados'  // DOCUMENTACION
				);

       

//5.- DEFINIMOS EL METODO COMO UNA FUNCION PHP
	function LogIn(){
        
	}


//6.- USAMOS EL PEDIDO PARA INVOCAR EL SERVICIO
	$HTTP_RAW_POST_DATA = file_get_contents("php://input");
	//http://php.net/manual/es/wrappers.php.php#wrappers.php.input
	
	$server->service($HTTP_RAW_POST_DATA);