<?php include('include/connection.php'); ?>
        <?php
        $id = $_GET['id'] ;
        $delete_speaker_query = "DELETE FROM conference_speaker_detail WHERE speaker_id='".$id."'";
        if(!($result_speaker_query = mysqli_query($_connection,$delete_speaker_query))){
            header('Location: speaker.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
        else{
            header('Location: speaker.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
?>