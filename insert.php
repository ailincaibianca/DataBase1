<html>
    <head>
        <meta charset="UTF-8">
        <title>Products</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
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
                        <input class="submitbtn" type="submit" value="Add new author to database" name='add'>
                    </li>
                </ul>
            </form>
        <?php
        require 'connection.php';
        $sql1="DROP PROCEDURE IF EXISTS InsertRecord";
        $sql2="CREATE PROCEDURE InsertRecord( 
         IN strName varchar(30), 
         IN strColor varchar(30),
         IN image varchar(255)
        ) 
        BEGIN 
              INSERT INTO `products` (`ID`, `Name`, `Color`, `Image`) 
              VALUES (NULL, strName, strColor, image);
        END;";
        $stmt1=$con->prepare($sql1);
        $stmt2=$con->prepare($sql2);
        $stmt1->execute();
        $stmt2->execute();
        $sqlTrigger="CREATE TRIGGER AITrigger AFTER INSERT ON products FOR EACH ROW
             BEGIN
             INSERT INTO products_updated(Name,Status,EdTime) VALUES (NEW.Name,'CREATED',NOW());
             END;";
        $stmt=$con->prepare($sqlTrigger);
        $stmt->execute();
        if(isset($_POST['add'])){
            $nameProd = $_POST['name'];
            $colors = $_POST['colors'];
            $image = $_FILES["myimage"]["name"];

            if(!$colors || !$nameProd || !$image){

              echo 'All fields are required!';
            }
            else{
                $sql3="CALL InsertRecord('{$nameProd}','{$colors}','{$image}')";
                $q=$con->query($sql3);
                if($q){
                    move_uploaded_file($_FILES["myimage"]["tmp_name"],'Images/'.$image) or die( "Could not copy file!");
                    header('location:index.php');
                }
                else{
                    echo "'$nameProd','$colors','$image'";
                    echo "Something went wrong!";
                }
            }
        }
         ?>
    </body>
</html>
