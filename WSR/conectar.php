<?php
class conectar extends PDO
{
	private $servidor = "jhdjjtqo9w5bzq2t.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
	private $nombreBd = "n4ri2lcee1wd01m1";
	private $usuarioBd = "n26pgrpxnjyg2980";
	private $contra = "dtxl5943hu6hd1e9";

		public function __construct()
		{
			try{
				parent::__construct('mysql:host=' . $this->servidor . ';dbname=' . $this->nombreBd . ';charset = utf8',  $this->usuarioBd, $this->contra, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

				} catch(PDOException $e){
				echo ' Ha ocurrido un error:' . $e->getMessage();
				exit;
			   }

		} 

}
?>
