include('include/connection.php'); ?>
<?php $id="";
$var = "true";

?>
<?php
    if(isset($_POST['add_conference'])){
       ob_start();
       header('Location: addconference.php');

    }

?>

<?php include('layout/header.php'); ?>
<?php include('layout/leftsidebar.php'); ?>
    <form method="post">
        <div class="content">
                      <button type="submit" class="btn btn-info btn-fill pull-right" name="add_conference">Add About Us</button>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Instered About Us</h4>
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

                                        $select_query = "SELECT * from `conference_detail` WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";
                                        $result_data = mysqli_query($_connection,$select_query);
                                        $_increment = 1;

                                        while($rows = mysqli_fetch_assoc($result_data)){ ?>
                                    <tbody>
                                        <tr>
                                        	<td><?php
                                            echo $_increment ?></td>
                                          <td><?php echo $rows['conference_title']; ?> </td>
                                     
                                            <td><?php echo $rows['conference_start_date']?></td>
                                            <td><?php echo $rows['conference_end_date']?></td>
                                          <td>
                                        	<img src="../upload/<?php echo $rows['conference_image'];?>" height="100" width="100"> </td>
                                            <td>
                                            <?php

                                        echo "<a href='editconference.php?id=" . $rows['conference_id'] . "'>Edit</a>"; ?>
                                        <?php
                                        echo "<td><a href='deleteconference.php?id=" . $rows['conference_id'] . "'>Delete</a></td>"; ?>

                                
                        
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
