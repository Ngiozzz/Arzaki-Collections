<?php 
session_start();
include_once 'variables.php';
			class User
			{
				protected $FirstName;
				protected $LastName;
				protected $EmailorContact;
				protected $Username;
				protected $Password;
				protected $Address;

			function __construct($Firstname,$Lastname,$Password,$Username, $EmailorContact,$Address)
			  {
				$this->FirstName=$Firstname;
				$this->LastName=$Lastname;
				$this->Password=$Password;
				$this->Username=$Username;
				$this->EmailorContact = $EmailorContact;
				$this->Address = $Address;
			  }
			public function register($pdo)
			  {
			    $passwordHash=password_hash($this->Password, PASSWORD_DEFAULT);

				  try 
				   {
			       $stmt=$pdo->prepare('INSERT INTO user
			       (FirstName,LastName,UserName,ContactorEmail,Address,Password)VALUES (?,?,?,?,?,?)');
			       $stmt->execute([$this->FirstName,$this->LastName,$this->EmailorContact,$this->Address,$passwordHash]);
			       return "You have been registered";
			     }
			     catch (PDOException $e)
			     { 
			        return $e->getMessage();
			    }
			}
			public function LogIn($pdo)
			{
				 try
				      {
				        $stmt=$pdo->prepare("SELECT Password FROM register WHERE ContactorEmail=?");
				        $stmt->execute($this->EmailorContact);
				        $result=$stmt->fetch();
				        if($result==null)
				        {
				          return "The account does not exist";
				        }
				        if(password_verify($this->Password, $result['Password']))
				        {
				          return "Password is correct!";
				        }
				      }
				      catch(PDOException $e)
				      {
				        return $e->getMessage();
				      }

			}
			public function logOut($pdo)
			{
				if ($_POST["logOut"])
				{
					session_destroy();
					header("Location : login.php");
				}
			}
			public function changepassword($pdo)
			{
				try
					{
					    $stmt = $pdo->prepare("SELECT Password FROM `user` WHERE UserName = ?");
					    $result = $stmt->fetch();
					    if ($_POST["oldPassword"] == $result) 
					    {
					    	if ($_POST["newPassword"] == $_POST["conPassword"])
					    	{
					    		$sql = "UPDATE users SET Password = newPassword WHERE UserName =UserName";
								$pdo->prepare($sql)->execute([$Password]);
					    	}
					    	else
					    	{
					    		echo "Passwords do not match";
					    	}
					    }
					    else
					    {
					    	echo "Incorrect old password";
					    }
					}
				catch(PDOException $e)
				{
					return $e -> getMessage();
				}
			}
		}
?> 