<?php
    //session start
    require_once "../session.php";

    $nic= $_SESSION["id-5"];
    $sql = "SELECT * FROM normal_hospital WHERE UserName= '$nic'";

    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {

        $hospital_name = $row["Name"];
        $address = $row["Address"];
        $district = $row["District"];
        $chief_doctor = $row["Chief"];
        $user_name = $row["UserName"];
        $email = $row["Email"];
        }
    }
    else {
        echo "Something went wrong while loading...";
    }
    $sql2="SELECT TelephoneNo FROM normal_hospital_telephone WHERE username='$nic' ORDER BY Flag DESC";
    $result2=mysqli_query($link,$sql2);
    //create array
    $telephone_arr= array();
    $telephone_arr[1]="";
    $i=0;
    while($rows=mysqli_fetch_assoc($result2))
    {
        $telephone_arr[$i]=$rows["TelephoneNo"];
        $i++;
    }
    $mobi1 = $telephone_arr[1];
    $mobi2 = $telephone_arr[0];
    $count=mysqli_num_rows($result2);


    //close the db connection
    mysqli_close($link);


?>
<?php
    $hos_err=$username_err=$dr_err=$email_err=$add_err=$dis_err=$mobile_err="";
    if($_SERVER['REQUEST_METHOD']=="GET"){
        if (isset($_GET['hos'])) {$hos_err=$_GET['hos'];}
        if (isset($_GET['user'])) {$username_err=$_GET['user'];}
        if (isset($_GET['dr'])) {$dr_err=$_GET['dr'];}
        if (isset($_GET['email'])) {$email_err=$_GET['email'];}
        if (isset($_GET['add'])) {$add_err=$_GET['add'];}
        if (isset($_GET['dis'])) {$dis_err=$_GET['dis'];}
        if (isset($_GET['mobile'])) {$mobile_err=$_GET['mobile'];}

    }


?>
<?php
    include '../header.php';
?>

<body>

    <div class="container-row hospital">
        <?php require_once "../dashboard.php";?>

        <div class="main">
            <div class="topic">

            <form action="../application/edit.php?cou=<?php echo $count; ?>&modi1=<?php echo $mobi1; ?>&mobi2=<?php echo $mobi2;?>" method="post"> <!--  echo htmlspecialchars($_SERVER["PHP_SELF"]); -->
                <div class="form-row clearfix">
                    <div class="form-group <?php echo (!empty($hos_err)) ? 'has-error' : ''; ?>">
                        <label>Hospital Name</label>
                        <input type="text" name="hosname" class="form-control" value="<?php echo $hospital_name; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($add_err)) ? 'has-error' : ''; ?>">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($dis_err)) ? 'has-error' : ''; ?>">
                        <label>District</label>
                        <input type="text" name="district" class="form-control" value="<?php echo $district; ?>"> <!-- **** -->
                    </div>
                </div>

                <div class="form-row <?php echo (!empty($dr_err)) ? 'has-error' : ''; ?>">
                    <div class="form-group">
                        <label>Chief Doctor Name</label>
                        <input type="text" name="drname" class="form-control"value="<?php echo $chief_doctor; ?>">

                    </div>
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $user_name; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>Email Address</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">

                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group <?php echo (!empty($mobile_err)) ? 'has-error' : ''; ?>">
                        <label>Telephone Number</label>
                        <input type="number" name="mobile" class="form-control" value="<?php echo $mobi1; ?>">
                    </div>
                    <div class="form-group">
                        <label>Telephone Number</label>
                        <input type="number" name="mobile2" class="form-control" value="<?php echo $mobi2; ?>">
                    </div>


                </div>

                <!--
                    <div class="form-row clearfix">
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="text" name="addline1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="text" name="addline1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="text" name="addline2" class="form-control">
                    </div>

                </div>
                -->

            <center>
                <label><input type="submit" class="btn btn-primary" value="Submit" name="submit"></label>
                <div style="margin-top: 30px;">
                    <a href="edit_password.php" style="color: #848484; font-size: 15px;">Edit Password</a>
                </div>
            </center>

            </form>


        </div>
    </div>
    <?php include '../../footer.php'; ?>
</body>
