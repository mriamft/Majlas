   
<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FName = $_POST['Fname'];
    $LName = $_POST['Lname'];
    $email = $_POST['email'];
    $password = $_POST['pswd'];
    $Type = $_POST['TypeOfUser'];
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT); // Hashing the password

    $connection = mysqli_connect("localhost", "root", "root", "majlas");

    if (mysqli_connect_errno()) {
        echo 'something wrong';
        die("Database connection failed: " . mysqli_connect_error());
    } else {
        if ($Type == "client") {
            $sqlEmail = "SELECT COUNT(emailAddress) AS countEmail FROM client WHERE emailAddress = '$email'";
            $result = mysqli_query($connection, $sqlEmail);
            $row = mysqli_fetch_assoc($result);

            if ($row["countEmail"] > 0) {
                echo '<script>
                            alert("The email already exists. Please use a different email");
                            window.location.href = "SignUp.php";
                        </script>';
                exit; // To ensure stopping the execution of this script
            } else {
                $sqlInsert = "INSERT INTO client (firstName, lastName, emailAddress, password) VALUES (?, ?, ?, ?)";
                $Pstmt = mysqli_prepare($connection, $sqlInsert);
                mysqli_stmt_bind_param($Pstmt, "ssss", $FName, $LName, $email, $passwordHashed);

                if (mysqli_stmt_execute($Pstmt)) {
                    $LastID = mysqli_insert_id($connection);
                    $_SESSION['id'] = $LastID;
                    $_SESSION['type'] = $Type;
                    echo '<script>window.location.href = "ClientHomePage.php";</script>';
                    exit; // To ensure stopping the execution of this script
                }
            }
        } else { // Designer
            $sqlEmail = "SELECT COUNT(*) AS countEmail FROM designer WHERE emailAddress = '$email'";
            $result = mysqli_query($connection, $sqlEmail);
            $row = mysqli_fetch_assoc($result);

            if ($row['countEmail'] > 0) {
                echo '<script>
                            alert("The email already exists. Please use a different email");
                            window.location.href = "SignUp.php";
                        </script>';
                exit; // To ensure stopping the execution of this script
            } else {
                $brandName = $_POST['Brandname'];
                $brandLogo = $_POST['BrandLogo'];
                $category = $_POST['Category'];

                $sqlInsert = "INSERT INTO designer (firstName, lastName, emailAddress, password, brandName, logoImgFileName)"
                    . " VALUES (?, ?, ?, ?, ?, ?)";
                $Pstmt = mysqli_prepare($connection, $sqlInsert);
                mysqli_stmt_bind_param($Pstmt, "ssssss", $FName, $LName, $email, $passwordHashed, $brandName, $brandLogo);

                if (mysqli_stmt_execute($Pstmt)) {
                    $LastID = mysqli_insert_id($connection);

                    foreach ($category as $cat) {
                        $sqlCat = "SELECT id FROM designcategory WHERE category = '".$cat."'";
                        $result = mysqli_query($connection, $sqlCat);

                        if ($result) {
                            $row = mysqli_fetch_assoc($result);

                            if ($row !== null) {
                                $catID = $row['id'];

                                if (!empty($catID)) {
                                    $sqlInsert = "INSERT INTO designerspeciality (designerID, designCategoryID) VALUES ('$LastID', '$catID')";
                                    $result = mysqli_query($connection, $sqlInsert);

                                    if (!$result) {
                                        echo 'Failed to insert designer category.';
                                    } 
                                    }
                                }
                            }
                        }
                    }

                    $_SESSION['id'] = $LastID;
                    $_SESSION['type'] = $Type;
                    echo '<script>window.location.href = "DesignerHomePage.php";</script>';
                    exit; // To ensure stopping the execution of this script
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="image/tapImage.PNG">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="SignUp.css">
    <title>Sign Up</title>
</head>

<body>
    <header>
        <img src="image/tapImage.PNG" alt="Majlas's Logo" width="200">
    </header>
    <div class="breadcrumb">
        <a href="index.html">Homepage</a>
        <span> / </span>
        <a href="SignUp.html">Sign up</a>
    </div>
    <main>
        <div class="BigContainer">
            <div class="Type">
                <div>
                    <label>
                        <input type="radio" name="Type" value="interior">
                        <span>Interior Designer</span>
                    </label>
                    <label>
                        <input type="radio" name="Type" value="client">
                        <span>Cleint</span>
                    </label>
                </div>
            </div>
            <p id="paragraph">Let's start the journey! <br> Select Account Type</p>
            <div class="DesForm" style="display: none;">
                <form action="index.php" method="POST" >
                    <div class="DesInfo">
                        <h2 style="color: rgb(68, 68, 68); font-size: 20px;">Designer's Information</h2><br>

                        <input type="text" name="Fname" value="" class="FormHeight" placeholder=" First Name"
                            style=" width:20%;" required><br>
                        <label>Name:</label>
                        <input type="text" name="Lname" value="" class="FormHeight" placeholder=" Last Name"
                            style="width:20%; margin-right: 5em;" required><br><br>
                        <label>E-mail:</label>
                        <input name="email"type="email" placeholder="  E-mail" class="FormHeight"
                            style="width:20%; margin-right: 5em;" required><br><br>
                        <label>Password:</label>
                        <input type="password" name="pswd" class="FormHeight" placeholder="charechter and numbers"
                            style="width:19%; margin-right: 5.5em;" required><br><br>
                    </div>

                    <div class="BrandInfo">
                        <h2 style="color: rgb(68, 68, 68); font-size: 20px;">Brand's Information</h2><br>
                        <label>Brand Name:</label>
                        <input type="text" name="Brandname" value="" class="FormHeight" placeholder=" Name"
                            style=" width:50%; margin-right: 0.5em;" required><br><br>
                        <label>Brand Logo</label>
                        <input type="file" id="myfile" name="BrandLogo" class="FormHeight"
                            style="width:52%; margin-right: 0.5em;" required><br><br>
                        <div id="Category">
                            <label style="margin-right: 7em;">Interior Design Category:</label><br>
                            <input type="checkbox" name="Category[]" value="Modern" class="checkbox"> Modern<br>
                            <input type="checkbox" name="Category[]" value="Country" class="checkbox"> Country<br>
                            <input type="checkbox" name="Category[]" value="Coastal" class="checkbox"> Coastal<br>
                            <div class="checkbox1">
                            <input type="checkbox" name="Category[]" value="Bohemian" class="checkbox"> Bohemian<br>
                            <input type="checkbox" name="Category[]" value="Mid-century modern" class="checkbox" > Mid-century modern<br>
                            <input type="checkbox" name="Category[]" value="Minimalist" class="checkbox"> Minimalist</div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="TypeOfUser" value="designer">
                    
                    <input type="submit" value="Submit" id="btn">
                </form>
            </div>

            <div class="ClientForm" style="display: none;">
                <form action="index.php" method="POST">
                    <h2 style="color: rgb(70, 70, 70);">Client's Information</h2><br>
                    <label>Name:</label>
                    <input type="text" name="Fname" value="" class="FormHeight" placeholder=" First Name"
                        style="margin-right: 2em; width:38%;" required>
                    <input type="text" name="Lname" value="" class="FormHeight" placeholder=" Last Name"
                        style="width:38%" required><br><br>
                    <label>Email:</label>
                    <input name="email" type="email" placeholder="  E-mail" class="FormHeight" style="width:80%" required><br><br>
                    <label>Password:</label>
                    <input type="password" name="pswd" class="FormHeight"
                        placeholder="charechter and numbers" style="width:76%" required><br><br>
                    
                    <input type="hidden" name="TypeOfUser" value="client">
                    
                    <input type="submit" value="Submit" id="btn1">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <div class="footcontainer">
            <div class="col1"> <!--for the right most column*/-->
                <h3>Majlas's Story</h3>
                <p>Majlas embarked on a journey of innovation, shaping the digital realm with their visionary ideas.</p>
            </div>

            <var></var>

            <div class="col2">
                <h3>Contact us</h3>
                <ul>
                    <li><a href="tel:+0543080394"><img src="image/phone.png" alt="Phone call"> <span
                                class="phone-number">0543080394</span></a></li>
                    <li><a href="mailto:Majlas@info.com"><img src="image/email.png" alt="Email Message"> <span
                                class="email-address">Majlas@info.com</span></a></li>
                </ul>
                <span>&copy; All rights reserved 2023-2024</span>
            </div>

            <div class="col3"> <!--for the left most column*/-->
                <h3>Address</h3>
                <p>Saudi Arabia, Riyadh, King Saud University, Information Technology department IT329</p>
                <p>Privacy - Term</p>

            </div>
        </div>

    </footer>


    <script>
        //start of the form vivibalty
        var type = document.getElementsByClassName("Type")[0];
        var paragraph = document.getElementById("paragraph");
        var desForm = document.getElementsByClassName("DesForm")[0];
        var CleintForm = document.getElementsByClassName("ClientForm")[0];


        type.addEventListener('change', function (event) {
            var selectedType = event.target.value;

            if (selectedType === 'interior') {
                desForm.style.display = 'block';
                paragraph.style.display = 'none';
                CleintForm.style.display = 'none';
            } else if (selectedType === 'client') {
                desForm.style.display = 'none';
                paragraph.style.display = 'none';
                CleintForm.style.display = 'block';
            }
        });//end of the form visiblaty 

    </script>
    
    

</body>
