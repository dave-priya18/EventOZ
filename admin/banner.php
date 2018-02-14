<?php include('include/connection.php'); ?>

<?php
$adminid = $_SESSION['admin_credential']['admin_id'];
    $_banner_slogan_error= $_banner_welcome_error = $_banner_image_error =  "";
    $count =0;
    $error=0;
    $var_banner_slogan = $var_banner_welcome =   $var_banner_image = "";


 $select_query = mysqli_query($_connection,"SELECT * FROM `company_banner` where admin_id = '".$adminid."'");

 // $edit_rows = mysqli_fetch_assoc($select_query);
while($edit_rows = mysqli_fetch_assoc($select_query)){
        $display_company_name = $edit_rows['banner_companyname'];
        $display_welcome = $edit_rows['banner_welcome'];
        $display_slogan = $edit_rows['banner_slogan'];
        $display_image = $edit_rows['banner_image'];
        }


//Welcome Validation Validation

if(isset($_POST['edit_banner'])){
        if(!($_POST['_banner_welcome']== "")){
            if(!(strlen($_POST['_banner_welcome']) < 31 )) {
                $count++;
                $_banner_welcome_error = "Length problem";
            }
            else{
                //echo "Address: ".$_POST['_banner_welcome']."<br>";
                $var_s_speaking = $_POST['_banner_welcome'];
            }
        }
        else{
            $count++;
            $_banner_welcome_error = "Welcome is required";
        }


//Slogan Validation
        if(!($_POST['_banner_slogan']) == ""){
            if(!(strlen($_POST['_banner_slogan']) <= 30)){
                $count++;
                $_banner_slogan_error ="Slogan shoule be of 30 characters";
            }
            else{
                //echo "First Name: ". $_POST['_banner_slogan'] . "<br>";
                $var_banner_slogan = $_POST['_banner_slogan'];
            }
        }
        else{
            $count++;
            $_banner_slogan_error = "Slogan Required";
        }


// Image Validation
 // print_r($_FILES);exit;
        if((!empty($_FILES['_banner_image']['name']))){
          $var_banner_image = $_FILES['_banner_image']['name'];
          $target_folder = BANNER_PATH;
          $target_file = $target_folder . basename($_FILES['_banner_image']['name']);

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
              move_uploaded_file($_FILES['_banner_image']['tmp_name'],$target_folder.$var_banner_image);
          }
          else{
            $count++;
            $_banner_image_error = "Please upload image file";
          }
        }
        else{
          $count++;
          $_banner_image_error = "Image is required";
        }
//Insert Query

        if($count>0){
            echo "Invalid Input";
        }
        else{
           // DB Connection and Insert
                    echo $update_query = "UPDATE `company_banner`
                    SET `banner_welcome`='$var_banner_welcome',`banner_slogan`='$var_banner_slogan',
                    `banner_image`='$var_banner_image',
                  `updated_by`='$adminid'
                    WHERE `banner_id` = '1'";
                    if (mysqli_query($_connection,$update_query)) {
                      echo "hello";
                        echo "<script type='text/javascript'>alert('Record inserted successfully!')</script>";
                        ob_start();
                        header('Location: speaker.php');
                    }
                    else {
                        $error= mysqli_error($_connection);
                         echo "<script type='text/javascript'>alert('$error!')</script>";
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
                                    <label>Company (disabled)</label>
                                    <input type="text" class="form-control" disabled placeholder="EventOZ Company" name="Creative Code Inc.">
                                </div>
                            </div>
                          </div>

                               <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Welcome Line</label>
                                        <textarea rows="5" class="form-control" placeholder="welcome Line"
                                        name="_banner_welcome"> <?php echo $display_welcome; ?> </textarea>
                                        <span class="error" style="color:red">* <?php echo $_banner_welcome_error;?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slogan Line</label>
                                        <input type="text" class="form-control" placeholder="Company Slogan"
                                        name="_banner_slogan" value="<?php echo $display_slogan; ?>" >
                                        <span class="error" style="color:red">* <?php echo $_banner_slogan_error;?></span>
                                    </div>
                                </div>
                              </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banner Image</label>
                                        <input type="file" name="_banner_image" class="form-control">
                                        <img src="<?php echo BANNER_PATH;?><?php echo $display_image;?>" height="100" width="100">
                                        <span class="error" style="color:red">* <?php echo $_banner_image_error;?></span>
                                    </div>
                                </div>
                            </div>




                            </div>
                              <button type="submit" class="btn btn-info btn-fill pull-right" name="edit_banner">Edit Banner</button>

<button type="submit" class="btn btn-info btn-fill pull-right" name="cancle_profile">Cancle</button>
              </form>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>
