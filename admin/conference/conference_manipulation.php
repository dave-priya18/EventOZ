<?php
require('../include/connection.php');
$error = array();
$output = array();
$count = 0;
$date = date("d/m/Y");
$error['title'] = $error['desc'] = $error['image'] = $error['start_date'] = 
$error['end_date'] = $error['venue'] = $error['city'] = $error['state'] =
$error['country'] = $error['postalcode'] = "";

$display_title = $display_desc= $display_image =  $display_start_date =
$display_end_date = $display_venue = $display_city = $display_state = 
$display_country = $display_postalcode="";

$var_conference_title =  $var_conference_desc = $var_conference_image  =
$var_conference_start_date = $var_conference_end_date=
$var_conference_landmark = $var_conference_city =$var_conference_state = 
$var_conference_country = $var_conference_postalcode = "";
$field = $data = "";
$set = "";

    $table_name = 'conference_detail';
    $where_field = 'conference_id';

if((!empty($_GET['id'])) && $_GET['action']=="delete"){
    $where_data= $_GET['id'];
    $delete_output = delete_data($table_name,$where_field,$where_data,$_connection);
    if($delete_output == 1){
        header('Location: index.php');
    }
    else{
        ?>
        <script type="text/javascript">alert('Something is wrong. Data is not deleted');</script>
        <?php
    }

}
if((isset($_POST['add_conference']))||(isset($_POST['edit_conference'])) ){
     $where_data= $_GET['id'];
    //About us title Validation

        if(!($_POST['conference_title'])==""){
            if (!(strlen($_POST['conference_title']) < 31)) {
                $count++;
                $error['title'] = "Title should be under 30 characters";
            }
            else{
                    //echo "Title: ".$_POST['conference_title']."<br>";
                    $var_conference_title = $_POST['conference_title'];
              }
        }
        else{
            $count++;
            $error['title'] = "Title is required";
        }


//Description Validation
        if(!($_POST['conference_desc']== "")){
            if(!(strlen($_POST['conference_desc']) < 201 )) {
                $count++;
                $error['desc']  = "Length problem";
            }
            else{
                //echo "Description : ".$_POST['conference_desc']."<br>";
                $var_conference_desc = $_POST['conference_desc'];
            }
        }
        else{
            $count++;
            $error['desc']  = "Address is required";
        }
// Image Validation

        if(!(empty($_FILES['conference_image']['name']))){
          $var_conference_image = $_FILES['conference_image']['name'];
          $target_folder = CONFERENCE_PATH;
          $target_file = $target_folder . basename($_FILES['conference_image']['name']);


// Select file type
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Valid file extensions
          $extensions_arr = array("jpg","jpeg","png","gif");

// Check extension
          if( in_array($imageFileType,$extensions_arr) ){
 // Upload file
              move_uploaded_file($_FILES['conference_image']['tmp_name'],$target_folder.$var_conference_image);
          }
          else{
            $count++;
            $error['image']  = "Please upload image file";
          }
        }
        else{
          $count++;
          $error['image']  = "Image is required";
        }

//Start Date Validation
        if(!($_POST['conference_start_date'] == "")) {
            if(($_POST['conference_start_date'] <= $date )){
                $count++;
                $error['start_date']  = "Date is invalid";
            }

            else{
                 $var_conference_start_date =$_POST['conference_start_date'];
            }
        }
        else{
            $count++;
            $error['start_date']  = "Can not be empty";
        }

//End Date Validation
        if(!($_POST['conference_end_date'] == "")) {
            ($_POST['conference_end_date'] > $_POST['conference_start_date']);
            if(!($_POST['conference_end_date'] > $_POST['conference_start_date']) ){
                $count++;
                $error['end_date']  = "Date is invalid";
            }
            else{
                 $var_conference_end_date =$_POST['conference_end_date'];
            }
        }
        else{
            $count++;
            $error['end_date']  = "Can not be empty";
        }

//City Validation

        if(!($_POST['conference_city'])== ""){
            if(!(strlen($_POST['conference_city']) < 31)){
                $count++;
                $error['city']  = "Too Long City Name";
            }
            else{
                //echo "City: ".$_POST['conference_city']."<br>";
                $var_conference_city = $_POST['conference_city'];
            }

        }
        else{
            $count++;
            $error['city']  = "City is Required";
        }

//State Validation

        if(!($_POST['conference_state'])== ""){
            if(!(strlen($_POST['conference_state']) < 31)){
                $count++;
                $error['state']  = "Too Long State Name";
            }
            else{
                //echo "City: ".$_POST['conference_city']."<br>";
                $var_conference_state = $_POST['conference_state'];
            }

        }
        else{
            $count++;
            $error['state']  = "City is Required";
        }



//Country Validation
        if(!($_POST['conference_country'])==""){
            //echo "Country: ".$_POST['conference_country']."<br>";
            $var_conference_country = $_POST['conference_country'];
        }
        else{
            $count++;
            $error['country']  = "Country is Required";
        }

//Postal Code Validation

        if(!(($_POST['conference_postalcode']) == "")){
            if(!(strlen($_POST['conference_postalcode']) == 6 )) {
                $count++;
                $error['postalcode']  = "Must be 6 digits";
            }
            else{
                if(!(preg_match("/^[1-9][0-9]{5}/", $_POST['conference_postalcode']))){
                    $error['postalcode'] = "format Problem";
                    $count++;
                }
                else{
                    //echo "Postal-Code: ".$_POST['conference_postalcode']."<br>";
                    $var_conference_postalcode = $_POST['conference_postalcode'];
                }
            }
        }
        else{
            $count++;
            $error['postalcode'] = "Postal code is Required";
        }
if(isset($_POST['edit_conference'])){


$x=1;
 $where_data= $_GET['id'];

foreach($_POST as $key=>$value){
            if($key != "edit_conference"){
                $set .= "{$key} = \"{$value}\"";
                if($x < count($_POST)-1) {
                    $set .= ',';
                }
                $x++;
            }
           
        }
    

     $update_output =  update_data($table_name,$set,$where_field,$where_data,$_connection);

        if($update_output == 1){
            header('location: index.php');
        }
        else{
            ?>
            <script type="text/javascript">alert('Error in updating');</script>
            <?php
        } 
}


    if(isset($_POST['add_conference'])){
        
$x=1;


foreach($_POST as $key=>$value){
            if($key != "add_conference"){
                $field .= $key;
                $data .= "'".$value."'";
                if($x < count($_POST)-1) {
                    $field .= ',';
                    $data .= ',';
                }
                $x++;
            }
           
        }

      $output_insert = insert_data($table_name,$field,$data,$_connection);
       if($output_insert == 1){
        header('Location: index.php');
       }
       else{
        ?>
        <script type="text/javascript">alert('Something is Wrong!');</script>
        <?php
       }
    

    }


}

