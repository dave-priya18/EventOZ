
<!-- Connection File -->
<?php require('../include/connection.php'); ?>

<!-- Add Conference File -->



<!-- Header File -->
<?php require('../layout/header.php');  ?>
<!-- Left Side Bar File -->
<?php require('../layout/leftsidebar.php');  ?>

<!-- HTML Code -->

<!-- <form method="POST" action ="conference_manipulation.php"> -->
    <div class="content">
    <div class="container-fluid">
<!-- Button: Add Conference -->
        <!-- <button type="submit" class="btn btn-info btn-fill pull-right" name="add_conference">Add Conference</button> -->
        <a href='conference_manipulation.php'>Edit</a>
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
                               
                                <a name="edit_conference"
                                    href='conference_manipulation.php?id=<?php echo $rows['conference_id']; ?>'>Edit</a>
                                </td>
                                <td>
                                <?php
                                    echo "<a href='conference_manipulation.php?id=" .md5($rows['conference_id']) ."'>Delete</a>"; ?>
                                </td>
                                <!-- <button type="submit" class="btn btn-info  btn-fill pull-right" method="get" name="edit_conference" value="<?php echo $rows['conference_id']; ?>">Edit </button> -->
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
<!-- </form> -->
<!-- Footer File -->
<?php require('../layout/footer.php'); ?>
