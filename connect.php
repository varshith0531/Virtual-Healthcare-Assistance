<!DOCTYPE html>
<html>
<head>
    <title>database</title>
</head>
<body>
    <?php
    $name=$_POST['name'];
    $mail=$_POST['email'];
    $no=$_POST['pno'];
    $pass=$_POST['pass'];
    $address=$_POST['address'];
    $conn=new mysqli('localhost','root','','hyegia');
    if($conn->connect_error){
        die('connection failed'.$conn->connect_error);
    }
    else{
        $stmt=$conn->prepare("insert into login(name,email,phonenumber,password,address) values(?,?,?,?,?)");
        $stmt->bind_param('ssiss',$name,$mail,$no,$pass,$address);
        $stmt->execute();
        echo "Registered Successfully";
        $stmt->close();
        $conn->close();
    }
     ?>    
    
    </body>
</html>