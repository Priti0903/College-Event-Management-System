<?php
require 'vendor/autoload.php';  
require __DIR__ . '/phpqrcode/qrlib.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'C:\xampp\htdocs\College-Event-Management-System-master-20241110T093942Z-001\College-Event-Management-System-master\classes\db1.php';





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $qrData = json_encode([
        'name' => $name,
        'email' => $email,
        
    ]);

  
    $fileName = "qrcodes/" . uniqid() . ".png";
    QRcode::png($qrData, $fileName, QR_ECLEVEL_L, 4);

  
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'pritiv.0903@gmail.com'; 
    $mail->Password = 'tylptujydtsrldtw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    


    $mail->setFrom('pritiv.0903@gmail.com', 'Event Organizer');
    $mail->addAddress($email);

    $mail->Subject = 'Event Registration Confirmation';
    $mail->Body    = "Dear $name,\n\nThank you for registering for event. Please find your QR code attached.";
    $mail->addAttachment($fileName);

    if ($mail->send()) {
        $successMessage = "Registration successful! QR Code sent to $email.";
    } else {
        $errorMessage = "Failed to send email. Error: " . $mail->ErrorInfo;
    }

    unlink($fileName);
}
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>cems</title>
        <?php require 'utils/styles.php'; ?>
        
    </head>
    <body>
    <?php
    if (!empty($successMessage)) {
        echo "<p style='color: green;'>$successMessage</p>";
    }
    if (!empty($errorMessage)) {
        echo "<p style='color: red;'>$errorMessage</p>";
    }
    ?>
    <?php require 'utils/header.php'; ?>
    <div class ="content">
            <div class = "container">
                <div class ="col-md-6 col-md-offset-3">
    <form action="" method="POST" action="RegisteredEvents.php">

   
        <label for="Student usn">Student Roll Number:</label><br>
        <input type="text" name="usn" class="form-control" required><br><br>

        <label for="name">Name:</label><br>
        <input type="text" name="name" class="form-control" required><br><br>

        <label for="Branch">Branch:</label><br>
        <input type="text" name="branch" class="form-control" required><br><br>

        <label for="Semester">Semester:</label><br>
        <input type="text" name="sem" class="form-control" required><br><br>

        <label for="Email" >Email:</label><br>
        <input type="email" name="email"  class="form-control" required ><br><br>

        <label for="Phone">Phone:</label><br>
        <input type="text" name="phone"  class="form-control" required><br><br>

        <label for="College">College:</label><br>
        <input type="text" name="college"  class="form-control" required><br><br>

        <button type="submit" name="update" required>Submit</button><br><br>
        <a href="usn.php" ><u>Already registered ?</u></a>

    </div>
    </div>
    </div>
    </form>
    

    <?php require 'utils/footer.php'; ?>
    </body>
</html>

<?php

    if (isset($_POST["update"]))
    {
        $usn=$_POST["usn"];
        $name=$_POST["name"];
        $branch=$_POST["branch"];
        $sem=$_POST["sem"];
        $email=$_POST["email"];
        $phone=$_POST["phone"];
        $college=$_POST["college"];

        if (isset($_POST['submit'])) {
            $usn = $_POST['usn'];
            $event_id = $_POST['event_id'];
        
            $query = "INSERT INTO registered (usn, event_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $usn, $event_id);
            $result = $stmt->execute();
        
            if ($result) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $conn->error;
            }
        }
        
        if( !empty($usn) || !empty($name) || !empty($branch) || !empty($sem) || !empty($email) || !empty($phone) || !empty($college) )
        {
        
            include 'classes/db1.php';     
                $INSERT="INSERT INTO participent (usn,name,branch,sem,email,phone,college) VALUES('$usn','$name','$branch',$sem,'$email','$phone','$college')";

          
                if($conn->query($INSERT)===True){
                    echo "<script>
                    alert('Registered Successfully!');
                    Debug: USN received is  . $usn;

                    window.location.href='usn.php';
                    </script>";
                }
                else
                {
                    echo"<script>
                    alert(' Already registered this usn');
                    window.location.href='usn.php';
                    </script>";
                }
               
                $conn->close();
            
        }
        else
        {
            echo"<script>
            alert('All fields are required');
            window.location.href='register.php';
                    </script>";
        }
    }
    
?>