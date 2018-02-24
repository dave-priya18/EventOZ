<?php 
require_once('../include/connection.php');  ?>
<?php require_once('../layout/header.php'); ?>
<?php require_once('../layout/leftsidebar.php'); 
$ob = new query_function();

?>

<!-- Header File -->

<!-- HTML Code -->

<form method="post">
    <div class="content">
    <div class="container-fluid">
<!-- Button: Add Conference -->
        <!-- <label style="color:red";> <?php echo $error; ?> </label> -->
        <a href="conference_manipulation.php"> Add Conference </a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Registered Conference</h4>
                    </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Image</th>
                        </thead>
                        <?php
                        $fetch_conference_query = "SELECT * from `conference_detail` WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";
                        $fetch_conference_data = mysqli_query($_connection,$fetch_conference_query);
                        $_increment = 1;    // Auto Incremented ID
                        while($rows = mysqli_fetch_assoc($fetch_conference_data)){ ?>
                            <tbody>
                            <tr>
                                <!-- Record ID -->
                                <td>    <?php echo $_increment ?></td>
                                <!-- Conference Title -->
                                <td>    <?php echo $rows['conference_title']; ?> </td>
                                <!-- Conference Start Date -->
                                <td>    <?php echo $rows['conference_start_date']?></td>
                                <!-- Conference End Date -->
                                <td>    <?php echo $rows['conference_end_date']?></td>
                                <!-- Conference Poster -->
                                <td>    <img src="http://localhost/EventOZ/conference_image/<?php echo $rows['conference_image'];?>" height="100" width="100"> </td>
                                <td>
                                <!-- Edit and Delete Button -->   
                                <a href="conference_manipulation.php?id=<?php echo$rows['conference_id']; ?>&action=edit">
                                Edit </a>
                                <a href="conference_manipulation.php?id=<?php echo $rows['conference_id']; ?>&action=delete" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                                
                                </td>
                            </tr>
                            </tbody>

                        <?php
                            $_increment++; 
                        } ?>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<!-- Footer File -->
<?php include('../layout/footer.php'); ?>

