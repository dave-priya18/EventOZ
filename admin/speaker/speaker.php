<?php
include('include/connection.php'); ?>
<?php $id="";
$var = "true";

?>
<?php
    if(isset($_POST['add_speaker'])){
       ob_start();
       header('Location: addspeaker.php');

    }

?>

<?php include('layout/header.php'); ?>
<?php include('layout/leftsidebar.php'); ?>
    <form method="post">
        <div class="content">
                      <button type="submit" class="btn btn-info btn-fill pull-right" name="add_speaker">Add 
                      Speaker</button>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">All Speaker</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Name</th>
                                        <th>Designation</th>
                                        <th>Image</th>
                                    	<th>Conference </th>
                                    </thead>
                                    <?php

 $select_query = "SELECT conference_speaker_detail.speaker_id,conference_speaker_detail.speaker_name, conference_speaker_detail.speaker_designation,conference_speaker_detail.speaker_image, conference_detail.conference_title
FROM conference_speaker_detail
LEFT JOIN conference_detail ON conference_speaker_detail.conference_id = conference_detail.conference_id and conference_speaker_detail.admin_id = conference_detail.admin_id";

                                        $result_data = mysqli_query($_connection,$select_query);
                                        $_increment = 1;

                                        while($rows = mysqli_fetch_assoc($result_data)){ ?>
                                    <tbody>
                                        <tr>
                                        	<td><?php
                                            echo $_increment ?></td>
                                          <td><?php echo $rows['speaker_name']; ?> </td>
                                     
                                            <td><?php echo $rows['speaker_designation']?></td>
                                             <td>
                                            <img src="<?php echo SPEAKER_PATH.$rows['speaker_image'];?>" height="100" width="100"> </td>
                                            <td><?php echo $rows['conference_title']?></td>
                                         
                                            <td>
                                            <?php

                                        echo "<a href='editspeaker.php?id=" . $rows['speaker_id'] . "'>Edit</a>"; ?>
                                        <?php
                                        echo "<td><a href='deletespeaker.php?id=" . $rows['speaker_id'] . "'>Delete</a></td>"; ?>

                                
                        
                                        </tr>

                                    </tbody>

                                    <?php
                                    $_increment++; } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include('layout/footer.php'); ?>
