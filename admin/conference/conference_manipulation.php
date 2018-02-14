<?php
require('../include/connection.php');
$error = array();
$output = array();
$error['title'] = $error['desc'] = $error['image'] = $error['start_date'] = 
$error['end_date'] = $error['venue'] = $error['city'] = $error['state'] =
$error['country'] = $error['postalcode'] = "";

$display_title = $display_desc= $display_image =  $display_start_date=$display_end_date = $display_venue = $display_city = $display_state = $display_country = $display_postalcode="";

if((!empty($_GET['id'])) && $_GET['action']=="edit"){
	$where_data= $_GET['id'];
	$table_name = 'conference_detail';
    $where_field = 'conference_id';
   $output =  get_data($table_name,$where_field,$where_data,$_connection);
    if($output['success'] == 1){
        $display_id= $output['output']['conference_id'];
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
        header('location: conference.php?msg=error');

    }
    

    

}

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Conference Detail</h4>
                    </div>
                    <div class="content">
                        <form method="POST" action="" enctype='multipart/form-data'>
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
                                        <input type="text" class="form-control" placeholder="Conference venue" name="conference_venue" maxlength="100"
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

                            <button type="submit" class="btn btn-info btn-fill pull-right" name="add_conference">Add Conference</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



