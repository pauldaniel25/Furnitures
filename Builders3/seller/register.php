<?php 

include('../includes/connect.php');
session_start();

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

     $checkEmail="SELECT * From seller where email='$email'";
     $result=$conn->query($checkEmail);
     if($result->num_rows>0){
        echo "Email Address Already Exists !";
     }
     else{
        $insertQuery="INSERT INTO seller(firstName,lastName,email,password)
                       VALUES ('$firstName','$lastName','$email','$password')";
            if($conn->query($insertQuery)==TRUE){
                header("location: index.php");
            }
            else{
                echo "Error:".$conn->error;
            }
     }
   

}

if(isset($_POST['signIn'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);
   
    $sql="SELECT * FROM seller WHERE email='$email' and password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        
        // Store the email and seller ID in the session
        $_SESSION['email'] = $row['email'];
        $_SESSION['seller_id'] = $row['id']; // Assuming 'id' is the primary key in the seller table
        
        header("Location: seller.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}

?>