if((!empty($_GET['id'])) && $_GET['action']=="edit"){
    $where_data= $_GET['id'];
	
    $output =  get_data($table_name,$where_field,$where_data,$_connection);
    if($output['success'] == 1){
        $display_title= $output['output']['conference_title'];
        $display_desc= $output['output']['conference_desc'];
        $display_image= $output['output']['conference_image'];
        $display_start_date= $output['output']['conference_start_date'];
        $display_end_date= $output['output']['conference_end_date'];
        $display_venue= $output['output']['conference_landmark'];
        $display_city= $output['output']['conference_city'];
        $display_state= $output['output']['conference_state'];
        $display_country= $output['output']['conference_country'];
        $display_postalcode= $output['output']['conference_postalcode'];

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
                        <h4 class="title">Conference Detail</h4>
                    </div>
                    <div class="content">
                        <form method="POST" enctype='multipart/form-data'>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <span style="color:red">* <?php echo $error['title'];?></span>
                                        <input type="text" class="form-control" placeholder="Title of Conference" name="conference_title" maxlength="30"
                                        <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_title; ?>"
                                        <?php }

                                        ?>
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <span style="color:red">* <?php echo $error['desc'];?></span>
                                        <textarea class="form-control" placeholder="Description of About Us" rows="5" cols="20" name="conference_desc" maxlength="20">
                                         <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){
                                            echo $display_desc;
                                        }
                                        ?>
                                        </textarea>      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <span class="error" style="color:red"> * <?php echo $error['image']; ?></span>
                                        <input type="file" name="conference_image" class="form-control"
                                         <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_image; ?>" >
                                            <img src="<?php echo CONFERENCE_PATH; ?><?php echo $display_image;?>" height="100" width="100">
                                        <?php }

                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <span style="color:red">* <?php echo $error['start_date'];?></span> 
                                        <input type="Date" class="form-control" placeholder="Start Date" name="conference_start_date"  <?php
                                        if((!empty($_GET['id'])) && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_start_date; ?>"
                                        <?php }

                                        ?>>   
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <span style="color:red">* <?php echo $error['end_date'];?></span>
                                        <input type="Date" class="form-control" placeholder="End Date" name="conference_end_date"  <?php
                                        if((!empty($_GET['id']) && $_GET['action']=="edit")){
                                            ?>
                                            value = "<?php echo $display_end_date; ?>"
                                        <?php }

                                        ?>>      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Conference Venue</label>
                                         <span style="color:red">* <?php echo $error['venue'];?></span> 
                                        <input type="text" class="form-control" placeholder="Conference venue" name="conference_landmark" maxlength="100"
                                         <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_venue; ?>"
                                        <?php }

                                        ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <span style="color:red">* <?php echo $error['city'];?></span> 
                                        <input type="text" class="form-control" placeholder="City" maxlength="30" name="conference_city"
                                         <?php
                                        if((!empty($_GET['id'])) && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_city; ?>"
                                        <?php }

                                        ?>>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <span style="color:red">* <?php echo $error['state'];?></span> 
                                        <input type="text" class="form-control" placeholder="State" maxlength="30" name="conference_state"
                                         <?php
                                        if((!empty($_GET['id'])) && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_state; ?>"
                                        <?php }

                                        ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                         <span style="color:red">* <?php echo $error['country'];?></span>
                                        <input type="text" class="form-control" placeholder="Country" maxlength="30" name="conference_country"
                                         <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_country; ?>"
                                        <?php }

                                        ?>>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <span style="color:red">* <?php echo $error['postalcode'];?></span> 
                                        <label>Postal Code</label>
                                        <input type="postalcode" class="form-control" maxlength="6" placeholder="Postal Code" name="conference_postalcode"
                                         <?php
                                        if((!empty($_GET['id']))  && $_GET['action']=="edit"){
                                            ?>
                                            value = "<?php echo $display_postalcode; ?>"
                                        <?php }

                                        ?>>     
                                    </div>
                                </div>
                            </div>
                            <?php
                             if((!empty($_GET['id']))  && $_GET['action']=="edit"){ ?>
                            <button type="submit" class="btn btn-info btn-fill pull-right" name="edit_conference">Edit Conference</button>
                            <?php
                        } else {
                            ?>
                            <button type="submit" class="btn btn-info btn-fill pull-right" name="add_conference">Add Conference</button>

                    <?php    } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer File -->
<?php include('../layout/footer.php'); ?>


