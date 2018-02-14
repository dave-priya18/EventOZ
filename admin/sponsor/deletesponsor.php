<?php include('include/connection.php'); ?>
        <?php
        $id = $_GET['id'] ;
        $delete_sponsor_query = "DELETE FROM conference_sponsor_detail WHERE sponsor_id='".$id."'";
        if(!($result_sponsor_query = mysqli_query($_connection,$delete_sponsor_query))){
            header('Location: sponsor.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
        else{
            header('Location: sponsor.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
?>