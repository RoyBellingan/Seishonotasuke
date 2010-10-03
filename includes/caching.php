<?php


/**
 * @author roy
 * non mi piace calcolare le stesse cose più volte -.-
 */
class cache
{


	var $type; // Tipo di cache 1 memcache 2 mysql 0 disabilitato
	var $memcache; //La classe del memcache
	var $db;
	var $status; //Stato dell'ultima chiamata, in genere 1 = ok






	/**
	 * Instanzia e vede se ci sta il memcache
	 */
	function cache()
	{//Verifica che ci sia il memcache per prima cosa
		GLOBAL $db;
		$this->db=$db; 
		//$this->memcache = new Memcache;

		//$ok=$this->memcache->pconnect('localhost', 11211);
		$ok=false;
		if ($ok)
		{//Bene abbiamo il memcache!
			$this->type=1;
			$this->status=1;
		}
		else
		{
			$this->type=2;
			$this->db=$db;
			//E crea l'id per mysql o senno riciclalo in qualche modo
		}
		//TODO Rimuovilo dopo i test del db per forzare a non usarew il memcached
	//	$this->type=-1;

	}



	/**
	 * Inserisce un valore nella cache
	 *
	 * @param una chiave $id
	 * @param stringa $data
	 * @return 1 ok 0 problemi e -1 cache disabilitata
	 */
	function insert($id,$data)
	{
		//echo $this->type;
		if ($this->type==1)
		{
			$this->memcache->add ($id,$data);
		}
		if ($this->type==2)
		{
			$data=addslashes($data); 
			$sql=" INSERT INTO `聖書`.`cache` (`key` ,`text` ,`updated`) VALUES ('$id', '$data' ,CURRENT_TIMESTAMP)";
			
			mysql_query($sql,$this->db);

		}
		if ($this->type==0)
		{
			$r=-1;
			return $r;
		}
	}



	/**
	 * Aggiorna un valore, se non è presente lo crea
	 * @param una chiave $id
	 * @param stringa $data
	 * @return 1 ok 0 problemi e -1 cache disabilitata
	 */
	function update($id,$data)
	{
		if ($this->type==1)
		{
			$s=$this->memcache->replace ($id,$data);
			if ($s==False)
			{
				$this->memcache->add ($id,$data);
			}
		}
		if ($this->type==2)
		{
			$sql=" UPDATE `聖書`.`cache` SET `text` = '$data' WHERE `key` = $id"; 
			$sql=addslashes($sql);
			mysql_query($sql,$this->db);

		}
		if ($this->type==0)
		{
			$r=-1;
			return $r;
		}
	}



	/**
	 * recupera un valore
	 * @param l'id $id
	 * @return stringa
	 */
	function select($id)
	{

		//dumpa($this->type);
		if ($this->type==1)
		{
			$r=$this->memcache->get($id);
			return $r;
		}
		if ($this->type==2)
		{
			$sql=" Select `text` FROM `聖書`.`cache` WHERE `key` = '$id'"; 
			$fs=mysql_query($sql,$this->db);
			$rs=mysql_fetch_row($fs);
			return $rs[0];
		}
		if ($this->type==0)
		{
			$r=-1;
			return $r;
		}
	}


	function flush ()
	{
		if ($this->type==1)
		{
			$r=$this->memcache->flush();
		}
		if ($this->type==2)
		{
			$sql="TRUNCATE TABLE `cache`";
			$fs=mysql_query($sql,$this->db);
		}
		if ($this->type==0)
		{
			$r=-1;
			return $r;
		}
	}


}
?>

