<!-- Connection File -->
<?php
    require('../include/connection.php');
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
//Delete Functionality

if((!empty($_GET['id'])) && $_GET['action']=="delete"){
    $where_data= $_GET['id'];
    $delete_output = delete_data($table_name,$where_field,$where_data,$_connection);
    if($delete_output == 1){ ?>
        <script type="text/javascript"> alert('User Deleted Successfully');</script>
        <?php
        header('Location: index.php');
    }
    else{
        ?>
        <script type="text/javascript">alert('Something is wrong. Data is not deleted');</script>
        <?php
    }

}
//Insert/Update Validation

if((isset($_POST['add_user']))||(isset($_POST['edit_user'])) ){
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
                $var_user_username = $_POST['user_username'];
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
            $var_user_email = $_POST['user_email'];
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
            $var_user_fname = $_POST['user_fname'];
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
            $var_user_lname = $_POST['user_lname'];
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
            $var_user_address = $_POST['user_address'];
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
            $var_user_city = $_POST['user_city'];
        }
          
    }
    else{   
        $count++;
        $error['city'] = "City is Required";  
    }
//Country Validation
    if(!($_POST['user_country'])==""){
        //echo "Country: ".$_POST['user_country']."<br>";
        $var_user_country = $_POST['user_country'];
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
                $var_user_postalcode = $_POST['user_postalcode'];
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
        $var_user_aboutme = $_POST['user_aboutme'];
    }


//Edit User Profile
    if(isset($_POST['edit_user'])){
    $x=1;
    $where_data= $_GET['id'];
        foreach($_POST as $key=>$value){
            if($key != "edit_user"){
                $set .= "{$key} = \"{$value}\"";
                if($x < count($_POST)-1) {
                    $set .= ',';
                }
                $x++;
            } 
        }

//Update Function Calling
    $update_output =  update_data($table_name,$set,$where_field,$where_data,$_connection);
        if($update_output == 1){ 
            header('location: index.php');
            exit;
        }
        else{
            ?>
            <script type="text/javascript">alert('Error in updating');</script>
            <?php
            header('location: user_manipulation.php');
            exit;
        } 
    }
//Add User Profile
    if(isset($_POST['add_user'])){
        $x=1;
        foreach($_POST as $key=>$value){
            if($key != "add_user"){
                $field .= $key;
                $data .= "'".$value."'";
                if($x < count($_POST)-1) {
                    $field .= ',';
                    $data .= ',';
                }
                $x++;
            }  
        }
    }
//Insert Function Calling
    $output_insert = insert_data($table_name,$field,$data,$_connection);
    if($output_insert == 1){
        header('Location: index.php');
        exit;
    }
    else{
        ?>
        <script type="text/javascript">alert('Something is Wrong!');</script>
        <?php
        header('location: user_manipulation.php');
        exit;
    }
    
}
// Array ( [id] => 10 [action] => edit ) 

    if((!empty($_GET['id'])) && $_GET['action']=="edit"){
        $where_data= $_GET['id'];
        $output =  get_data($table_name,$where_field,$where_data,$_connection);
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
<!-- Header File -->
<?php include('../layout/header.php'); ?>
<!-- Left Side Bar File -->
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
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Username</label>
                                <span class="error" style="color:red">* <?php echo $error['username'];?></span> 
                                <input type="text" class="form-control" placeholder="Username" name="user_username" value="<?php echo $display_username; ?>" >
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <span class="error" style="color:red">* <?php echo $error['email'];?></span> 
                                <input type="email" class="form-control" placeholder="Email" name="user_email" value="<?php echo $display_email; ?>">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <span class="error" style="color:red">* <?php echo $error['fname'];?></span> 
                                <input type="text" class="form-control" placeholder="First Name" name="user_fname" value="<?php echo $display_fname; ?>">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <span class="error" style="color:red">* <?php echo $error['lname'];?></span> 
                                <input type="text" class="form-control" placeholder="Last Name" name="user_lname" value="<?php echo $display_lname; ?>">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <span class="error" style="color:red">* <?php echo $error['address'];?></span> 
                                <textarea type="text" class="form-control" placeholder="Home Address" rows=5 cols=10 name="user_address"> <?php echo $display_address; ?> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City</label>
                                <span class="error" style="color:red">* <?php echo $error['city'];?></span> 
                                <input type="text" class="form-control" placeholder="City" name="user_city" value="<?php echo $display_city; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country</label>
                                <span class="error" style="color:red">* <?php echo $error['country'];?></span> 
                                <input type="text" class="form-control" placeholder="Country" name="user_country" value="<?php echo $display_country; ?>">
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="number" class="form-control" placeholder="Postal Code" name="user_postalcode" value="<?php echo $display_postalcode; ?>">
                                <span class="error" style="color:red">* <?php echo $error['postalcode'];?></span> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>About Me</label>
                                <span class="error" style="color:red">* <?php echo $error['aboutme'];?></span> 
                                <textarea rows="5" class="form-control" placeholder="Here can be your description" name="user_aboutme"> <?php echo $display_aboutme; ?> </textarea>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="form-group pull-right">
                            <?php
                                if((!empty($_GET['id']))  && $_GET['action']=="edit"){ ?>
                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="edit_user">Edit User</button>
                                <?php
                                } else {
                                ?>
                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="add_user">Add User</button>
                                <?php    } ?>
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



<!-- Footer File -->
<?php include('../layout/footer.php'); ?>


