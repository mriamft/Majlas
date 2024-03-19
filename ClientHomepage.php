<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="x-icon" href="image/tapImage.PNG">
  <link rel="stylesheet" href="clientHome.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Client Home Page</title>
</head>

<body>
    <header>
        <img src="image/tapImage.PNG" alt="Majlas's Logo" width="200">
        <button type="button" onclick="window.location.href = 'SignOut.php'" class="log-out">
            <img src="image/Log-Out.png" alt="log-out">
        </button>         
    </header>
    <main>
        <section class="part1">
            <div class="headerContent">
                <?php 
                session_start();
                //should i use isset? 
                $clientID= $_SESSION['id'];
                $connection= mysqli_connect('localhost', 'root','root','majlas');
                if(mysqli_connect_error()){
                    echo '<p>failed</p>';
                    die(mysqli_connect_error());
                }
                $sql="SELECT * FROM Client WHERE id='1'"; //CHANGE IT TO $clientID
                $result= mysqli_query($connection, $sql);
                $row= mysqli_fetch_assoc($result);
                echo '<h2>Welcome <span>'.$row['firstName'].'</span></h2> ';
                
                ?>
<!--                <h2>Welcome <span>Maryam</span></h2> -->
                <div class="clientInfo">
                    <h3>Client's Information:</h3>
                    <p>
                        <?php
                            echo '<span>First name:</span>'.$row['firstName'].' <br>';
                            echo '<span>Last name:</span>'.$row['lastName'].'<br>';
                            echo '<span>Email address:</span> <a href="mailto:'.$row['emailAddress'].'">'.$row['emailAddress'].'</a>';
                        ?>
                    </p>            
                </div>

            </div>
            <span class="imgHover">
                <img src="image/smoke.png" alt="">
            </span>
        </section>
        <div class="header1">
        </div>


        <div class="tableContainer">
        <div class="designer">
            <div class="desHeader">
                <h3>Interior Designers</h3>
                <div class="filter">
<!--                    <p>Select Category:</p>-->
                    <label for="cat">Select Category:</label> <!--can i use it out of form scope?-->
                    <div class="dropdown">
<!--                        <button class="dropbtn btn">Category 
                          <i class="fa fa-caret-down"></i>
                        </button>-->
                        
<!--                        <div class="dropdown-content">-->
                            <form action="index.php" method="POST">
                                <select name="cat" id="cat">
                                    <?php 
                                        $sql="SELECT * FROM DesignCategory";
                                        $result= mysqli_query($connection, $sql);
                                        while ($row= mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$row['id'].'">'.$row['category'].'</option>';
                                        }
//                                        
//                                    <option value="Coastal">Coastal</option>
//                                    <option value="Minimalist">Minimalist</option>
//                                    <option value="Traditional">Traditional</option>
                                    ?>
                                </select>
                            
<!--                            <ul>
                                <li>Modern</li>
                                <li>Mid-century Modern</li>
                                <li>Traditional</li>
                                <li>Coastal</li>
                                <li>Minimalist</li>
                                <li>Country</li>
                            </ul>-->
<!--                        </div>-->
                      </div> 
                    <button type="submit" class="btn">Filter</button>
                    </form>
<!--                    <button type="button" class="btn" onclick="window.location.href = 'ClientHomePage.html'" >
                        Filter
                    </button>-->
                </div>
            </div>

            <table class="table1">
                <tr>
                    <th>Designer</th>
                    <th>Specialty</th>
                </tr>
                <?php 
                
                    if($_SERVER['REQUEST_METHOD']=="POST"){
                        $catID=$_POST['cat'];
                        $sql="SELECT * FROM DesignerSpeciality WHERE designCategoryID='$catID'";
                        $result= mysqli_query($connection, $sql);
                        
                        while ($row= mysqli_fetch_assoc($result)){
                            $sql2 = "SELECT * FROM Designer WHERE id='" . $row['designerID'] . "'";
                            $result2= mysqli_query($connection, $sql2);
                            $row2= mysqli_fetch_assoc($result2);
                            echo '<tr><td class="image"><a href="DesignPortfolio.php?id='.$row2['id'].'"><img src="image/'.$row2['logoImgFileName'].'" alt="'.$row2['firstName'].'\'s Logo"></a><br> <a href="DesignPortfolio.php?id='.$row2['id'].'" class="desName">'.$row2['firstName'].' '.$row2['lastName'].'</a></td>';
                            $sql3 = "SELECT category FROM DesignCategory WHERE id='" . $row['designCategoryID'] . "'"; //؟؟؟؟؟؟؟؟؟؟؟؟؟؟؟؟But it's POST req???????????????????
                            $result3= mysqli_query($connection, $sql3);
                            $row3= mysqli_fetch_assoc($result3);
                            echo '<td>'.$row3['category'].'</td>';
                                                            
                            echo '<td><a href="RequestDesignConsultation.php?designerID='.$row['designerID'].'">Request Design Consultation</a></td>'; //?????????designerID or id?????????????? 
                            
                        }
                        
//                        
                    }
                    else if ($_SERVER['REQUEST_METHOD']=="GET"){ //
                        $sql="SELECT * FROM DesignerSpeciality";
                        $result= mysqli_query($connection, $sql);
                        
                        while ($row= mysqli_fetch_assoc($result)){
                            $sql2 = "SELECT * FROM Designer WHERE id='" . $row['designerID'] . "'";
                            $result2= mysqli_query($connection, $sql2);
                            $row2= mysqli_fetch_assoc($result2);
                            echo '<tr><td class="image"><a href="DesignPortfolio.php?id='.$row2['id'].'"><img src="image/'.$row2['logoImgFileName'].'" alt="'.$row2['firstName'].'\'s Logo"></a><br> <a href="DesignPortfolio.php?id='.$row2['id'].'" class="desName">'.$row2['firstName'].' '.$row2['lastName'].'</a></td>';
                            $sql3 = "SELECT category FROM DesignCategory WHERE id='" . $row['designCategoryID'] . "'"; //؟؟؟؟؟؟؟؟؟؟؟؟؟؟؟؟But it's POST req???????????????????
                            $result3= mysqli_query($connection, $sql3);
                            $row3= mysqli_fetch_assoc($result3);
                            echo '<td>'.$row3['category'].'</td>';
                                                            
                            echo '<td><a href="RequestDesignConsultation.php?designerID='.$row['designerID'].'">Request Design Consultation</a></td>'; //?????????designerID or id?????????????? 
                        }
                    }
                    
                ?>
