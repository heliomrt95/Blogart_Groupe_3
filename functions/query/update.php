<?php
// update instance
function sql_update($table, $attributs, $where) {
    global $DB;

    //connect to database
    if(!$DB){
        sql_connect();
    }

    try{
        $DB->beginTransaction();

        //prepare query for PDO
        // Construire la clause SET à partir du tableau d'attributs
        $setClause = "";
        foreach($attributs as $key => $value){
            $setClause .= $key . " = '" . $value . "', ";
        }
        $setClause = rtrim($setClause, ", ");
        
        $query = "UPDATE $table SET $setClause WHERE $where;";
        $request = $DB->prepare($query);
        $request->execute();
        $DB->commit();
        $request->closeCursor();
    }
    catch(PDOException $e){
        $DB->rollBack();
        $request->closeCursor();
        die('Error: ' . $e->getMessage());
    }

    $error = $DB->errorInfo();
    if($error[0] != 0){
        echo "Error: " . $error[2];
    }else{
        return true;
    }
}
?>