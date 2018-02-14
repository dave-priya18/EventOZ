<?php  include('include/connection.php'); ?>

<?php

    $date = date("d/m/Y");

   
    $_conference_title_error= $_conference_desc_error = $_conference_image_error=
    $_conference_end_date_error = $_conference_start_date_error = $_conference_venue_error = $_conference_city_error = $_conference_country_error = $_conference_postalcode_error = $_conference_state_error = "";
    $error=0;
    $count=0;
    $var_conference_title =  $var_conference_desc = $var_conference_image  =
   $var_conference_start_date = $var_conference_end_date=
   $var_conference_venue = $var_conference_city =$var_conference_state = $var_conference_country = $var_conference_postalcode = "";
    $display_title = $display_desc= $display_image =  $display_start_date=$display_end_date = $display_venue = $display_city = $display_state = $display_country = $display_postalcode="";
   
    $adminid= $_SESSION['admin_credential']['admin_id'];
    

if(isset($_POST['add_conference'])){
//About us title Validation

        if(!($_POST['_conference_title'])==""){
            if (!(strlen($_POST['_conference_title']) < 31)) {
                $count++;
                $_conference_title_error = "Title should be under 30 characters";
            }
            else{
                    //echo "Title: ".$_POST['conference_title']."<br>";
                    $var_conference_title = $_POST['_conference_title'];
              }
        }
        else{
            $count++;
            $_conference_title_error = "Title is required";
        }


//Description Validation
        if(!($_POST['_conference_desc']== "")){
            if(!(strlen($_POST['_conference_desc']) < 201 )) {
                $count++;
                $_conference_desc_error = "Length problem";
            }
            else{
                //echo "Description : ".$_POST['conference_desc']."<br>";
                $var_conference_desc = $_POST['_conference_desc'];
            }
        }
        else{
            $count++;
            $_conference_desc_error = "Description is required";
        }
// Image Validation

        if(!(empty($_FILES['_conference_image']['name']))){
          $var_conference_image = $_FILES['_conference_image']['name'];
          $target_folder = CONFERENCE_PATH;
          $target_file = $target_folder . basename($_FILES['_conference_image']['name']);

// Select file type
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Valid file extensions
          $extensions_arr = array("jpg","jpeg","png","gif");

// Check extension
          if( in_array($imageFileType,$extensions_arr) ){
 // Upload file
              move_uploaded_file($_FILES['_conference_image']['tmp_name'],$target_folder.$var_conference_image);
          }
          else{
            $count++;
            $_conference_image_error = "Please upload image file";
          }
        }
        else{
          $count++;
          $_conference_image_error = "Image is required";
        }
//Start Date Validation
        if(!($_POST['_conference_start_date'] == "")) {
            
            if(($_POST['_conference_start_date'] <= $date )){
                $count++;
                $_conference_start_date_error = "Date is invalid";
            }

            else{
                 $var_conference_start_date =$_POST['_conference_start_date'];
            }
        }
        else{
            $count++;
            $_conference_start_date_error = "Can not be empty";
        }

//End Date Validation
        if(!($_POST['_conference_end_date'] == "")) {
            print_r($_POST['_conference_end_date'] > $_POST['_conference_start_date']);
            if(!($_POST['_conference_end_date'] > $_POST['_conference_start_date']) ){
                $count++;
                $_conference_end_date_error = "Date is invalid";
            }
            else{
                 $var_conference_end_date =$_POST['_conference_end_date'];
            }
        }
        else{
            $count++;
            $_conference_end_date_error = "Can not be empty";
        }

//venue Validation


        if(!($_POST['_conference_venue']== "")){
            if(!(strlen($_POST['_conference_venue']) < 201 )) {
                $count++;
                $_conference_venue_error = "Length problem";
            }
            else{
                //echo "venue: ".$_POST['_conference_venue']."<br>";
                $var_conference_venue = $_POST['_conference_venue'];
            }
        }
        else{
            $count++;
            $_conference_venue_error = "venue is required";
        }
        
            

        
//City Validation

        if(!($_POST['_conference_city'])== ""){
            if(!(strlen($_POST['_conference_city']) < 31)){
                $count++;
                $_conference_city_error = "Too Long City Name";
            }
            else{
                //echo "City: ".$_POST['_conference_city']."<br>";
                $var_conference_city = $_POST['_conference_city'];
            }
              
        }
        else{   
            $count++;
            $_conference_city_error = "City is Required";  
        }
        
//State Validation

        if(!($_POST['_conference_state'])== ""){
            if(!(strlen($_POST['_conference_state']) < 31)){
                $count++;
                $_conference_state_error = "Too Long State Name";
            }
            else{
                //echo "City: ".$_POST['_conference_city']."<br>";
                $var_conference_state = $_POST['_conference_state'];
            }
              
        }
        else{   
            $count++;
            $_conference_state_error = "City is Required";  
        }
        


//Country Validation
        if(!($_POST['_conference_country'])==""){
            //echo "Country: ".$_POST['_conference_country']."<br>";
            $var_conference_country = $_POST['_conference_country'];
        }   
        else{
            $count++;
            $_conference_country_error = "Country is Required";       
        }

//Postal Code Validation

        if(!(($_POST['_conference_postalcode']) == "")){
            if(!(strlen($_POST['_conference_postalcode']) == 6 )) {
                $count++;
                $_conference_postalcode_error = "Must be 6 digits";
            }
            else{
                if(!(preg_match("/^[1-9][0-9]{5}/", $_POST['_conference_postalcode']))){
                    $_conference_postalcode_error = "format Problem";
                    $count++;
                }
                else{
                    //echo "Postal-Code: ".$_POST['_conference_postalcode']."<br>";
                    $var_conference_postalcode = $_POST['_conference_postalcode'];
                }
            }
        }
        else{
            $count++;
            $_conference_postalcode_error = "Postal code is Required";   
        }







//Insert Query

        if($count>0){
            echo "Invalid Input";
        }
        else{

            //DB Connection and Insert
            $select_query_all = "SELECT * FROM `conference_detail` WHERE
            conference_title = '".$var_conference_title."' and admin_id='".$_SESSION['admin_credential']['admin_id']."'";
            $result_all=mysqli_query($_connection,$select_query_all);
            if($row_all = mysqli_fetch_array($result_all)){
                 echo "<script type='text/javascript'>alert('Information is already there!')</script>";
            }
            else{
              echo $insert_query = "INSERT INTO `conference_detail`(`conference_title`, `conference_image`, `conference_desc`, `admin_id`,`created_by`,`conference_start_date`,`conference_end_date`,`conference_landmark`, `conference_city`, `conference_state`, `conference_country`, `conference_postalcode`) VALUES
              ('".$var_conference_title."','".$var_conference_image."','".$var_conference_desc."','".$_SESSION['admin_credential']['admin_id']."','".$_SESSION['admin_credential']['admin_id']."','".$var_conference_start_date."','".$var_conference_end_date."','".$var_conference_venue."','".$var_conference_city."','".$var_conference_state."','".$var_conference_country."','".$var_conference_postalcode."')";
              if (mysqli_query($_connection,$insert_query)) {
                echo "<script type='text/javascript'>alert('Record inserted successfully!')</script>";
                ob_start();
                header('Location: conference.php');
              }
              else {
                $error= mysqli_error($_connection);
                echo "<script type='text/javascript'>alert('$error!')</script>";
              }
            }
          }
        }



