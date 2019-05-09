<?php
session_start();
?>
<!DOCTYPE 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hotel Bookings</title>

        <!-- Bootstrap CSS -->
        <link href="css/style.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
        <body class="background">
            <h1 class="text-center">Winelands Hotel Bookings</h1>
                <form class="submission" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

        
           <input type="text" id="firstname" name="firstname" placeholder="Your name.." required>
           <input type="text" id="lastname" name="lastname" placeholder="Your last name.." required><br>
           <input  type="date" id="In" name="indate" min="2018-01-01" max="2020-01-01" required><br>
           <input  type="date" id="Out" name="outdate" min="2018-01-01" max="2020-01-01" required><br>
        

       <select name="hotelname" required>
           <option value="Grand Roche">Grand Roche</option>
           <option value="Sante">Sante</option>
           <option value="Protea">Protea</option>
           <option value="La Residence">La Residence</option>
       </select><br>
       <input type="submit" id="submit" name="submit"><br>
  </form>

   <?php
    require_once "connect.php";

   $sql = "CREATE TABLE IF NOT EXISTS bookings(
       id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       firstname VARCHAR(50),
       lastname VARCHAR(50),
       hotelname VARCHAR(50),
       indate VARCHAR(30),
       outdate VARCHAR(30),
       booked INT(4))";


   $conn ->query($sql);
   echo $conn-> error;
   
   //write to database

   if(isset($_POST['submit'])){
       //create Session var from post data
           $_SESSION['firstname'] = $_POST['firstname'];
           $_SESSION['lastname'] = $_POST['lastname'];
           $_SESSION['hotelname'] = $_POST['hotelname'];
           $_SESSION['indate'] = $_POST['indate'];
           $_SESSION['outdate'] = $_POST['outdate'];
       }

       //amount of days the user stays at the hotel
       $datetime1 = new DateTime($_SESSION['indate']);
       $datetime2 = new DateTime($_SESSION['outdate']);
       $interval = $datetime1-> diff($datetime2);



$daysbooked = $interval->format('%d');
   $value;
switch($_SESSION['hotelname']){
 case "Grand Roche":
 $value = $daysbooked * 250;
 break;

 case "Sante":
 $value = $daysbooked * 750;
 break;

 case "Protea":
 $value = $daysbooked * 400;
 break;

 case "La Residence":
 $value = $daysbooked * 950;
 break;

 default:
 return "Invalid Booking";
}


echo "<div class='feedback'> <br> Firstname: ". $_SESSION['firstname'] . "<br>
   Lastname: " . $_SESSION['lastname'].
   "<br> Start Date: " . $_SESSION['indate'].
   "<br> End Date: " . $_SESSION['outdate'].
   "<br> Hotel Name: " . $_SESSION['hotelname'].
   "<br>" . $interval->format('%d days') . "<br> total: " . $value . "</div>";

       echo "<form class='form-inline' role='form' method='post' action=".
       htmlentities($_SERVER["PHP_SELF"]).
       "><input type='submit' id='submit' name='confirm'></form>";

       if(isset($_POST['confirm'])){
           $stmt = $conn->prepare("INSERT INTO bookings(firstname,lastname,hotelname,indate,outdate)VALUES(?,?,?,?,?)");
               $stmt -> bind_param('sssss',$firstname,$lastname,$hotelname,$indate,$outdate);


       $firstname = $_SESSION['firstname'];
       $lastname = $_SESSION['lastname'];
       $hotelname = $_SESSION['hotelname'];
       $indate = $_SESSION['indate'];
       $outdate = $_SESSION['outdate'];
           $stmt -> execute();
               echo "booking confirmed";
       }
?>

</body>
  </html>

