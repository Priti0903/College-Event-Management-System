<?php
// session_start();
// if (isset($_SESSION['usn']) && !empty($_SESSION['usn'])) {
//     $usn = $_SESSION['usn'];
//     echo "USN retrieved from session: " . htmlspecialchars($usn);
// } else {
//     echo "USN not set in session.";
//     exit;
// } -->

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usn']) && !empty($_POST['usn'])) {
        $usn = $_POST['usn'];
        $_SESSION['usn'] = $usn;
        echo "USN stored in session: " . htmlspecialchars($usn);
        header("Location: RegisteredEvents.php");
        exit;
    } else {
        echo "USN not provided in POST request.";
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>cems</title>
        <title></title>
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
        
    </head>
    <body>
        <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->

        <div class ="content"><!--body content holder-->
            <div class = "container">
                <div class ="col-md-6 col-md-offset-3">
                    <form action="usn.php" class ="form-group" method="POST">
                    


                        
                        <div class="form-group">
                            <label for="usn"> Student Rollno: </label>
                            <input type="text"
                                   id="usn"
                                   name="usn"
                                   class="form-control">
                        </div>
                        <button type="submit" class = "btn btn-default">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
