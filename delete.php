<?php
require('connection.php');
$sql1="DROP PROCEDURE IF EXISTS DeleteRecord";
$sql2="CREATE PROCEDURE DeleteRecord( 
 IN intID int
) 
BEGIN 
      DELETE FROM `products` WHERE ID= intID;
END;";
$stmt1=$con->prepare($sql1);
$stmt2=$con->prepare($sql2);
$stmt1->execute();
$stmt2->execute();
$sqltrigger2="CREATE TRIGGER ADTrigger AFTER DELETE ON authors FOR EACH ROW
        BEGIN
        INSERT INTO products_updated (ID, Name, Status,EdTime) 
        VALUES (NULL, OLD.Name, 'DELETED',NOW());
        END;";
$stmtt2 = $con->prepare($sqltrigger2);
$stmtt2->execute();
$id = $_GET['id'];
$sql3="CALL DeleteRecord('{$id}')";
$q=$con->query($sql3);
if($q){
    header('location:index.php');
    }
else{
    echo "Something went wrong.";    
    }
?>
