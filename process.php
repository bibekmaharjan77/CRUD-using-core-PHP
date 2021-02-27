<?php

session_start();

$mysqli=new mysqli('localhost','root','','crud') or die (mysqli_error($mysqli));

$id=0;
$update=false;
$name='';
$location='';
$contact='';
$email='';
$nameerror='';

if(isset($_POST['save'])){

    // name field compulsary banauna khojeko + only accepting letters and white space
    if(empty($_POST['name'])){
        $nameerror="Name is required!";
    }
    else{
        $name=test_user_input($_POST['name']);
        // preg_match matches the regular expression format i.e name, contact, email etc ko format mileko xa ki xaina vanera 
        if(!preg_match("/^[A-Za-z. ]*$/",$name)){
            $nameerror="Only letters and white spaces are allowed!";

            //yo nameerror uta index page ma display garda pani vairako xaina wrong data halda yo display hunu parthyo
            //but vairako xaina
        }
    }

    //$name=$_POST['name'];
    $location=$_POST['location'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];

    //name field empty xaina and format mileko xa vane matra table ma add garne banako but mileko xaina

    if(!empty($_POST['name'])){
        if((preg_match("/^[A-Za-z. ]*$/",$name))==true){
            
            $mysqli->query("INSERT INTO data(name,location,contact,email) VALUES ('$name','$location','$contact','$email')") or 
                die($mysqli->error);

            $_SESSION['message']="Record has been saved!";
            $_SESSION['msg-type']="success";   
    
            header("location:index.php");

            //echo '<script> window.open("index.php?","_self") </script>';
        }
        else{

            //this is not working eithern echo matra rakhyo vane process page ma gayera echo chai hunxa but header
            //function is not working
            echo "please fill in correct form of data!";
            header("location:index.php");
        }
    }

    // $mysqli->query("INSERT INTO data(name,location,contact,email) VALUES ('$name','$location','$contact','$email')") or 
    //             die($mysqli->error);

    // $_SESSION['message']="Record has been saved!";
    // $_SESSION['msg-type']="success";   
    
    // header("location:index.php");
}

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    
    $_SESSION['message']="Record has been deleted!";
    $_SESSION['msg-type']="danger";   

    header("location:index.php");
}

if(isset($_GET['edit'])){
    $id= $_GET['edit'];
    $update=true;
    $result= $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    if(count($result)==1){
        $row=$result->fetch_array();
        $name=$row['name'];
        $location=$row['location'];
        $contact=$row['contact'];
        $email=$row['email'];
    }
}

if(isset($_POST['update'])){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $location=$_POST['location'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];

    $mysqli->query("UPDATE data SET name='$name', location='$location', contact='$contact', email='$email' WHERE id=$id")
                or die($mysqli->error());

    $_SESSION['message']="Record has been updated!";
    $_SESSION['msg-type']="warning";
    
    header('location:index.php');
}




function test_user_input($data){
    return $data;
}

?>