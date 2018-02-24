<?php
//connection file
require_once('../include/connection.php');
//connection object 
$query_object = new query_function();
//Variable Declaration 
$error = array();
$error['username'] = $error['email'] = $error['fname'] = $error['lname']
= $error['address'] = $error['city'] =$error['country'] = $error['aboutme']
= $error['postalcode'] = "";
$output = array();
$count = 0;
$var_user_fname = $var_user_lname =  $var_user_email = $var_user_username = 
$var_user_address = $var_user_city = $var_user_country = 
$var_user_postalcode = $var_user_aboutme ="";
$field = $data = "";
$set = "";
$display_username = $display_email = $display_fname = $display_lname = 
$display_address = $display_city = $display_country = $display_postalcode = 
$display_aboutme = "";
$table_name = 'user_profile';
$where_field = 'user_userid';
//Insert/Update Validation
if(isset($_POST['action'])){
   
//Username Validation      
    if(!($_POST['user_username'])==""){
        if (!(strlen($_POST['user_username']) >5 && strlen($_POST['user_username']) < 11)) {
            $count++;
            $error['username'] = "Username Must be between 6 to 10  characters";
        }
        else{
            if(!(preg_match("/^[_A-Za-z0-9]*$/", $_POST['user_username']))){
                $count++;
                $error['username'] = "Format Problem";
            }
            else{
                //echo "UserName: ".$_POST['user_username']."<br>";
                $var_user_username = mysqli_real_escape_string($_connection,$_POST['user_username']);
            }
        }
    }
    else{
        $count++;
        $error['username'] = "Username is required";
    }    
//Email-id Validation
    if(!($_POST['user_email'])== ""){
        // if (!(filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL))) {
            //  $error['email'] = "Wrong Email Format";
            //  $count++;
        //}
        if (!(preg_match("/^([-a-zA-Z0-9_.]+)@([-a-zA-Z0-9_.]+)\.([a-zA-Z])*$/",$_POST['user_email']))) {
            $count++;
            $error['email'] = "Wrong Email Format";
        }
        else{
            //echo "Email Id(regex): ".$_POST['user_email']."<br>";
            $var_user_email = mysqli_real_escape_string($_connection,$_POST['user_email']);
        }           
    }
    else{
        $count++;
        $error['email'] = "Email is Required";    
    } 
//First Name Validation
    if(!($_POST['user_fname']) == ""){
        if(!(strlen($_POST['user_fname']) <= 50)){
            $count++;
            $error['fname'] ="First name should be less than 50 characters";
        }
        else{
            //echo "First Name: ". $_POST['user_fname'] . "<br>";
            $var_user_fname = mysqli_real_escape_string($_connection,$_POST['user_fname']);
        }
    }
    else{
        $count++;
        $error['fname'] = "First Name Required";
    }
//Last Name Validation   
    if(!($_POST['user_lname']) == ""){
        if(!(strlen($_POST['user_lname']) <= 50)){
            $count++;
            $error['lname'] = "Last name should be less than 50 characters";
        }
        else{
            //echo "Last Name: ".$_POST['user_lname'] ."<br>";
            $var_user_lname = mysqli_real_escape_string($_connection,$_POST['user_lname']);
        }
    }
    else{
        $count++;
        $error['lname'] = "Last Name Required";
    }
//Address Validation
    if(!($_POST['user_address']== "")){
        if(!(strlen($_POST['user_address']) < 201 )) {
            $count++;
            $error['address'] = "Length problem";
        }
        else{
            //echo "Address: ".$_POST['user_address']."<br>";
            $var_user_address = mysqli_real_escape_string($_connection,$_POST['user_address']);
        }
    }
    else{
        $count++;
        $error['address'] = "Address is required";
    }
//City Validation
    if(!($_POST['user_city'])== ""){
        if(!(strlen($_POST['user_city']) < 101)){
            $count++;
            $error['city'] = "Too Long City Name";
        }
        else{
            //echo "City: ".$_POST['user_city']."<br>";
            $var_user_city = mysqli_real_escape_string($_connection,$_POST['user_city']);
        }
    }
    else{   
        $count++;
        $error['city'] = "City is Required";  
    }
//Country Validation
    if(!($_POST['user_country'])==""){
        //echo "Country: ".$_POST['user_country']."<br>";
        $var_user_country = mysqli_real_escape_string($_connection,$_POST['user_country']);
    }   
    else{
        $count++;
        $error['country'] = "Country is Required";       
    }
//Postal Code Validation
    if(!(($_POST['user_postalcode']) == "")){
        if(!(strlen($_POST['user_postalcode']) == 6 )) {
            $count++;
            $error['postalcode'] = "Must be 6 digits";
        }
        else{
            if(!(preg_match("/^[1-9][0-9]{5}/", $_POST['user_postalcode']))){
                $error['postalcode'] = "format Problem";
                $count++;
            }
            else{
                //echo "Postal-Code: ".$_POST['user_postalcode']."<br>";
                $var_user_postalcode = mysqli_real_escape_string($_connection,$_POST['user_postalcode']);
            }
        }
    }
    else{
        $count++;
        $error['postalcode'] = "Postal code is Required";   
    }
//About me Validation
    if(!(strlen($_POST['user_aboutme']) < 201 )) {
        $count++;
        $error['aboutme'] = "Length problem";
    }
    else{
        //echo "About me: ".$_POST['user_aboutme']."<br>";
        $var_user_aboutme = mysqli_real_escape_string($_connection,$_POST['user_aboutme']);
    }
//Validation Error OR Update Database
    if($count > 0){
        $error_json = json_encode($error);
        echo($error_json);
        exit;
    }
    else{
//Edit User Profile
       $where_data= $_POST['user_userid'];
        if(isset($_POST['action'])=="ajax_edit"){

             $success = "Updated Successfully";
            unset($_POST['action']);
           
            $set_array = $_POST;
            //Update Function Calling
            $update_output =  $query_object->update_data($table_name,$set_array,$where_field,$where_data,$_connection);
            if($update_output == 1){ 
                //$json_encode = json_encode($success);
                echo $success;
                exit;
            }
        }
//Add User Profile
        elseif(isset($_POST['action'])=="ajax_add"){
            unset($_POST['action']);
            $set_array = $_POST;
//Insert Function Calling
            $output_insert = $query_object->insert_data($table_name,$set_array,$_connection);
            if($output_insert == 1){
                $success = "Inserted Successfully";
                echo $success;
            }
        }
        
    }
    exit;
}
// Insert value on Load Event  
if((!empty($_GET['id'])) && $_GET['action']=="edit"){
    $where_data= $_GET['id'];
    $output =   $query_object->get_data($table_name,$where_field,$where_data,$_connection);
    if($output['success'] == 1){
        $display_username= $output['output']['user_username'];
        $display_email= $output['output']['user_email'];
        $display_fname= $output['output']['user_fname'];
        $display_lname= $output['output']['user_lname'];
        $display_address= $output['output']['user_address'];
        $display_city= $output['output']['user_city'];
        $display_country= $output['output']['user_country'];
        $display_postalcode= $output['output']['user_postalcode'];
        $display_aboutme= $output['output']['user_aboutme'];
    }
    else{
        header('location: index.php?msg=error');
    }
}
?>
<?php //Header & Left-side bar File ?>
<?php include('../layout/header.php'); ?>
<?php include('../layout/leftsidebar.php'); ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">User Profile</h4>
                    </div>
                <div class="content">
                    <form method="POST" >
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Company (disabled)</label>
                                    <input type="text" class="form-control" disabled placeholder="EventOZ Company" name="=user_company">
                                    <?php if((!empty($_GET['id']))) { ?> 
                                    <input type="hidden" name="user_userid" id="user_userid" value="<?php echo $_GET['id']; 
                                        ?>">
                                        <?php } ?>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Username</label>
                                    <span id="error_username" style="display:none;color:red"></span> 
                                    <input type="text" class="form-control" id="user_username" placeholder="Username" name="user_username" value="<?php echo $display_username; ?>" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <span id="error_email" style="display:none;color:red"></span> 
                                    <input type="email" class="form-control" id="user_email" placeholder="Email" name="user_email" value="<?php echo $display_email; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <span id="error_fname" style="display:none;color:red"></span> 
                                    <input type="text" class="form-control" id="user_fname" placeholder="First Name" name="user_fname" value="<?php echo $display_fname; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <span id="error_lname" style="display:none;color:red"></span> 
                                    <input type="text" class="form-control" id="user_lname" placeholder="Last Name" name="user_lname" value="<?php echo $display_lname; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <span id="error_address" style="display:none;color:red"></span>
                                    <textarea type="text" class="form-control" id="user_address" placeholder="Home Address" rows=5 cols=10 name="user_address"><?php echo $display_address;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <span id="error_city" style="display:none;color:red"></span> 
                                    <input type="text" class="form-control" id="user_city" placeholder="City" name="user_city" value="<?php echo $display_city; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <span id="error_country" style="display:none;color:red"></span> 
                                    <input type="text" class="form-control" id="user_country" placeholder="Country" name="user_country" value="<?php echo $display_country; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="number" class="form-control" id="user_postalcode" placeholder="Postal Code" name="user_postalcode" value="<?php echo $display_postalcode; ?>">
                                    <span id="error_postalcode" style="display:none;color:red"></span> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>About Me</label>
                                    <span id="error_aboutme" style="display:none;color:red"></span>
                                    <textarea rows="5" class="form-control" id="user_aboutme" placeholder="Here can be your description" name="user_aboutme"> <?php echo $display_aboutme; ?> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <div class="form-group pull-right">
                                    <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){ ?>
                                        <button type="submit" class="btn btn-info btn-fill pull-right" id="user_submit"  name="edit_user">Edit User</button>
                                    <?php
                                        } else {
                                    ?>
                                        <button type="submit" id="user_submit" class="btn btn-info btn-fill pull-right" name="add_user">Add User</button>
                                    <?php    
                                        } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //Footer File ?>
