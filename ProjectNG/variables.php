<?php 
include_once 'DbConnection.php';
include_once 'registerProcess.php';


$con = new DBConnector();
$pdo = $con ->connectToDB();
if(isset($_POST["Register"]))
{
		$Firstname = $_POST["Firstname"];
		$Lastname = $_POST["Lastname"];
		$Username = $_POST["Username"];
		$EmailorContact = $_POST["EmailorContact"];
		$Address = $_POST["Address"];
		$Password = $_POST["Password"];
		$user = new User($Firstname, $Lastname,$Username,$EmailorContact,$Address, $Password);
		echo $user ->register($pdo);
}
else
{
		$Username = $_POST["Username"];
		$Password = $_POST["Password"];
		$user = new User($Username, $Password);
		echo $user->login($pdo);
}

?>