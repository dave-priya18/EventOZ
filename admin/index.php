<?php 
require('include/connection.php');


$obj = new query_function();

 
    if(isset($_POST['action']) &&  $_POST['action']=="ajax") {

        $error = array();
$error['username']  = "";
$error['password'] = "";
$admin_username = $admin_password = $var_password = $var_username= "";
$count = 0;
//Validation - Username and Password


//Username Validation

    if(!($_POST['admin_username'])==""){
        $var_username = $_POST['admin_username'];
    }
    else{
        $count++;
        $error['username'] = "Username is required";
    }               

//Password Validation

    if(!($_POST['admin_password'])==""){
        $var_password = md5($_POST['admin_password']);
    }
    else{
        $count++;
        $error['password'] = "Password is Required";
    }

    if($count != 0){
       $error_json = json_encode($error);
       echo $error_json;
    }
    else{
//Login Function 
        $table_name = 'admin_login';
        $field_name = array('admin_username','admin_password');
        $data_value = array($var_username,$var_password);

       $fetch_data = $obj->login_data($table_name,$field_name,$data_value,$_connection);
    
// Username and Password match
        if($fetch_data){ 
            $_SESSION['admin_credential'] = $fetch_data['output'];
           // header('location: dashboard.php'); 
        }
        else{
          //  header('location: index.php');     
        }
    }
    exit;
}

        
include ('layout/header.php'); ?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Login</h4>
                    </div>
                    <div class="content" id="fieldset">
                        <form method="POST">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <span  id="error_username" style="display:none;color:red"></span>
                                    <input type="text" class="form-control" id="admin_username" name="admin_username" placeholder="Username" maxlength="10" minlength="6">         
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <span id="error_password" style="display:none;color:red"></span> 
                                    <input type="password" class="form-control"  id="admin_password"  name="admin_password" placeholder="Password"
                                    maxlength="16" minlength="6" >        
                                </div>
                            </div>
                        </div>
                            <button type="submit" id="login" name="login" class="btn btn-info btn-fill pull-right">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
    var count=0;
    jQuery("#admin_username").on('blur',function(e){
       if(jQuery(this).val()==""){
            jQuery(this).css('border','1px solid red');
     }
       else{
           jQuery(this).css('border','1px solid green');
       }

    });
    jQuery("#admin_password").on('blur',function(e){
    var count=0;
    if(jQuery(this).val()==""){
        jQuery(this).css('border','1px solid red');
        count++;
            
    }
    else{
        jQuery(this).css('border','1px solid green');
    }
    });

    if(count>0){
        return false;
    }


    jQuery("#login").on('click',function(e){
        var admin_username = jQuery('#admin_username').val();
        var admin_password = jQuery('#admin_password').val();
      
        jQuery.ajax({
            method: "POST",
            url: "<?php echo BASE_URL; ?>index.php",
            data: { admin_username:admin_username,admin_password:admin_password,action:"ajax" }
        }).done(function( msg ) {
            if(msg==""){
                window.location.href = "<?php echo BASE_URL; ?>dashboard.php";
            }
            else{
                    var get_error = jQuery.parseJSON(msg);
                    jQuery("#error_username").text(get_error.username);
                    jQuery("#error_password").text(get_error.password);
                    jQuery("#error_username").show();
                    jQuery("#error_password").show();  
                }
                    });
                    return false; 
            
    });
});

</script>
