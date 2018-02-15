<?php include('../layout/header.php'); ?>

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
                        <form method="POST" enctype="multipart/form-data" >
                
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Conference Title</label>
                                        <select name="_conference_title">
                                            <option value=""> select -</option>
             <?php  while($rows_conference_title =mysqli_fetch_assoc($result_conference_title)){ ?>
                 <option value="<?php echo $rows_conference_title['conference_id']; ?>"><?php echo $rows_conference_title['conference_title']; ?></option>
            <?php } ?>
                                            
                                        </select>
                                        <span class="error" style="color:red">* <?php echo $_speaker_conference_title_error;?></span> 

                                       
                                    </div>
                                </div>
                            </div>
                        
                               <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Topic Brief</label>
                                        <textarea rows="5" class="form-control" placeholder="what they'll talk" name="_speaker_speaking"> </textarea>
                                        <span class="error" style="color:red">* <?php echo $_speaker_speaking_error;?></span> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="First Name" name="_speaker_name">
                                        <span class="error" style="color:red">* <?php echo $_speaker_name_error;?></span> 
                                    </div>
                                </div>

                                 

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" placeholder="Designation" name="_speaker_designation">
                                        <span class="error" style="color:red">* <?php echo $_speaker_designation_error;?></span> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="_speaker_image" class="form-control">
                                        <span class="error" style="color:red">* <?php echo $_speaker_image_error;?></span>
                                    </div>
                                </div>
                            </div>

                  

                           
                            </div>
                              <button type="submit" class="btn btn-info btn-fill pull-right" name="add_speaker">Add Speaker Profile</button>

                              <button type="submit" class="btn btn-info btn-fill pull-right" name="cancle_profile">Cancle</button>

                            <!-- <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button> -->

              </form>            
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?> 