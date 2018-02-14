<?php include('include/connection.php'); ?>
        <?php
        $id = $_GET['id'] ;
        $delete_schedule_query = "DELETE FROM conference_schedule_detail WHERE schedule_id='".$id."'";
        if(!($result_schedule_query = mysqli_query($_connection,$delete_schedule_query))){
            header('Location: schedule.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
        else{
            header('Location: schedule.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
?>