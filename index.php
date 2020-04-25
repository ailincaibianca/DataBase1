<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Products</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <?php
            $dbms = 'mysql';
            $host = 'localhost'; 
            $db = 'prod';
            $user = 'root';
            $pass = '';
            $dsn = "$dbms:host=$host;dbname=$db";
            $con=new PDO($dsn, $user, $pass);
            $sql1='SELECT * FROM products';
            $q1=$con->query($sql1);
            $q1->setFetchMode(PDO::FETCH_ASSOC);
            $sql2='SELECT * FROM products_updated';
            $q2=$con->query($sql2);
            $q2->setFetchMode(PDO::FETCH_ASSOC);
        ?>
        <table>
            <thead class="top-bar">
                <th class="image">Product</th>
                <th>Name</th>
                <th>Color</th>
                <th>Edit</th>
                <th>Delete</th>
            </thead>
            <?php while ($res1=$q1->fetch()): ?>
                <tr>
                    <td><?php echo '<img class="image-prod" src="./Images/'. $res1['Image'].'"/>'; ?></td>
                    <td><?php echo $res1['Name']; ?></td>
                    <td><?php echo $res1['Color']; ?></td>
                    <td> <a href="update.php?id=<?php echo $res1['ID'];?>">Update</a></td>
                    <td><a href="delete.php?id=<?php echo $res1['ID'];?>">Delete</a></td>
                </tr>
                 <?php endwhile; ?>
        </table>
        <br><br>
        <div clas="wrapper">
            <a class="insert" href="insert.php">
                Add new product
            </a>
        </div>
        <br><br>
        <table>
            <thead class="bottom-bar"> 
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Edit Time</th>
            </thead>
                <?php while ($res2=$q2->fetch()): ?>
                <tr>
                    <td><?php echo $res2['ID']; ?></td>
                    <td><?php echo $res2['Name']; ?></td>
                    <td><?php echo $res2['Status']; ?></td>
                    <td><?php echo $res2['EdTime']; ?></td>
                </tr>
                 <?php endwhile; ?>
        </table>
    </body>
</html>
