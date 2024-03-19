
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="x-icon" href="image/tapImage.PNG">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="DesignPortfolio.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Design Portfolio</title>
    </head>

    <body>
        <header>
            <img src="image/tapImage.PNG" alt="Majlas's Logo" width="200">
            <button type="button" onclick="window.location.href = 'index.html'" class="log-out">
                <img src="image/Log-Out.png" alt="log-out">
            </button> 
        </header>
        <div class="breadcrumb">
            <a href="ClientHomePage.html">Client Homepage</a>
            <span> / </span>
            <a href="DesignPortfolio.html">Design Portfolio</a>  
        </div>
        <main>
            <br>
            <h1>Designer &apos;s Design Portfolio</h1>
            <br>
            <div class="allprojects">
                <?php
                error_reporting(E_ALL);

                ini_set('log_errors', '1');

                ini_set('display_errors', '1');

                $conn = mysqli_connect('localhost', 'root', 'root', 'majlas');
                $error = mysqli_connect_error();
                if ($error != null) {
                    $output = '<p> Unable to connect to database</p>' . $error;
                    exit($output);
                } else {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM designportoflioproject WHERE designerID ='$id'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $catid = $row['designCategoryID'];
                        echo '<div class="Project"> ';
                        echo '<img src="image/' . $row['projectImgFileName'] . '" alt="' . $row['projectName'] . '" class="projectPic">';
                        echo '<div class="afterPic">';
                        echo '<h2 class="ProjectName">Project Name: <span class="Projectname">' . $row['projectName'] . '</span></h2>';
                        echo '<div class="ProjectContent">';
                        echo '<h3 class="DesignCategory">Design Category:</h3>';
                        $sql2 = "SELECT category FROM designcategory WHERE id= '$catid'";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        echo '<p>' . $row2['category'] . '</p>';
                        echo '<h3 class="ProjectDescriptio">Project Description:</h3>';
                        echo ' <p>' . $row['description'] . '</p>';
                        echo ' </div><!-- End of after pic -->';
                        echo '</div><!-- End of the project -->';
                    }
                } 
                ?>
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
                        <li><a href="tel:+0543080394"><img src="image/phone.png" alt="Phone call"> <span class="phone-number">0543080394</span></a></li>
                        <li><a href="mailto:Majlas@info.com"><img src="image/email.png" alt="Email Message"> <span class="email-address">Majlas@info.com</span></a></li>
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
    </body>
</html>