<?php include('../layout/footer.php'); ?>
<?php //Jquery & AJAX ?>
<script type="text/javascript">
    //Load Event
    jQuery(document).ready(function(){
        //Username 
        jQuery("#user_username").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <11){
                    var UsernameRegex = new RegExp(/^[a-z0-9_]*$/);
                    if(UsernameRegex.test(jQuery(this).val())){
                        jQuery(this).css('border','1px solid green');
                    }
                    else{
                        jQuery(this).css('border','1px solid red');
                    }
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //Email
        jQuery("#user_email").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <51){
                    var emailRegex = new RegExp(/^([-a-zA-Z0-9_.]+)@([-a-zA-Z0-9_.]+)\.([a-zA-Z])*$/);
                    if(emailRegex.test(jQuery(this).val())){
                        jQuery(this).css('border','1px solid green');
                    }
                    else{
                        jQuery(this).css('border','1px solid red');
                    }
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //First Name
        jQuery("#user_fname").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <51){
                    jQuery(this).css('border','1px solid green');
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }

        });
        //Last Name
        jQuery("#user_lname").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <51){
                    jQuery(this).css('border','1px solid green');
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //Address
        jQuery("#user_address").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <201){
                    jQuery(this).css('border','1px solid green');
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //City
        jQuery("#user_city").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <31){
                    jQuery(this).css('border','1px solid green');
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //Country
        jQuery("#user_country").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <31){
                    jQuery(this).css('border','1px solid green');
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //Postal Code
        jQuery("#user_postalcode").on('blur',function(e){
            if(jQuery(this).val()==""){
                jQuery(this).css('border','1px solid red');
            }
            else{
                if(jQuery(this).val().length <7){
                    var pattern = new RegExp(/^[1-9][0-9]{5}/);
                    if(pattern.test(jQuery(this).val())){
                        jQuery(this).css('border','1px solid green');
                    }
                    else{
                        jQuery(this).css('border','1px solid red');
                    }
                }
                else{
                    jQuery(this).css('border','1px solid red');
                }
            }
        });
        //About Me
        jQuery("#user_aboutme").on('blur',function(e){
            if(jQuery(this).val().length >200){
                jQuery(this).css('border','1px solid red');
            }
            else{
                jQuery(this).css('border','1px solid green');
            }
        });
//Button Click Event
        jQuery("#user_submit").on('click',function(e){
            var count = 0;
            //Username
            if(jQuery("#user_username").val()==""){
                jQuery("#user_username").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_username").val().length <11){
                    var UsernameRegex = new RegExp(/^[a-z0-9_]*$/);
                    if(UsernameRegex.test(jQuery("#user_username").val())){
                        jQuery("#user_username").css('border','1px solid green');
                    }
                    else{
                        jQuery("#user_username").css('border','1px solid red');
                        count++;        
                    }
                }
                else{
                    jQuery("#user_username").css('border','1px solid red');
                    count++;       
                }
            }
            //Email
            if(jQuery("#user_email").val()==""){
                jQuery("#user_email").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_email").val().length <51){
                    var emailRegex = new RegExp(/^([-a-zA-Z0-9_.]+)@([-a-zA-Z0-9_.]+)\.([a-zA-Z])*$/);
                    if(emailRegex.test(jQuery("#user_email").val())){
                        jQuery("#user_email").css('border','1px solid green');
                    }
                    else{
                        jQuery("#user_email").css('border','1px solid red');
                        count++;
                    }
                }
                else{
                    jQuery("#user_email").css('border','1px solid red');
                    count++;        
                }
            }
            //First Name
            if(jQuery("#user_fname").val()==""){
                jQuery("#user_fname").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_fname").val().length <51){
                    jQuery("#user_fname").css('border','1px solid green');
                }
                else{
                    jQuery("#user_fname").css('border','1px solid red');
                    count++;        
                }
            }
            //Last Name
            if(jQuery("#user_lname").val()==""){
                jQuery("#user_lname").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_lname").val().length <51){
                    jQuery("#user_lname").css('border','1px solid green');
                }
                else{
                    jQuery("#user_lname").css('border','1px solid red');
                    count++;        
                }
            }
            //Address
            if(jQuery("#user_address").val()==""){
                jQuery("#user_address").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_address").val().length <201){
                    jQuery("#user_address").css('border','1px solid green');
                }
                else{
                    jQuery("#user_address").css('border','1px solid red');
                    count++;        
                }
            }
            //City
            if(jQuery("#user_city").val()==""){
                jQuery("#user_city").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_city").val().length <31){
                    jQuery("#user_city").css('border','1px solid green');
                }
                else{
                    jQuery("#user_city").css('border','1px solid red');
                    count++;        
                }
            }
            //Country
            if(jQuery("#user_country").val()==""){
                jQuery("#user_country").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_country").val().length <31){
                    jQuery("#user_country").css('border','1px solid green');
                }
                else{
                    jQuery("#user_country").css('border','1px solid red');
                    count++;        
                }
            }
            //Postal Code
            if(jQuery("#user_postalcode").val()==""){
                jQuery("#user_postalcode").css('border','1px solid red');
                count++;
            }
            else{
                if(jQuery("#user_postalcode").val().length <7){
                    var pattern = new RegExp(/^[1-9][0-9]{5}/);
                    if(pattern.test(jQuery("#user_postalcode").val())){
                        jQuery("#user_postalcode").css('border','1px solid green');
                    }
                    else{
                        jQuery("#user_postalcode").css('border','1px solid red');
                        count++;
                    }
                }
                else{
                    jQuery("#user_postalcode").css('border','1px solid red');
                    count++;        
                }
            }
            //About me
            if(jQuery(this).val().length >200){
                count++;
                jQuery(this).css('border','1px solid red');
            }
            else{
                jQuery(this).css('border','1px solid green');
            }
            //If Error Else Edit/Update
            if(count>0){
                return false;
            }
            else{
                var user_username = jQuery('#user_username').val();
                var user_userid = jQuery('#user_userid').val();
                alert(user_userid);
                var user_email = jQuery('#user_email').val();
                var user_fname = jQuery('#user_fname').val();
                var user_lname= jQuery('#user_lname').val();
                var user_address = jQuery('#user_address').val();
                var user_city = jQuery('#user_city').val();
                var user_country = jQuery('#user_country').val();
                var user_postalcode = jQuery('#user_postalcode').val();
                var user_aboutme = jQuery('#user_aboutme').val();
                jQuery.ajax({
                    method: "POST",
                    url: "<?php echo BASE_URL; ?>user/user_manipulation.ph",
                    data: { user_username:user_username,action:"ajax_edit",user_email:user_email,user_fname:user_fname,user_lname:user_lname,user_address:user_address,user_city:user_city,user_country:user_country,user_postalcode:user_postalcode,user_aboutme:user_aboutme,user_userid:user_userid }
                }).done(function( msg ) {
                    alert(msg); 
                   window.location.href="<?php echo BASE_URL; ?>user/index.php";
                });
                return false; 
            }
            
        });
});


</script>