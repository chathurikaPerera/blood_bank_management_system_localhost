<?php
    
require_once "../session.php";

    $nic = $_SESSION["id-4"];

    $sql2 = "SELECT  TelephoneNo FROM organization_telephone WHERE OrgId = '$nic' ORDER BY Flag DESC";
    $result2 = mysqli_query($link, $sql2);
    $count= mysqli_num_rows($result2);

   $telephone= array();
   $telephone[1]="";
    $i=0;
    while ($rows=mysqli_fetch_assoc($result2)) {
    $telephone[$i]= $rows["TelephoneNo"];
    $i++;
    }

    $tel1= $telephone[0];
    $tel2= $telephone[1];

    // form submission editing
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // validate username
        if(empty(trim($_POST["username"])))
        {
            $username_err="Please enter a user name";
            set_user_name_err($username_err);

        }elseif(trim($_POST["username"])=="$nic"){
            $user_name=trim($_POST["username"]);
        }
        else
        {
            //prepare statement
            $sql="SELECT UserName FROM organization WHERE UserName=?";
            if($stmt=mysqli_prepare($link,$sql))
            {
                mysqli_stmt_bind_param($stmt,"s",$param_username);
                //set parameter
                $param_username=trim($_POST["username"]);

                //execute the prepare ststement
                if(mysqli_stmt_execute($stmt))
                {
                    //store the result
                    mysqli_stmt_store_result($stmt);
                    //count no of rows
                  
                    if(mysqli_stmt_num_rows($stmt)==1)
                    {
                        $username_err="This user name is already taken";
                         set_user_name_err($username_err);
                    }
                    else{
                        $user_name=trim($_POST["username"]);
                    }
                }
                else{
                    echo "Something went wrong. Please try again later.";

                }
                //close the statement
                mysqli_stmt_close($stmt);


                
            }
        }

        //validate organization name
        if(empty(trim($_POST["orgname"])))
        {
            $org_err="Please enter Organization name";
            set_org_name_err($org_err);
        }
        else{
            $org_name=trim($_POST["orgname"]);
        }
        //validate location
        if(empty(trim($_POST["location"])))
        {
            $district_err="Please enter the Location";
            set_district_err($district_err);
        }
        else{
            $district=trim($_POST["location"]);
        }
        
        //validate president name
        if(empty(trim($_POST["name"])))
        {
            $president_err="Please enter the President name";
            set_pname_err($president_err);
        }
        else{
            $president=trim($_POST["name"]);
        }
        //validate mobile number
        if(empty(trim($_POST["mobile"])))
        {
            $mobile_err="Please enter your Telephone number";
            set_telephone_err($mobile_err);

        }elseif (strlen(trim($_POST["mobile"]))!=10) {
            $mobile_err="Telephone number must have 10 digits";
            set_telephone_err($mobile_err);
        }else{
            $mobile=trim($_POST["mobile"]);
        }
        //validate mobile number
        if(empty(trim($_POST["email"])))
        {
            $email_err="Please enter your Email";
            set_email_err($email_err);
        }
        else{
            $email=trim($_POST["email"]);
        }

        $purpose= $_POST["purpose"];
        $mobile2= $_POST["mobile2"];
        if(!empty(trim($_POST["mobile2"]))){
            if (strlen(trim($_POST["mobile2"]))!=10) {
                $mobile2_err="Telephone number must have 10 digits";
                set_telephone2_err($mobile2_err);
            }
        }

        if (empty($username_err)&& empty($org_err) && empty($district_err) && empty($mobile_err) && empty($president_err) && empty($email_err) && empty($mobile2_err)) {
            $sql= "UPDATE organization SET OrganizationName=?, District=?, President=?, UserName=?, Purpose=?, Email=? WHERE UserName='$nic'";

            if($stmt=mysqli_prepare($link,$sql))
            {
                mysqli_stmt_bind_param($stmt,"ssssss",$org_name,$district,$president,$param_username,$purpose,$email);
                
                //set parameters
                $param_username=$user_name;

                //update session
                $_SESSION["id-4"]="$user_name";

                //execute the prepare statement
                if(mysqli_stmt_execute($stmt))
                {       $sql1= "UPDATE organization_telephone SET OrgID='$user_name', TelephoneNo='$mobile' WHERE OrgId='$nic' AND TelephoneNo='$tel1'";
                    if (mysqli_query($link, $sql1)){

                        if ($count==2) {
                            $sql2= "UPDATE organization_telephone SET OrgID='$user_name', TelephoneNo='$mobile2' WHERE OrgId='$nic' AND TelephoneNo='$tel2'";
                            mysqli_query($link, $sql2);
                        }else {
                            $sql3= "INSERT INTO organization_telephone (OrgId, TelephoneNo) VALUES ('$user_name','$mobile2')";
                            mysqli_query($link, $sql3);
                        }

                    }else{echo "Telephone1 errors";}
                    
                    // Redirect to login page
                    unset_cache();
                    header("location: ../profile/index?update=ok");
                }
                else{
                    echo "Something went wrong, please try again later2";
                }
                //close statement
                mysqli_stmt_close($stmt);

            }
        }else{
            header("Location: ../profile/edit-organization");
        }



        // Close connection
        mysqli_close($link);

    }




?>