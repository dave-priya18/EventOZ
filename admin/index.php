<?php 
require('include/connection.php');
//require('include/function.php');
$error = array();
$error['username']  = "";
$error['password'] = "";
$login_username = $login_password = $var_password = $var_username= "";
$count = 0;

if(isset($_POST['login'])){
//Validation - Username and Password


//Username Validation

    if(!($_POST['login_username'])==""){
        $var_username = $_POST['login_username'];
    }
    else{
        $count++;
        $error['username'] = "Username is required";
    }               

//Password Validation

    if(!($_POST['login_password'])==""){
        $var_password = md5($_POST['login_password']);
    }
    else{
        $count++;
        $error['password'] = "Password is Required";
    }

    if($count != 0){
        ?>
        <script type="text/javascript">alert("Invalid Username or Password.\n Please Re-enter.");</script>
        <?php
    }
    else{
//Login Function 
        $table_name = 'admin_login';
        $field_name = array('admin_username','admin_password');
        $data_value = array($var_username,$var_password);

       $fetch_data = login_data($table_name,$field_name,$data_value,$_connection);
      // print_r($fetch_data);
      // exit;
    
// Username and Password match
        if($fetch_data){ 
            $_SESSION['admin_credential'] = $fetch_data['output'];
            header('location: dashboard.php'); 
        }
        else{
            header('location: index.php');     
        }
    }
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
                    <div class="content">
                        <form method="POST">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <span style="color:red">* <?php echo $error['username'];?></span>
                                    <input type="text" class="form-control" name="login_username" placeholder="Username" maxlength="10" minlength="6">         
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <span style="color:red">* <?php echo $error['password'];?></span> 
                                    <input type="password" class="form-control" name="login_password" placeholder="Password"
                                    maxlength="16" minlength="6" >        
                                </div>
                            </div>
                        </div>
                            <button type="submit" name="login" class="btn btn-info btn-fill pull-right">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>