<html>
    <head>
        <meta charset="UTF-8">
        <title>Products</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <p>Enter Changes</p>
            <form class="formstyle" method = "post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <input type="text" placeholder='Name' name="name" >
                    </li>
                    <li>
                        <input type="text" placeholder='Color' name="colors">
                    </li>
                    <li>
                        <input type="file" name="myimage" placeholder="Your Image">
                    </li>
                    <li>
                        <input class="submitbtn" type="submit" value="Submit changes" name='update'>
                    </li>
                </ul>
            </form>
        <?php
        require "connection.php";
        $sql1="DROP PROCEDURE IF EXISTS UpdateRecord";
        $sql2="CREATE PROCEDURE UpdateRecord( 
         IN strName varchar(30), 
         IN strColor varchar(30), 
         IN image varchar(500),
         IN intId int
        ) 
        BEGIN 
              UPDATE `products` SET `Name` = strName, `Color` = strColor, `Image`=image WHERE ID = intId;
        END;";
        $stmt1=$con->prepare($sql1);
        $stmt2=$con->prepare($sql2);
        $stmt1->execute();
        $stmt2->execute();
        $sqlTrigger="CREATE TRIGGER AUTrigger AFTER UPDATE ON products FOR EACH ROW
             BEGIN
             INSERT INTO products_updated(Name,Status,EdTime) VALUES (NEW.Name,'UPDATED',NOW());
             END;";
        $stmt=$con->prepare($sqlTrigger);
        $stmt->execute();
        if(isset($_POST['update'])){
            $nameProd = $_POST['name'];
            $colors = $_POST['colors'];
            $image = $_FILES["myimage"]["name"];
            $RecordID = $_GET['id'];

            if(!$colors || !$nameProd || !$image){

              echo 'All fields are required!';
            }
            else{
                $sql3="CALL UpdateRecord('{$nameProd}','{$colors}','{$image}','{$RecordID}')";
                $q=$con->query($sql3);
                if($q){
                    move_uploaded_file($_FILES["myimage"]["tmp_name"],'Images/'.$image) or die( "Could not copy file!");
                    header('location:index.php');
                }
                else{
                    echo "Something went wrong!";
                }
            }
        }
         ?>
    </body>
</html>