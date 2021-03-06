<?php
	require '../../session.php';
    include 'nic_validator.php';

	// Define variables and initialize with empty values
    $nic = $password = $first_name=$last_name=$confirm_password=$hosid=$email= "";
    $nic_err = $password_err = $first_name_err = $last_name_err = $confirm_password_err = $hosid_err = $email_err="";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){unset_cache();  // delete previous cache values and triggering

        // Validate nic /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(empty(trim($_POST["nic"]))){
        $nic_err = "Please enter an NIC.";
        set_nic_err($nic_err);
    }elseif (!is_valid_nic($_POST['nic'])) {
        $nic_err = "Your NIC is not Valid.";
        set_nic_err($nic_err);
    }else{
        // Prepare a select statement 
        $sql = "SELECT BAdminID FROM blood_bank_admin WHERE NIC = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["nic"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $nic_err = "This username is already taken.";
                    set_nic_err($nic_err);
                } else{
                    $temp = trim($_POST["nic"]);
                    $nic =  strtoupper($temp);
                    set_nic($nic);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

    }
        // Validate Hos ID /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(empty(trim($_POST["hosid"]))){
         $hosid_err = "enter an Hospital ID.";
         set_hospital_err($hosid_err);
    }else{
        // Prepare a select statement 
        $sql2 = "SELECT Name FROM blood_bank_hospital WHERE HospitalID = ?";
        
        if($stmt2 = mysqli_prepare($link, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["hosid"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
                /* store result */
                mysqli_stmt_store_result($stmt2);
                
                if(mysqli_stmt_num_rows($stmt2) == 0){
                    $hosid_err = "No Such a Hospital.";
                    set_hospital_err($hosid_err);
                } else{
                    $hosid = trim($_POST["hosid"]);
                    set_hospital($hosid);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt2);
        }
    }    

    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";  
        set_password_err($password_err);   
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
        set_password_err($password_err);
    } else{
        $password = trim($_POST["password"]);
        set_password($password);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password."; 
        set_confirm_err($confirm_password_err);    
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        set_confirm($confirm_password);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
            set_confirm_err($confirm_password_err);
        }
    }

    // Validate firstname
    if(empty(trim($_POST["first_name"]))){
        $first_name_err = " enter a first name."; 
        set_first_name_err($first_name_err);    
    } else{
        $first_name = ucwords(trim($_POST["first_name"]));
        set_first_name($first_name);
    }

     // Validate Email
    if(empty(trim($_POST["email"]))){
        $email_err = " enter your email";
        set_email_err($email_err);     
    } else{
        $email = trim($_POST["email"]);
        set_email($email);
    }

    // Validate lastname
    if(empty(trim($_POST["last_name"]))){
        $last_name_err = " enter a last name.";  
        set_last_name_err($last_name_err);   
    } else{
        $last_name = ucwords(trim($_POST["last_name"]));
        set_last_name($last_name);
    }
    
    // Check input errors before inserting in database
    if(empty($nic_err) && empty($password_err) && empty($confirm_password_err) && empty($first_name_err) && empty($last_name_err) && empty($hosid_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO blood_bank_admin (NIC, Password, FirstName, LastName, BloodBankID, Email) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $first_name, $last_name, $hosid, $email);
            
            // Set parameters
            $param_username = $nic;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                unset_cache();
                header("location: ../index?reg=ok");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }else{
    	/*header("Location: ../new_admin?nic=$nic_err&conf=$confirm_password_err&pass=$password_err&first=$first_name_err&last=$last_name_err&hosid=$hosid_err&email=$email_err&fnic=$nic&ffirst=$first_name&flast=$last_name&femail=$email&fhosid=$hosid");*/
        header("Location: ../new_admin");
    }
    
    // Close connection
    mysqli_close($link);
    
    }else{
        header("Location:../../../reg_login.php");
    }
?>