?>

<?php include('layout/header.php'); ?>

<?php include('layout/leftsidebar.php'); ?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">About Us</h4>
                    </div>
                    <div class="content">
                        <form method="POST" action="" enctype='multipart/form-data'>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <span style="color:red">* <?php echo $error['title'];?></span>
                                        <input type="text" class="form-control" placeholder="Title of Conference" name="conference_title" maxlength="30">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <span style="color:red">* <?php echo $error['desc'];?></span>
                                        <textarea class="form-control" placeholder="Description of About Us" rows="5" cols="20" name="conference_desc" maxlength="20"> </textarea>      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <span class="error" style="color:red">* <?php echo $error['image']; ?>></span>
                                        <input type="file" name="conference_image" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <span style="color:red">* <?php echo $error['start_date'];?></span> 
                                        <input type="Date" class="form-control" placeholder="Start Date" name="conference_start_date" value="<?php echo $display_start_date; ?>">   
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <span style="color:red">* <?php echo $error['end_date'];?></span>
                                        <input type="Date" class="form-control" placeholder="End Date" name="conference_end_date" value="<?php echo $display_end_date; ?>">      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Conference Venue</label>
                                         <span style="color:red">* <?php echo $error['venue'];?></span> 
                                        <input type="text" class="form-control" placeholder="Conference venue" name="conference_venue">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <span style="color:red">* <?php echo $error['city'];?></span> 
                                        <input type="text" class="form-control" placeholder="City" name="conference_city">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <span style="color:red">* <?php echo $error['state'];?></span> 
                                        <input type="text" class="form-control" placeholder="State" name="conference_state">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                         <span style="color:red">* <?php echo $error['country'];?></span>
                                        <input type="text" class="form-control" placeholder="Country" name="conference_country">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <span style="color:red">* <?php echo $error['postalcode'];?></span> 
                                        <label>Postal Code</label>
                                        <input type="postalcode" class="form-control" placeholder="Postal Code" name="conference_postalcode">     
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right" name="add_conference">Add Conference</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>
