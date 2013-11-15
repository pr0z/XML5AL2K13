<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'head.php';
    include 'tools/functions.php';

    $nbcols = $_POST['nbcols'];
    $tbname = $_POST['tbname'];
    $dbname = $_POST['dbname'];
    $creator = $_POST['creator'];

    $racineXML = simplexml_load_file('xml/' . $creator . '/' . $dbname . '.xml');
    $infos = $racineXML->metaInformations;
    $creationDate = (string) $infos->creationDate;

    foreach ($racineXML->tables->table as $table) {
        if ($table->name == $tbname)
            $XMLtable = $table;
    }
    ?>
    <div id='bloc'>
        <div id='cssmenu'>
            <ul>
                <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                <li class=''><a href='query.php'><span>Requête</span></a></li>
                <?php if(isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li><?php } ?>
                <?php if(isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='admin.php'><span>Administration</span></a></li><?php } ?>
                <li class='last'><a href='logout.php'><span>Logout</span></a></li>
            </ul>
        </div>
        <div id="contenu">
        	<form method="post" action="editTable.php" class="" style="margin-bottom:50px;margin-top:0px;">
                <input type="hidden" name="creator" value="<?php echo $creator ?>" />
                <input type="hidden" name="dbname" value="<?php echo $dbname ?>" />
                <input type="submit" value="Retour à la Table" />
            </form>
            <h3 class="mainTitle">Ajouter/Modifier une table : "<?php echo $tbname; ?>"</h3>
            <table cellspacing="8" class="tabStep2">
                <tr>
                    <td><u>Nom de la base de données</u> </td>
                	<td><u>Date de création de la base</u> </td>
                	<td><u>Créateur</u> </td><td>
                </tr>
                <tr>
                    <td><b><?php echo $dbname; ?></b></td>
                    <td><b><?php echo $creationDate; ?></b></td>
                    <td><b><?php echo $creator; ?></b></td>
                </tr>
            </table>
            <form method="post" action="editTable.php"  class="custom-form">
                <div id="listCol">
                    <?php
                    $i = 0;

                    if (ISSET($XMLtable)) {
                        foreach ($XMLtable->columns->column as $column) {
                            ?>
                            <div id="col_<?php echo $i; ?>" class="separator">
                                <label for = "dbname" class = "dblabels"> Nom de la colonne : </label><input type="text" name="colname<?php echo $i; ?>" value="<?php echo $column->name; ?>" /><input type="button"  name="btSupp<?php echo $i; ?>" onClick="suppColone(<?php echo $i; ?>);" value="Supprimer la colone" style="position:absolute;margin-top:20px;" /><br />
                                <label for = "nbtable" class = "dblabels"> Type : </label>
                                <select name="typecol<?php echo $i; ?>">
                                    <option value="int" <?php if ($column->type == "int") echo "selected"; ?>>INT</option>
                                    <option value="float" <?php if ($column->type == "float") echo "selected"; ?>>FLOAT</option>
                                    <option value="decimal" <?php if ($column->type == "decimal") echo "selected"; ?>>DECIMAL</option>
                                    <option value="bool" <?php if ($column->type == "bool") echo "selected"; ?>>BOOLEAN</option>
                                    <option value="varchar" <?php if ($column->type == "varchar") echo "selected"; ?>>VARCHAR</option>
                                    <option value="text" <?php if ($column->type == "text") echo "selected"; ?>>TEXT</option>
                                    <option value="date" <?php if ($column->type == "date") echo "selected"; ?>>DATE</option>
                                </select>
                                <br /><br />
                            </div>
                            <?php
                            $i++;
                        }
                    }

                    for ($i; $i < $nbcols; $i++) {
                        ?>
                        <div id="col_<?php echo $i; ?>" class="separator">
                            <label for = "dbname" class = "dblabels">Nom de la colonne : </label><input type="text" name="colname<?php echo $i; ?>" /><input type="button"  name="btSupp<?php echo $i; ?>" onClick="suppColone(<?php echo $i; ?>);" value="Supprimer la colone" style="position:absolute;margin-top:20px;" /><br />
                            <label for = "nbtable" class = "dblabels">Type : </label>
                            <select name="typecol<?php echo $i; ?>">
                                <option value="int">INT</option>
                                <option value="float">FLOAT</option>
                                <option value="decimal">DECIMAL</option>
                                <option value="bool">BOOLEAN</option>
                                <option value="varchar">VARCHAR</option>
                                <option value="text">TEXT</option>
                                <option value="date">DATE</option>
                            </select>
                            <br /><br />
                        </div>
                        <?php
                    }
                    echo '</div>';
                    echo '<div id="btAdd"><input type="button" onClick="ajouterColone(' . $i . ');" value="Ajouter une colone" /></div>';
                    echo '<br /><hr />';
                    ?>
                    <input type="hidden" name="dbname" value="<?php echo $dbname; ?>" />
                    <input type="hidden" name="tbname" value="<?php echo $tbname; ?>" />
                    <input type="hidden" name="nbcols" value="<?php echo $nbcols; ?>" />
                    <input type="hidden" name="creator" value="<?php echo $creator; ?>" />
                    <input class="btnquery" type="submit" value="Suivant" name="go"/><br />
            </form>
        </div>
    </div>

    <script type="text/Javascript">
        function ajouterColone(id) {
        var h	  = '<div id="col_'+id+'" class="separator">';
        h   	+= '	<label for = "dbname" class = "dblabels"> Nom de la colonne : </label><input type="text" name="colname'+id+'" /><input name="btSupp'+id+'" type="button" onClick="suppColone('+id+');" value="Supprimer la colone" style="position:absolute;margin-top:20px;" /><br />';
        h 		+= '	<label for = "nbtable" class = "dblabels"> Type : </label>';
        h 		+= '	<select name="typecol'+id+'">';
        h 		+= '		<option value="int">INT</option>';
        h 		+= '		<option value="float">FLOAT</option>';
        h 		+= '		<option value="decimal">DECIMAL</option>';
        h 		+= '		<option value="bool">BOOLEAN</option>';
        h 		+= '		<option value="varchar">VARCHAR</option>';
        h 		+= '		<option value="text">TEXT</option>';
        h 		+= '		<option value="date">DATE</option>';
        h 		+= '	</select>';
        h 		+= '	<br /><br />';
        h		+= '</div>';
        $("#listCol").append(h);
        $("input[name=nbcols]").val(id+1);
        $("#btAdd").html('<input type="button" onClick="ajouterColone('+(id+1)+');" value="Ajouter une colone" />');
        }

        function suppColone(id) {
        $("#col_"+id).remove();
        for(var i = id + 1; i < $("input[name=nbcols]").val(); i++) {
        $("#col_"+i).attr("id","col_"+(i-1));
        $("input[name=colname"+i+"]").attr("name", "colname"+(i-1));
        $("input[name=btSupp"+i+"]").attr("onClick", "suppColone("+(i-1)+");");
        $("input[name=btSupp"+i+"]").attr("name", "btSupp"+(i-1));
        $("select[name=typecol"+i+"]").attr("name", "typecol"+(i-1));
        }
        $("input[name=nbcols]").val($("input[name=nbcols]").val() - 1);
        $("#btAdd").html('<input type="button" onClick="ajouterColone('+$("input[name=nbcols]").val()+');" value="Ajouter une colone" />');
        }
    </script>
    <?php
    include 'foot.php';
} else {
    Header('Location: index.php');
}
?>
