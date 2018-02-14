<?php include('include/connection.php'); ?>
        <?php
        $id = $_GET['id'] ;
        $delete_user_query = "DELETE FROM user_profile WHERE user_userid='".$id."'";
        if(!($result_user_query = mysqli_query($_connection,$delete_user_query))){
            header('Location: userprofile.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
        else{
            header('Location: userprofile.php');
            echo "<script type='text/javascript'>alert('Record Deleted successfully!')</script>";
        }
?>