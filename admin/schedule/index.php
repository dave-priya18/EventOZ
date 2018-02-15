<?php
    if(isset($_GET['add_schedule'])){
       header('Location: schedule_manipulation.php');

    }

?>
<?php
include('../include/connection.php'); ?>


<?php include('../layout/header.php'); ?>
<?php include('../layout/leftsidebar.php'); ?>
    <form >
        <div class="content">
                      <button type="submit" class="btn btn-info btn-fill pull-right" name="add_schedule">Add 
                      Schedule</button>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">All schedule</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Event Time</th>
                                        <th>Conference </th>
                                    </thead>
                                    <?php


 $select_query="SELECT conference_schedule_detail.schedule_date,conference_schedule_detail.schedule_id,conference_schedule_detail.schedule_time, conference_schedule_detail.schedule_time,conference_detail.conference_title FROM conference_schedule_detail LEFT JOIN conference_detail ON conference_schedule_detail.conference_id = conference_detail.conference_id and conference_schedule_detail.admin_id = conference_detail.admin_id";


                                        $result_data = mysqli_query($_connection,$select_query);
                                        $_increment = 1;

                                        while($rows = mysqli_fetch_assoc($result_data)){ 
                                            
                                         ?>
                                    <tbody>
                                        <tr>
                                            <td><?php
                                            echo $_increment ?></td>
                                            <td><?php echo $rows['schedule_date']; ?></td>
                                     
                                            <td><?php echo $rows['schedule_time']; ?></td>
                                            
                                            <td><?php echo $rows['conference_title']?></td>
                                         
                                            <td>
                                            <?php

                                        echo "<a href='schedule_manipulation.php?id=" . $rows['schedule_id'] . "&action=edit'>Edit</a>"; ?>
                                        <?php
                                        echo "<td><a href='schedule_manipulation.php?id=" . $rows['schedule_id'] . "&action=delete'>Delete</a></td>"; ?>

                                
                        
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

<?php include('../layout/footer.php'); ?>