<!--                <tr>
                    <td class="image"><a href="DesignPortfolio.html"><img src="image/RahafLogo.PNG" alt="Rahaf's Logo"></a><br> <a href="DesignPortfolio.html" class="desName">Rahaf Alateeq</a></td>
                    <td>Contemporary, <br>Modern</td>
                    
                </tr>-->
<!--                <tr>
                    <td class="image"><a href="DesignPortfolio.html"><img src="image/khadijaLogo.PNG" alt="Rahaf's Logo"></a><br> <a href="DesignPortfolio.html" class="desName">Khadija Altuwaijri</a></td>
                    <td>Art Modern, <br>Scandinavian</td>
                    <td><a href="RequestDesignConsultation.html">Request Design Consultation</a></td>
                </tr>-->
            </table>
        </div>
        </div>
        <div class="imagSeprater">
            <img src="image/unnamed.jpg" alt="decor sample">
        </div>
        <div class="tableContainer">
        <div class="conRequest">
            <h3>Previous Design Consultation Request</h3>
            <table>
                
                <tr>
                    <th>Designer</th>
                    <th>Room</th>
                    <th>Dimensions</th>
                    <th>Design Category</th>
                    <th>Color Preferences</th>
                    <th>Request Date</th>
                    <th>Design Consultation</th>
                </tr>
                <?php
                    $sql="SELECT * FROM DesignConsultationRequest WHERE clientID='2'"; //CHANGE IT TO $clientID
                    $result= mysqli_query($connection, $sql);
//                    $row= mysqli_fetch_assoc($result);
                    while ($row= mysqli_fetch_assoc($result)){
                        $sql2="SELECT * FROM Designer WHERE id='".$row['designerID']."'";
                        $result2= mysqli_query($connection, $sql2);
                        $row2= mysqli_fetch_assoc($result2);
                        echo '<tr><td><img src="image/'.$row2['logoImgFileName'].'"alt= "'.$row2['firstName'].'\'s logo"><br><p>'.$row2['firstName'].' '.$row2['lastName'].'</p></td>';
                        $sql3="SELECT type FROM RoomType WHERE id='".$row['roomTypeID']."'";
                        $result3= mysqli_query($connection, $sql3);
                        $row3= mysqli_fetch_assoc($result3);
                        echo '<td>'.$row3['type'].'</td>';
                        echo '<td>'.$row['roomLength'].'x'.$row['roomWidth'].'</td>';
                        $sql4="SELECT category FROM DesignCategory WHERE id='".$row['designCategoryID']."'";
                        $result4= mysqli_query($connection, $sql4);
                        $row4= mysqli_fetch_assoc($result4);
                        echo '<td>'.$row4['category'].'</td>';
                        echo '<td>'.$row['colorPreferences'].'</td>';
                        echo '<td>'.$row['date'].'</td>';
                        $sql5="SELECT * FROM requeststatus WHERE id='".$row['statusID']."'";
                        $result5= mysqli_query($connection, $sql5);
                        $row5= mysqli_fetch_assoc($result5);
                        if($row5['status']=="consultation provided"){
                            $sql6="SELECT * FROM designconsultation WHERE requestID='".$row['id']."'";
                            $result6= mysqli_query($connection, $sql6);
                            $row6= mysqli_fetch_assoc($result6);
                            echo '<td><p>'.$row6['consultation'].'</p><br><img src="image/'.$row6['consultationImgFileName'].'" alt="designer\'s consulation" class="conImg"></td>';
                        }
                        else
                            echo '<td>'.$row5['status'].'</td>'; 
                        echo '</tr>';
                        
                    }
                ?>
                
<!--                <tr>
                    <td><img src="image/Tomsent.jpg" alt="Tomsent's Logo"><br><p>Tomsent Furniture</p></td>
                    <td>Living Room</td>
                    <td>4x5m</td>
                    <td>Modern</td>
                    <td>Blue and Whit</td>
                    <td>1/2/2023</td>
                    <td>Pending Consultation</td>
                </tr>
                <tr>
                    <td><img src="image/khadijaLogo.PNG" alt="Rahaf's Logo"><br><p>Khadija Altuwaijri</p></td>
                    <td>Bed Room</td>
                    <td>3x4m</td>
                    <td>Coastal</td>
                    <td>Beige and Green</td>
                    <td>30/12/2023</td>
                    <td>Consultation Declined</td>
                </tr>
                <tr>
                    <td><img src="image/RahafLogo.PNG" alt="Rahaf's Logo"><br> <p>Rahaf Alateeq</p></td>
                    <td>Kitchen</td>
                    <td>3x4m</td>
                    <td>Minimalist</td>
                    <td>Gray and White</td>
                    <td>1/1/2024</td>
                    <td><p>I will listen to your project requirements and goals, gaining a thorough understanding of your needs. We will discuss your target audience, conduct research, and gather inspiration to inform the design process.</p><br><img src="image/sketch.jpg" alt="designer's consulation" class="conImg"></td>
                </tr>-->
            </table>
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