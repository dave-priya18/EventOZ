<?php include('include/connection.php'); ?>
        <?php
        $id = $_GET['id'] ;


        $delete_conference_query = "DELETE FROM conference_detail WHERE conference_id='".$id."'";
        if(!($result_conference_query = mysqli_query($_connection,$delete_conference_query))){
            header('Location: conference.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
        else{
        	$delete_conference_schedule_query = "DELETE FROM conference_schedule_detail WHERE conference_id='".$id."'";
        	if(!($result_conference_schedule_query = mysqli_query($_connection,$delete_conference_schedule_query))){
        		echo "<script type='text/javascript'>alert('No corruspondent schedule is there!')</script>";
        	}
        	else{
        		echo "<script type='text/javascript'>alert('Record of schedule Deleted successfully!')</script>";
        	}
            header('Location: conference.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
?>