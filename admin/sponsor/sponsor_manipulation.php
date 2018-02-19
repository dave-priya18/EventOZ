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
    $error['conference_id'] = $error['sponsor_companyname'] = $error['sponsor_companydesc'] = $error['sponsor_logo'] = "";
    $output = array();
    $count = 0;
    $var_conference_title = $var_sponsor_companyname =  $var_sponsor_companydesc = $var_sponsor_logo = "";
    $field = $data = "";
    $set = "";
    $display_companyname = $display_companydesc = $display_logo = $display_conferenceid = "";
    $table_name = 'conference_sponsor_detail';
    $where_field = 'sponsor_id';
//Delete Functionality

if((!empty($_GET['id'])) && $_GET['action']=="delete"){
    $where_data= $_GET['id'];
    $delete_output = $query_object->delete_data($table_name,$where_field,$where_data);
    if($delete_output == 1){ ?>
        <script type="text/javascript"> alert('sponsor Deleted Successfully');</script>
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
if((isset($_POST['add_sponsor']))||(isset($_POST['edit_sponsor'])) ){
//Conference Name Validation
    if(!($_POST['conference_id'])==""){
        //echo "Conference: ".$_POST['_conference_title']."<br>";
        $var_conference_title = mysqli_real_escape_string($_connection,$_POST['conference_id']);
    }
    else{
        $count++;
        $error['conference_id'] = "conference Title is Required";
    }

//Sponsor Company Name Validation
    if(!($_POST['sponsor_companyname']== "")){
        if(!(strlen($_POST['sponsor_companyname']) < 31)) {
            $count++;
            $error['sponsor_companyname'] = "Length problem";
        }
        else{
            //echo "Address: ".$_POST['_sponsor_companyname']."<br>";
            $var_sponsor_companyname = mysqli_real_escape_string($_connection,$_POST['sponsor_companyname']);
        }
    }
    else{
        $count++;
        $error['sponsor_companyname'] = "Address is required";
    }
//sponsor Company Description  Validation
    if(!($_POST['sponsor_companydesc']) == ""){
        if(!(strlen($_POST['sponsor_companydesc']) <= 100)){
            $count++;
            $error['sponsor_companydesc'] = "Company Description should be less than 100 characters";
        }
        else{
            //echo "Last Name: ".$_POST['_sponsor_desc'] ."<br>";
            $var_sponsor_desc = mysqli_real_escape_string($_connection,$_POST['sponsor_companydesc']);
        }
    }
    else{
        $count++;
        $error['sponsor_companyname'] = "Last Name Required";
    }
// Image Validation
// print_r($_FILES);exit;
    if((!empty($_FILES['sponsor_logo']['tmp_name']))){
        $var_sponsor_logo = mysqli_real_escape_string($_connection,$_FILES['sponsor_logo']['name']);
        $target_folder = SPONSOR_PATH;
        $target_file = $target_folder . basename($_FILES['sponsor_logo']['name']);
// Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
// Check extension
        if(in_array($imageFileType,$extensions_arr) ){
// Upload file
            move_uploaded_file($_FILES['sponsor_logo']['tmp_name'],$target_folder.$var_sponsor_logo);
        }
        else{
            $count++;
            $error['sponsor_logo'] = "Please upload image file";
        }
    }
    else{
        $count++;
        $error['sponsor_logo'] = "Image is required";
    }
    if($count > 0){
        ?>
        <script type="text/javascript">alert('Invalid Input');</script>
        <?php
    }
    else{
//Edit sponsor Profile
    if(isset($_POST['edit_sponsor'])){
    $where_data= $_GET['id'];
        $_POST['sponsor_logo'] = $_FILES['sponsor_logo']['name'];
        unset($_POST['edit_sponsor']);
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
            header('location: sponsor_manipulation.php');
            exit;
        } 
    }
//Add sponsor Profile
    
    if(isset($_POST['add_sponsor'])){        
      
        $_POST['sponsor_logo'] = $_FILES['sponsor_logo']['name'];
        unset($_POST['add_sponsor']);
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
        header('location: sponsor_manipulation.php');
        exit;
    }
    
}
}
// Array ( [id] => 10 [action] => edit ) 

    if((!empty($_GET['id'])) && $_GET['action']=="edit"){
        $where_data= $_GET['id'];
        $output =   $query_object->get_data($table_name,$where_field,$where_data,$_connection);
        if($output['success'] == 1){
            $display_companyname = $output['output']['sponsor_companyname'];
            $display_comapnydesc = $output['output']['sponsor_companydesc'];
            $display_logo= $output['output']['sponsor_logo'];
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
                        <h4 class="title">Sponsor</h4>
                    </div>
                    <div class="content">
                        <form method="POST" enctype="multipart/form-data" >
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <span class="error" style="color:red">* <?php echo $error['sponsor_companyname'];?></span>
                                        <input type="text" class="form-control" placeholder="Designation" name="sponsor_companyname" value="<?php echo $display_companyname; ?>">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About Comapny</label>
                                        <span class="error" style="color:red">* <?php echo $error['sponsor_companydesc'];?></span>
                                        <textarea rows="5" class="form-control" placeholder="what they'll talk" name="sponsor_companydesc"> <?php echo $display_companydesc; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <span class="error" style="color:red">* <?php echo $error['sponsor_logo'];?></span>
                                        <input type="file" name="sponsor_logo" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php
                                            if((!empty($_GET['id']))  && $_GET['action']=="edit"){ ?>
                                                <button type="submit" class="btn btn-info btn-fill pull-right" name="edit_sponsor">Edit Sponsor</button>
                                        <?php
                                            } else {
                                        ?>
                                                <button type="submit" class="btn btn-info btn-fill pull-right" name="add_sponsor">Add Sponsor</button>
                                        <?php    } 
                                        ?>
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


