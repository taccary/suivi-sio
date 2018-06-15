<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- 2016-09-03 Correction charset=utf-8 -->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <link rel="stylesheet" media="screen" type="text/css" title="Portefeuille" href="style.css" />
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <title>Suivi des compétences SIO</title>
       <script type="text/javascript" src="./vue/js/fenaide.js"></script>
   </head>

   <body>

       <div id="bandeau">
         <div id="qui">
           <?php
              $utilisateur=$data["utilisateur"];

              if (!is_null($utilisateur)){
				echo '<table border="0" width="310"><tr><td width="125">';
				echo '<img src="images/Logo.png" alt="logo 120x80" height="80" width="120"> </td><td>';
				echo 'v.2017.4 <br />';
                echo $utilisateur[0]["prenom"].' '.$utilisateur[0]["nom"].'<br />';
                echo $utilisateur[0]["groupe"]."-".$utilisateur[0]["an"].'<br />';
                echo '<a href="index.php?action=fermesession">d&eacute;connecter</a>';
				echo '</td></tr></table></body>';
              } else { 
				echo 'v.2017.4 <br /></body>';
			  }
            ?>
          </div>
        </div>
       <div id="left">
