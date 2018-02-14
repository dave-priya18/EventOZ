 <?php include('include/connection.php'); ?>
<?php
$_schedule_time_error = $_schedule_title_error = $_schedule_date_error = $_schedule_speaker_error = $_schedule_conference_title_error ="";
$selected_title = "";
$result_conference_title = array();
$count = 0;


        $select_conference_title_query = "SELECT conference_id,conference_title FROM conference_detail WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";

        $result_conference_title = mysqli_query($_connection,$select_conference_title_query);

    
 if(isset($_POST['add_schedule'])){


//Conference - DropDown
        if(!(empty($_POST['_schedule_conference_title']))){
        $var_schedule_conference_title = $_POST['_schedule_conference_title'];
        }
        else{
          $count++;
          $_schedule_conference_title_error = "Must select one";
}


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
         
           
    }
}




?>
<?php //include('layout/header.php'); ?>

<?php //include('layout/leftsidebar.php'); ?>


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
                                        <select name="_schedule_conference_title">
                                        <option value=""> select -</option>
             <?php  while($rows_conference_title =mysqli_fetch_assoc($result_conference_title)){ ?>
                 <option value="<?php echo $rows_conference_title['conference_id']; ?>"><?php echo $rows_conference_title['conference_title']; ?>
                     
                 </option>
            <?php } ?>
                                            
                                        </select>
                                        <span class="error" style="color:red">* <?php echo $_schedule_conference_title_error;?></span> 

                                       
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
                                        <input type="text" class="form-control" placeholder="event name" name="_schedule_title" >
                                        <span class="error" style="color:red">* <?php echo $_schedule_title_error;?> </span>
                                    </div>
                                </div>
                              </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Speaker</label>
                                        <select name="_schedule_speaker">
                                           
                                        <span class="error" style="color:red">* <?php echo $_schedule_speaker_error;?></span>
                                    </div>
                                </div>
                            </div>




                            </div>
                              <button type="submit" class="btn btn-info btn-fill pull-right" name="add_schedule">Add Schedule</button>

                              <button type="submit" class="btn btn-info btn-fill pull-right" name="cancle_profile">Cancle</button>

                            <!-- <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button> -->

              </form>
        </div>
    </div>
</div>

<?php //include('layout/footer.php'); ?>
