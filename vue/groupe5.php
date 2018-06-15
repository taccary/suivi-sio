<?php  include_once 'exit.php'; ?>
<div id="corps">
<div id="navcontainer">
<ul id="navlist">

<?php
$num=$data["param"];
include_once './vue/menus/menugroupe.php';

?>

</ul>
</div>

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

<form method="post" enctype="multipart/form-data" action="index.php">
    <?php
      echo '<input type="hidden" name="action" value="groupe" />';
      echo '<input type="hidden" name="num" value="'.$num.'" />';
    ?>
    <h3>T&eacute;l&eacute;verser le fichier d'&eacute;tudiants &agrave; inscrire</h3>
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <td >
          <p>Vous devez avoir &agrave; votre disposition un fichier <b>csv</b> comportant trois colonnes (dans
            cet ordre) s&eacute;par&eacute;es par une virgule : nom, pr&eacute;nom, mel. 
            <i>Par exemple</i> :</p>
          <p>Martel,Jean,martel@voila.fr<br />
          Parlier,Josette,parlier@yahoo.fr</p>

          <p>Tout d'abord, vous choisissez la promotion dans laquelle vous allez inscrire
            l'ensemble des &eacute;tudiants.</p>
          <p>S&eacute;lectionnez ensuite sur votre station un fichier 'csv' qui
            doit contenir trois champs pour chaque &eacute;tudiant (sans ligne d'en-t&ecirc;te contenant
            les noms des champs). Un &eacute;tudiant dont le mel serait d&eacute;j&agrave; enregistr&eacute;
            pour cette promotion dans la base sera signal&eacute; en erreur (mais ignor&eacute; dans la base).</p>
          <p><b>Il est important d'encoder le fichier en UTF-8 nativement !</b><br />
            sous <u>LibreOffice Calc:</u> <i>Fichier > Enregistrer sous > d&eacute;rouler type et choisir Texte CSV > Cocher Editer les param&egrave;tres du filtre</i><br />
            sous <u>Microsoft Excel :</u> <i>Fichier > Enregistrer sous > d&eacute;rouler Type et choisir CSV UTF-8 (d&eacute;limit&eacute; par des virgules)</i></p>
          <p>En cliquant enfin sur le bouton 'Enregistrer' vous ins&egrave;rerez
            ces &eacute;tudiants dans la base de donn&eacute;es.</p>
          <hr>
        </td>
      </tr>
      <tr>

        <td>
          <div class="centrer">Promotion :
          <select name="groupes">
          <option value="0" selected>- choisir -</option>
              <?php
                 $type=$data["groupes"];
                 foreach ($type as $item) {
                   echo '<option value="'.$item["num"].'">'.$item["libelle"].'</option>';
                 }
              ?>
          </select>
          </div>
        </td>
      </tr><tr>
        <td width="65%" class="normal">
          <div class="centrer">
            Fichier &agrave; t&eacute;l&eacute;verser :
              <input type="file" name="fichier" accept=".csv" size="60">

          </div>
        </td>

      </tr>
      <tr>
        <td>
          <div class="centrer">
            <input type="submit" name="envoi" value="Enregistrer" />
          </div>
        </td>
      </tr>
    </table>

</form>
</div>
