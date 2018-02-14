<?php include('include/connection.php'); ?>

<?php
$load_sponsor_id = $_GET['id'];
$adminid = $_SESSION['admin_credential']['admin_id'];
    $_sponsor_companyname_error= $_sponsor_companyname_error = $_sponsor_desc_error = $_sponsor_logo_error = $_sponsor_conference_title_error = "";
    $conference_title_data = array();
    $count =0;
    $error=0;
    $var_sponsor_companyname  =   $var_sponsor_logo = $var_sponsor_desc = $var_conference_title = "";

 $select_query = mysqli_query($_connection,"SELECT * FROM `conference_sponsor_detail` WHERE sponsor_id='".$_GET['id']."'");

//$edit_rows = mysqli_fetch_assoc($select_query);
while($edit_rows = mysqli_fetch_assoc($select_query)){
        $display_sponsor_companyname = $edit_rows['sponsor_companyname'];
         $display_sponsor_desc = $edit_rows['sponsor_companydesc'];

         $display_logo= $edit_rows['sponsor_logo'];
         $display_conference_id = $edit_rows['conference_id'];
        }



 $select_conference_title_query = "SELECT conference_id,conference_title FROM conference_detail WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";

$result_conference_title = mysqli_query($_connection,$select_conference_title_query);

   if(isset($_POST['add_sponsor'])){


//Conference Name Validation
            if(!($_POST['_conference_title'])==""){
                //echo "Conference: ".$_POST['_conference_title']."<br>";
               $var_conference_title = $_POST['_conference_title'];

            }
            else{
                $count++;
                $var_conference_title_error = "var_conference_title is Required";
            }

//Sponsor Company Name Validation


        if(!($_POST['_sponsor_companyname']== "")){
            if(!(strlen($_POST['_sponsor_companyname']) < 31)) {
                $count++;
                $_sponsor_companyname_error = "Length problem";
            }
            else{
                //echo "Address: ".$_POST['_sponsor_companyname']."<br>";
                $var_sponsor_companyname = $_POST['_sponsor_companyname'];
            }
        }
        else{
            $count++;
            $_sponsor_companyname_error = "Address is required";
        }

//sponsor Company Description  Validation

        if(!($_POST['_sponsor_desc']) == ""){
            if(!(strlen($_POST['_sponsor_desc']) <= 100)){
                $count++;
                $_sponsor_desc_error = "Company Description should be less than 100 characters";
            }
        else{
                //echo "Last Name: ".$_POST['_sponsor_desc'] ."<br>";
                $var_sponsor_desc = $_POST['_sponsor_desc'];
            }
        }
        else{
            $count++;
            $_sponsor_desc_error = "Last Name Required";
        }




// Image Validation
 // print_r($_FILES);exit;
        if((!empty($_FILES['_sponsor_logo']['tmp_name']))){
            
          $var_sponsor_logo = $_FILES['_sponsor_logo']['name'];
          $target_folder = SPONSOR_PATH;
          $target_file = $target_folder . basename($_FILES['_sponsor_logo']['name']);

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
              move_uploaded_file($_FILES['_sponsor_logo']['tmp_name'],$target_folder.$var_sponsor_logo);
          }
          else{
            $count++;
            $_sponsor_logo_error = "Please upload image file";
          }
        }
        else{
          $count++;
          $_sponsor_logo_error = "Image is required";
        }

//Insert Query

        if($count>0){
            echo "Invalid Input";
        }
        else{
          // DB Connection and Insert
            $select_query_all = "SELECT sponsor_companyname, conference_id FROM conference_sponsor_detail WHERE sponsor_companyname='".$var_sponsor_companyname."' and conference_id = '".$var_conference_title."'";

            $result_all=mysqli_query($_connection,$select_query_all);
            if($row_all = mysqli_fetch_array($result_all)){
                 echo "<script type='text/javascript'>alert('sponsor is already there!')</script>";
            }
            else{
                echo $update_query = "UPDATE `conference_sponsor_detail`
                    SET `sponsor_companyname`='$var_sponsor_companyname',`sponsor_companydesc`='$var_sponsor_desc',
                   `sponsor_logo`='$var_sponsor_logo',`conference_id`='$var_conference_title',
                  `updated_by`='$adminid'
                    WHERE `sponsor_id` = '$load_sponsor_id'";
                    if (mysqli_query($_connection,$update_query)) {
                      echo "hello";
                        echo "<script type='text/javascript'>alert('Record inserted successfully!')</script>";
                        ob_start();
                        header('Location: sponsor.php');
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
                        <h4 class="title">User Profile</h4>

                    </div>

                    <div class="content">
                        <form method="POST" enctype="multipart/form-data" >

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Conference Title</label>
                                        <select name="_conference_title">
                                           <option value=""> select -</option>
             <?php  while($rows_conference_title =mysqli_fetch_assoc($result_conference_title)){

                if($rows_conference_title['conference_id'] == $edit_rows['conference_id'] ){  ?>

                 <option value="<?php echo $rows_conference_title['conference_id']; ?>" selected="selected"><?php echo $rows_conference_title['conference_title']; ?></option>

            <?php } else { ?>

                 <option value="<?php echo $rows_conference_title['conference_id']; ?>"><?php echo $rows_conference_title['conference_title']; ?></option>

    <?php } } ?>

                                        </select>
                                        <span class="error" style="color:red">* <?php echo $_sponsor_conference_title_error;?></span>


                                    </div>
                                </div>
                            </div>

                               <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control" placeholder="Designation" name="_sponsor_companyname" value="<?php echo $display_sponsor_companyname ?>">
                                        <span class="error" style="color:red">* <?php echo $_sponsor_companyname_error;?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label>About Comapny</label>
                                        <textarea rows="5" class="form-control" placeholder="what they'll talk" name="_sponsor_desc"> <?php echo $display_sponsor_desc ?></textarea>
                                        <span class="error" style="color:red">* <?php echo $_sponsor_desc_error;?></span>
                                    </div>
                                </div>
                            </div>

                           


                                
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                          <label>Image</label>
                                        <input type="file" name="_sponsor_logo" class="form-control">
                                        <img src="<?php SPONSOR_PATH ?><?php echo $display_logo?>" height="100" width="100">
                                        <span class="error" style="color:red">* <?php echo $_sponsor_logo_error;?></span>
                                    </div>
                                </div>
                            </div>




                            </div>
                              <button type="submit" class="btn btn-info btn-fill pull-right" name="add_sponsor">Add sponsor Profile</button>

                              <button type="submit" class="btn btn-info btn-fill pull-right" name="cancle_profile">Cancle</button>

                            <!-- <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button> -->

              </form>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>
