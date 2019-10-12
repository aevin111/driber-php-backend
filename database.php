<?php
class UserDatabase
{
	public function isUserExist($email, $password)
	{
		$database = new mysqli("null", "null", "null", "null");
		$uEmail = null; //confirmation email
		$uPassword = null; //confirmation password
		
		if ($database == false)
		{
			die("DriberDBServices could not connect to the database. Reason: " . mysqli_connect_error());
		}
		
		$stmt = $database->prepare("SELECT email, passwrd FROM usersxd WHERE email = ? AND passwrd = ?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->execute();
		$stmt->bind_result($uEmail, $uPassword);
		$stmt->fetch();
		
		if ($uEmail == $email && $uPassword == $password)
		{
			echo "OK";
		}
		
		else 
		{
			echo "Invalid email/password!";
		}
		
		$stmt->close();
		$database->close();
	}
	
	public function registerUser($email, $password, $phoneNumber)
	{
		$database = new mysqli("null", "null", "null", "null");
		$result = $database->query("SELECT * FROM usersxd");
		$id = $result->num_rows;
		$id = $id + 1;
		$database->close();
		$database = new mysqli("null", "null", "null", "null");
		$stmtc = $databasec->prepare("INSERT INTO usersxd VALUES(?, ?, ?, ?, ?)");
		$driverID = -1;
		$stmtc->bind_param("isssi", $id, $email, $password, $phoneNumber, $driverID);
		$stmtc->execute();
		echo "OK";
		$stmtc->close();
		$databasec->close();
	}
	
	public function driverLogin($email, $password, $driverID)
	{
		$database = new mysqli("null", "null", "null", "null");
		$uEmail = null; //confirmation email
		$uPassword = null; //confirmation password
		$uDriverID = null;
		
		if ($database == false)
		{
			die("DriberDBServices could not connect to the database. Reason: " . mysqli_connect_error());
		}
		
		$stmt = $database->prepare("SELECT email, passwrd, driver_id FROM usersxd WHERE email = ? AND passwrd = ? AND driver_id = ?");
		$stmt->bind_param("ssi", $email, $password, $driverID);
		$stmt->execute();
		$stmt->bind_result($uEmail, $uPassword, $uDriverID);
		$stmt->fetch();
		
		if ($uEmail == $email && $uPassword == $password && $uDriverID == $driverID)
		{
			echo "OK";
		}
		
		else 
		{
			echo "Invalid email/password!";
		}
		
		$stmt->close();
		$database->close();
	}
}

class RidesLogDatabase
{
	public function newRide($email, $password, $lat, $long, $date, $time)
	{
		$database = new mysqli("null", "null", "null", "null");
		$uEmail = null; //confirmation email
		$uPassword = null; //confirmation password
		$userID = null;
		
		if ($database == false)
		{
			die("DriberDBServices could not connect to the database. Reason: " . mysqli_connect_error());
		}
		
		$stmt = $database->prepare("SELECT id, email, passwrd FROM usersxd WHERE email = ? AND passwrd = ?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->execute();
		$stmt->bind_result($userID, $uEmail, $uPassword);
		$stmt->fetch();
		$stmt->close();
		$database->close();
		
		if ($uEmail == $email && $uPassword == $password)
		{
			$database = new mysqli("null", "null", "null", "null");
			$result = $databaseb->query("SELECT * FROM requests");
			$id = $result->num_rows;
			$id = $id + 1;
			$databaseb->close();
			$database = new mysqli("null", "null", "null", "null");
			$stmtc = $databasec->prepare("INSERT INTO requests VALUES(?, ?, ?, ?, ?, ?)");
			$stmtc->bind_param("issddi", $id, $date, $time, $lat, $long, $userID);
			$stmtc->execute();
			echo "OK";
			$stmtc->close();
			$databasec->close();
		}
	}
	
	public function getCoords($email, $password, $jobID)
	{
		$database = new mysqli("null", "null", "null", "null");
		$uEmail = null; //confirmation email
		$uPassword = null; //confirmation password
		$userID = null;
		$lat = null;
		$long = null;
		$date = null;
		$time = null;
		
		if ($database == false)
		{
			die("DriberDBServices could not connect to the database. Reason: " . mysqli_connect_error());
		}
		
		$stmt = $database->prepare("SELECT email, passwrd FROM usersxd WHERE email = ? AND passwrd = ?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->execute();
		$stmt->bind_result($uEmail, $uPassword);
		$stmt->fetch();
		$stmt->close();
		$database->close();
		
		if ($uEmail == $email && $uPassword == $password)
		{
			$database = new mysqli("null", "null", "null", "null");
			//$stmtc = $databasec->prepare("SELECT d_date, t_time, latitude, longitude, user_id FROM requests WHERE id = ?");
			$stmtc = $databasec->prepare("SELECT latitude, longitude FROM requests WHERE id = ?");
			$stmtc->bind_param("i", $jobID);
			$stmtc->execute();
			$stmtc->bind_result($lat, $long);
			$stmtc->fetch();
			$stmtc->close();
			$databasec->close();
			$location = "https://www.google.com.ph/maps/place/" . $lat . "," . $long;
			echo $location;
		}
	}
	
	public function getDateTime($jobID)
	{
		$database = new mysqli("null", "null", "null", "null");
		$stmtd = $databased->prepare("SELECT d_date, t_time FROM requests WHERE id = ?");
		$date = null;
		$time = null;
		$stmtd->bind_param("i", $jobID);
		$stmtd->execute();
		$stmtd->bind_result($date, $time);
		$stmtd->fetch();
		$stmtd->close();
		$databased->close();
		echo $date . " " . $time;
	}
	
	public function getUserID($jobID)
	{
		$database = new mysqli("null", "null", "null", "null");
		$userID = null;
		$stmtd = $databased->prepare("SELECT user_id FROM requests WHERE id = ?");
		$stmtd->bind_param("i", $jobID);
		$stmtd->execute();
		$stmtd->bind_result($userID);
		$stmtd->fetch();
		$stmtd->close();
		$databased->close();
		echo $userID;
	}
}

class MainClass
{
	public function main()
	{
		$action = $_GET["action"];
		$email = $_GET["email"];
		$password = $_GET["password"];
		
		if ($action == "login")
		{
			$connection = new UserDatabase();
			$connection->isUserExist($email, $password);
		}
		
		else if ($action == "newride")
		{
			$lat = $_GET["lat"];
			$long = $_GET["long"];
			$date = $_GET["date"];
			$time = $_GET["time"];	
			$connection = new RidesLogDatabase();
			$connection->newRide($email, $password, $lat, $long, $date, $time);
		}
		
		else if ($action == "register")
		{
			$phoneNumber = $_GET["phone"];
			$connection = new UserDatabase();
			$connection->registerUser($email, $password, $phoneNumber);
		}
		
		else if ($action == "driverlogin")
		{
			$driverID = $_GET["driverid"];
			$connection = new UserDatabase();
			$connection->driverLogin($email, $password, $driverID);
		}
		
		else if ($action == "getcoords")
		{
			$jobID = $_GET["jobid"];
			$connection = new RidesLogDatabase();
			$connection->getCoords($email, $password, $jobID);
		}
		
		else if ($action == "getdatetime")
		{
			$jobID = $_GET["jobid"];
			$connection = new RidesLogDatabase();
			$connection->getDateTime($jobID);
		}
		
		else if ($action == "getuserid")
		{
			$jobID = $_GET["jobid"];
			$connection = new RidesLogDatabase();
			$connection->getUserID($jobID);
		}
	}
}

$main = new MainClass();
$main->main();
?>
