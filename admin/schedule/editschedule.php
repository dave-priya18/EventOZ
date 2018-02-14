 <?php include('include/connection.php'); ?>
<?php

$id= $_GET['id'];
$_schedule_time_error = $_schedule_title_error = $_schedule_date_error = $_schedule_speaker_error ="";
$selected_title = "";
$result_schedule_title = array();
$count = 0;
$select_query = mysqli_query($_connection,"SELECT * FROM `conference_schedule_detail` WHERE schedule_id='".$id."'");

//$edit_rows = mysqli_fetch_assoc($select_query);
while($edit_rows = mysqli_fetch_assoc($select_query)){
        $display_date = $edit_rows['schedule_date'];
         $display_time = $edit_rows['schedule_time'];
         $display_title = $edit_rows['schedule_title'];
         $display_speakerid = $edit_rows['speaker_id'];
        }

//get conference_title in textbox query



$select_conference_title = "SELECT conference_detail.conference_title,conference_detail.conference_start_date, conference_detail.conference_end_date FROM conference_detail LEFT JOIN conference_schedule_detail ON conference_detail.conference_id = conference_schedule_detail.conference_id and conference_schedule_detail.schedule_id='".$id."' ";



$result_conference_title = mysqli_query($_connection,$select_conference_title);
$rows_conference_title = mysqli_fetch_assoc($result_conference_title);
$selected_title = $rows_conference_title['conference_title'];
$selected_start_date = $rows_conference_title['conference_start_date'];
$selected_end_date = $rows_conference_title['conference_end_date'];

// $selected_start_date
// $dat= date('Y-m-d',strtotime()); 
// echo $dat;
// exit;

$begin = new DateTime($selected_start_date);
$end = new DateTime($selected_end_date);

$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);





$select_schedule_title_query = "SELECT speaker_id,speaker_name FROM conference_speaker_detail WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";

$result_schedule_title = mysqli_query($_connection,$select_schedule_title_query);

    
 if(isset($_POST['edit_schedule'])){


if(!($_POST['_schedule_time'])==""){
            //Time Format: Example(08:30) && check AM/PM
            if (!(preg_match("/([012]|[0-9]):([0-5][0-9])/",$_POST['_schedule_time'])) ) {
                $count++;
                $_schedule_time_error = "Time formation is wrong";
            }
            else{
                $var_schedule_time = $_POST['_schedule_time'];
                
            }
          }
          else{
            $count++;
            $_schedule_time_error = "Time Field is empty";
          }

//Date - DropDown
        if(!(empty($_POST['_schedule_date']))){
        $var_schedule_date = $_POST['_schedule_date'];
        }
        else{
          $count++;
          $_schedule_date_error = "Must select one";
        }


//Event Name Validation
        if(!($_POST['_schedule_title']) == ""){
            if(!(strlen($_POST['_schedule_title']) <= 50)){
                $count++;
                $_schedule_title_error ="Title should be less than 50 characters";
            }
            else{
                //echo "First Name: ". $_POST['_schedule_title'] . "<br>";
                $var_schedule_title = $_POST['_schedule_title'];
            }
        }
        else{
            $count++;
            $_schedule_title_erroror = "First Name Required";
        }

//Speaker - DropDown
        if(!(empty($_POST['_schedule_speaker']))){
        $var_schedule_speaker = $_POST['_schedule_speaker'];
        }
        else{
          $count++;
          $_schedule_speaker_error = "Must select one";
        }
//Insert Query

        if($count>0){
            echo "Invalid Input";
        }
        else{
         
           // DB Connection and Insert
                    echo $update_query = "UPDATE `conference_schedule_detail`
                    SET `schedule_time`='$var_schedule_time',`schedule_date`='$var_schedule_date',
                    `schedule_title`='$var_schedule_title',`speaker_id`='$var_schedule_speaker',
                  `updated_by`='$adminid'
                    WHERE `schedule_id` = '$id' ";
                    if (mysqli_query($_connection,$update_query)) {

                        echo "<script type='text/javascript'>alert('Record inserted successfully!')</script>";
                        ob_start();
                        header('Location: schedule.php');
                    }
                    else {
                        $erroror= mysqli_erroror($_connection);
                         echo "<script type='text/javascript'>alert('$erroror!')</script>";
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
                                        <input type="text" class="form-control" disabled value="<?php echo $selected_title; ?> " name="_schedule_conference_title">
                                    </div>
                                  </div>
                                </div>

                               <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input type="Time" class="form-control" name="_schedule_time" value="<?php echo $display_time ?>" >
                                        <span class="error" style="color:red">* <?php echo $_schedule_time_error;?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label> Date </label>
                                       <select name="_schedule_date">
                                        <?php foreach($daterange as $date){ ?>


                                             <option value="<?php echo $date->format("Y-m-d"); ?>"><?php echo $date->format("Y-m-d"); ?></option>
                    
                                        <?php } ?>

                                        </select>
                                        <span class="error" style="color:red">* <?php echo $_schedule_date_error;?></span>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Event Title</label>
                                        <input type="text" class="form-control" placeholder="event name" name="_schedule_title" value="<?php echo $display_title ?>">
                                        <span class="error" style="color:red">* <?php echo $_schedule_title_error;?></span>
                                    </div>
                                </div>
                              </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Speaker</label>
                                        <select name="_schedule_speaker">
                                             <option value=""> select -</option>
             <?php  while($rows_schedule_title =mysqli_fetch_assoc($result_schedule_title)){

                if($rows_schedule_title['speaker_id'] == $edit_rows['speaker_id'] ){  ?>

                 <option value="<?php echo $rows_schedule_title['speaker_id']; ?>" selected="selected"><?php echo $rows_schedule_title['speaker_name']; ?></option>

            <?php } else { ?>

                 <option value="<?php echo $rows_schedule_title['speaker_id']; ?>"><?php echo $rows_schedule_title['speaker_name']; ?></option>

    <?php } } ?>

                                        </select> 
                                        <span class="errororor" style="color:red">* <?php echo $_schedule_speaker_error;?></span>
                                    </div>
                                </div>
                            </div>




                            </div>
                              <button type="submit" class="btn btn-info btn-fill pull-right" name="edit_schedule">Edit Schedule</button>

                              <button type="submit" class="btn btn-info btn-fill pull-right" name="cancle_profile">Cancle</button>

                            <!-- <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button> -->

              </form>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>
