
<?php
session_start();
$email= $_SESSION["email"];
$password= $_SESSION["password"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="styling.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
           background: transparent;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
            background: url(images/thre.jpg)no-repeat center center;
        }

        h1 {
            color: blue;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
            color: white;
        }

        .contact-info {
            font-weight: bold;
            font-size: 18px;
        }

        a {
            color: yellow;
            text-decoration: none;
        }

        a:hover {
            color: greenyellow;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Many thanks for your inquiry!</h1>
        <p>We will contact you shortly to confirm your booking.</p>
        <p>If you have booked at short notice (for today) please contact us by phone or Whatsapp to receive immediate confirmation.</p>
        <p class="contact-info">+977 9090909090</p>
        <p>You can pay for your paragliding flight directly to your pilot after landing.</p>
        <p>We will reserve an instructor for each person you have booked so that you can all fly at the same time. Therefore, it is important that you do not turn up with fewer passengers than you have booked without informing us in advance.</p>
        
        <p>Thank you very much for your reservation.</p>
        <p>See you soon between the clouds.</p>
        <a href="testing.php">Back to Home</a>
        <h1>
            <?php 
            echo  " Your email: ".$email."<br>";
            echo" Your password:".$password;
            // session_destroy();
            ?>
        </h1>
    </div>
</body>
</html>
