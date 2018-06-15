<?php  include_once 'exit.php'; ?>
<div id="corps">

    <?php
      $vers=1;


      $liste=$data["lessitusel"];

    ?>

    <h2>Situations</h2>

<div class="titre">Cette page permet d'éditer une situation en cliquant sur son
          descriptif, de la supprimer, de la récupérer si la suppression
          n'est pas souhaitée ou de la détruire définitivement.
          Entre parenthèses vous sont indiqués les nombres de commentaires, d'activités
           citées et de productions pour chaque situation.</div><br>

  <table cellspacing="0" border="0" width="100%">
  <?php
    $li=1;
    $ln=30;
    $ids=0;
	echo '<table cellspacing="0" width="100%"><tr class="entete">
          <td>Source</td><td>Libellé</td><td>Action</td><td>Commentaire</td><td>Activité</td><td>Production</td></tr>';
	echo '<tr><td colspan="4"><hr /></td></tr>';

    foreach ($liste as $ligne) {

      $valide=$ligne["valide"];
      //$commenter=$ligne["validation"];
      //$commenter=0;
      $commentaire=$ligne["commentaire"];
      $activ=$ligne["activ"];
	  $prod=$ligne["prod"];
	  $libs=$ligne["libelle"];

      $ref=$ligne["ref"];
      echo '<tr>';

      $lib=$ligne["libT"];
      if (strlen($lib)>$ln) $lib=substr($lib,0,$ln).'...';
      if (strlen($lib)==0) $lib='* non saisi *';

      //echo '<td class="td'.$li.'"><a href="index.php?action=saisie&vers=1&numsitu='.$ref.'&v='.$commenter.'">'.$lib.'</a></td>';
      $colonne='<td class="td'.$li.'">';
	  echo $colonne.$libs.$colonne.'<a href="index.php?action=saisie&vers=1&numsitu='.$ref.'">'.$lib.'</a></td>';

      if ($valide=='O'){
          echo $colonne.'<a href="index.php?action=gestion&mode=1&t=s&numsitu='.$ref.'">supprimer</a></td>';
          echo $colonne.'&nbsp;</td>';
      } else{
          echo $colonne.'<a href="index.php?action=gestion&mode=2&t=s&numsitu='.$ref.'">récupérer</a></td>';
          echo $colonne.'<a href="index.php?action=gestion&mode=3&t=s&numsitu='.$ref.'">détruire</a></td>';
      }

      if ($commentaire>0)
        echo $colonne.'Commentée ('.$commentaire.')</td>';
      else
        echo $colonne.'&nbsp;</td>';

      if ($activ>0)
        echo $colonne.'Activité ('.$activ.')</td>';
      else
        echo $colonne.'&nbsp;</td>';

      if ($prod>0)
        echo '<td class="td'.$li.'">Production ('.$prod.')</td>';
      else
        echo '<td class="td'.$li.'">&nbsp;</td>';

      if ($li==1) $li=2; else $li=1;  // permet de changer la couleur de fond à chaque ligne
      echo '</tr>';
    }
  ?>
</table>
</div>
