<?php
  // 2016-09-03 Correction fonctions mysql_ dépréciée. Utilisation de mysqli_ à la place.
	
  class Mysql
  {
    private
      $serveur = '',
      $bd = '',
      $id = '',
      $mdp = '',
      $pref= '',
      $con=null;

    public function __construct()
    {
      include './dirrw/param/param.ini.php';

      $this->serveur = $nomServeur;
      $this->bd = $nomBaseDonnee;
      $this->id = $loginAdminServeur;
      $this->mdp = $motPasseAdminServeur;
	  $this->pref = $prefixeTable;
    }

    public function connect()
    {//pas de gestion erreur, ça doit marcher quand on lui dit de marcher !
      $this->con = mysqli_connect($this->serveur,$this->id,$this->mdp,$this->bd);
	  mysqli_set_charset($this->con,"utf8");
      //mysql_select_db($this->bd,$this->con);
    }


    public function execSQLRes($req)
    {

      $i = 0;
      $res = mysqli_query($this->con,$req);

      $tbRes = array();
      while ($ligne = mysqli_fetch_assoc($res))
      {
        foreach ($ligne as $clef => $valeur)
           $tbRes[$i][$clef] = stripslashes($valeur);
        $i++;
      }
      mysqli_free_result($res);
      return $tbRes ;
    }

    public function insertId()
    {
      return mysqli_insert_id($this->con);
    }

    public function execSQL($req)
	{
	    //echo $req.'<br><br>';
      return mysqli_query($this->con,$req);
    }


    public function sauveTables($id){
	   $this->connect();
	   $nomFic="./dirrw/exsv/export_".date("w").".sql.gz";
	   $fic = gzopen($nomFic,'w');
	   $ressTables = mysqli_query($this->con,'show tables from '.$this->bd);
	   while ($lesTables = mysqli_fetch_row($ressTables)) {
	      $uneTable = $lesTables[0];
	      if ($res = mysqli_query($this->con,'show create table '.$uneTable)) {
	         $tb = mysqli_fetch_row($res);
	         gzwrite($fic, $tb[1].";\n");
	         $contenu = mysqli_query($this->con,'select * from '.$uneTable);
	         $nbChamps = mysqli_num_fields($contenu);
	         while ($ligne = mysqli_fetch_row($contenu)) {
	            $txt = 'insert into '.$uneTable.' values(';
	            for ($i=0; $i<$nbChamps; $i++)
	                $txt .= '\''.mysqli_real_escape_string($this->con,$ligne[$i]).'\',';
	            $txt = substr($txt, 0, -1);
	            gzwrite($fic, $txt.");\n");
	         }
	         mysqli_free_result($contenu);
	         mysqli_free_result($res);
	      }
	   }
	   gzclose($fic);
	   mysqli_free_result($ressTables);
	   $this->close();
	   return $nomFic;
    }

    public function close()
    {
      mysqli_close($this->con);
    }
  }
?>
