<!-- Connection File -->
<?php
 require_once('../include/connection.php');
    $query_object = new query_function();
    
?>
<!-- Conference Title coming from conference_detail table -->
<?php
    $select_conference_title_query = "SELECT conference_id,conference_title FROM conference_detail WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";
    $result_conference_title = mysqli_query($_connection,$select_conference_title_query);
?>

<?php
//Variable Declaration 
    $error = array();
    $error['conference_id'] = $error['speaker_name'] = $error['speaker_designation'] = $error['speaker_image'] = $error['speaking_desc'] = "";
    $output = array();
    $count = 0;
    $var_conference_title = $var_speaker_name =  $var_seaker_description = $var_speaker_image = "";
    $field = $data = "";
    $set = "";
    $display_speakername = $display_speakerdesc = $display_image = $display_conferenceid  = $display_speaking = "";
    $table_name = 'conference_speaker_detail';
    $where_field = 'speaker_id';
//Delete Functionality

if((!empty($_GET['id'])) && $_GET['action']=="delete"){
    $where_data= $_GET['id'];
    $delete_output = $query_object->delete_data($table_name,$where_field,$where_data,$_connection);
    if($delete_output == 1){ ?>
        <script type="text/javascript"> alert('speaker Deleted Successfully');</script>
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
if((isset($_POST['add_speaker']))||(isset($_POST['edit_speaker'])) ){

//Conference Name Validation
    if(!($_POST['conference_id'])==""){
        //echo "Conference: ".$_POST['_conference_title']."<br>";
        $var_conference_title = mysqli_real_escape_string($_connection,$_POST['conference_id']);
    }
    else{
        $count++;
        $error['conference_id'] = "conference Title is Required";
    }

//Speaking Validation Validation


        if(!($_POST['speaking_desc']== "")){
            if(!(strlen($_POST['speaking_desc']) < 201 )) {
                $count++;
                $error['speaking_desc'] = "Length problem";
            }
            else{
                //echo "Address: ".$_POST['_speaking_desc']."<br>";
                $var_speaking_desc = mysqli_real_escape_string($_connection,$_POST['speaking_desc']);
            }
        }
        else{
            $count++;
            $error['speaking_desc'] = "Address is required";
        }


//Speaker Name Validation
        if(!($_POST['speaker_name']) == ""){
            if(!(strlen($_POST['speaker_name']) <= 50)){
                $count++;
                $error['speaker_name'] ="First name should be less than 50 characters";
            }
            else{
                //echo "First Name: ". $_POST['_speaker_name'] . "<br>";
                $var_speaker_name = mysqli_real_escape_string($_connection,$_POST['speaker_name']);
            }
        }
        else{
            $count++;
            $error['speaker_name'] = "First Name Required";
        }

//Speaker Designation Validation

        if(!($_POST['speaker_designation']) == ""){
            if(!(strlen($_POST['speaker_designation']) <= 50)){
                $count++;
                $error['speaker_designation'] = "Last name should be less than 50 characters";
            }
        else{
                //echo "Last Name: ".$_POST['_speaker_designation'] ."<br>";
                $var_speaker_designation = mysqli_real_escape_string($_connection,$_POST['speaker_designation']);
            }
        }
        else{
            $count++;
            $error['speaker_designation'] = "Last Name Required";
        }




// Image Validation
 // print_r($_FILES);exit;
        if((!empty($_FILES['speaker_image']['name']))){
          $var_speaker_image = mysqli_real_escape_string($_connection,$_FILES['speaker_image']['name']);
          $target_folder = SPEAKER_PATH;
          $target_file = $target_folder . basename($_FILES['speaker_image']['name']);

// Select file type
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Valid file extensions
          $extensions_arr = array("jpg","jpeg","png","gif");
          //echo "$imageFileType";
          //echo "$extensions_arr";
          //exit;
// Check extension
          if(in_array($imageFileType,$extensions_arr) ){
 // Upload file
              move_uploaded_file($_FILES['speaker_image']['tmp_name'],$target_folder.$var_speaker_image);
          }
          else{
            $count++;
            $error['speaker_image'] = "Please upload image file";
          }
        }
        else{
          $count++;
          $error['speaker_image'] = "Image is required";
        }
    if($count > 0){
        ?>
        <script type="text/javascript">alert('Invalid Input');</script>
        <?php
    }
    else{
//Edit speaker Profile
    if(isset($_POST['edit_speaker'])){
     $where_data= $_GET['id'];
        $_POST['speaker_image'] = $_FILES['speaker_image']['name'];
        unset($_POST['edit_speaker']);
        $set_array = $_POST;
//Update Function Calling
    $update_output =  $query_object->update_data($table_name,$set_array,$where_field,$where_data,$_connection);
        if($update_output == 1){ 
            header('location: index.php');
            exit;
        }
        else{
            ?>
            <script type="text/javascript">alert('Error in updating');</script>
            <?php
            header('location: speaker_manipulation.php');
            exit;
        } 
    }
//Add speaker Profile
    
    if(isset($_POST['add_speaker'])){        
        $_POST['speaker_image'] = $_FILES['speaker_image']['name'];
        unset($_POST['add_speaker']);
        $set_array = $_POST;    
    }
//Insert Function Calling
    echo $output_insert = $query_object->insert_data($table_name,$set_array,$_connection);
    if($output_insert == 1){
        header('Location: index.php');
        exit;
    }
    else{
        ?>
        <script type="text/javascript">alert('Something is Wrong!');</script>
        <?php
        header('location: speaker_manipulation.php');
        exit;
    }
    
}
}
// Array ( [id] => 10 [action] => edit ) 

    if((!empty($_GET['id'])) && $_GET['action']=="edit"){
        $where_data= $_GET['id'];
        $output =   $query_object->get_data($table_name,$where_field,$where_data,$_connection);
        if($output['success'] == 1){
            $display_speakername = $output['output']['speaker_name'];
            $display_speakerdesc = $output['output']['speaker_designation'];
            $display_logo= $output['output']['speaker_image'];
            $display_speaking = $output['output']['speaking_desc'];
            $display_conferenceid = $output['output']['conference_id'];
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
                    <form enctype="multipart/form-data" method="post">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>Conference Title</label>
                                         <span class="error" style="color:red">* <?php echo $error['conference_id'];?></span>
                                        <select name="conference_id">
                                            <option value=""> select -</option>
                                            <?php 
                                                while($rows_conference_title =mysqli_fetch_assoc($result_conference_title)){ 
                                            ?>
                                            <option value="<?php echo $rows_conference_title['conference_id']; ?>"><?php echo $rows_conference_title['conference_title']; ?></option>
                                        <?php }  ?>
                                        </select>
                                        


                                    </div>
                                </div>
                            </div>

                               <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Topic Brief</label>
                                        <textarea rows="5" class="form-control" placeholder="what they'll talk" name="speaking_desc"> <?php echo $display_speaking; ?> </textarea>
                                        <span class="error" style="color:red">* <?php echo $error['speaking_desc'];?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="First Name" name="speaker_name" value="<?php echo $display_speakername; ?>" >
                                        <span class="error" style="color:red">* <?php echo $error['speaker_name'];?></span>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" placeholder="Designation" name="speaker_designation" value="<?php echo $display_speakerdesc; ?>">
                                        <span class="error" style="color:red">* <?php echo $error['speaker_designation'];?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="speaker_image" class="form-control">
                                        <img src="<?php echo SPEAKER_PATH ?><?php echo $display_image;?>" height="100" width="100">
                                        <span class="error" style="color:red">* <?php echo $error['speaker_image'];?></span>
                                    </div>
                                </div>
                            </div>
<div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php
                                            if((!empty($_GET['id']))  && $_GET['action']=="edit"){ ?>
                                                <button type="submit" class="btn btn-info btn-fill pull-right" name="edit_speaker">Edit speaker</button>
                                        <?php
                                            } else {
                                        ?>
                                                <button type="submit" class="btn btn-info btn-fill pull-right" name="add_speaker">Add speaker</button>
                                        <?php    } 
                                        ?>
                                    </div>
                                </div>
                            </div>

              </form>
        </div>
    </div>
</div>

<!-- Footer File -->
<?php include('../layout/footer.php'); ?>


