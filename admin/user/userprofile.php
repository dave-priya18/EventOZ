<?php
include('include/connection.php'); ?>
<?php $id=""; ?>
<?php
    if(isset($_POST['add_profile'])){
       ob_start();
       header('Location: adduser.php');

    }


   
?>

<?php include('layout/header.php'); ?>
<?php include('layout/leftsidebar.php'); ?>
    <form method="post">
        <div class="content">
                      <button type="submit" class="btn btn-info btn-fill pull-right" name="add_profile">Add User Profile</button>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Enrolled User Profile</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Company Name</th>
                                    	<th>Username</th>
                                    	<th>Email id</th>
                                    	<th>First Name</th>
                                        <th>Last Name</th>
                                    </thead>
                                    <?php
                                    
                                        $select_query = "SELECT * from `user_profile` WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";
                                        $result_data = mysqli_query($_connection,$select_query);
                                        $_increment = 1;
                                        while($rows = mysqli_fetch_assoc($result_data)){
                                    ?>
                                    <tbody>
                                        <tr>
                                        	<td><?php $id=$rows['user_userid']; 
                                            echo $_increment ?></td>
                                        	<td><?php echo $rows['company_name']?></td>
                                        	<td><?php echo $rows['user_username']?></td>
                                        	<td><?php echo $rows['user_email']?></td>
                                        	<td><?php echo $rows['user_fname']?></td>
                                            <td><?php echo $rows['user_lname']?></td>
                                            <?php  
                                        echo "<td><a href='edituser.php?id=" . $rows['user_userid'] . "'>Edit</a></td>"; ?>
                                        <?php  
                                        echo "<td><a href='deleteuser.php?id=" . $rows['user_userid'] . "'>Delete</a></td>"; ?>
                                        
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
           
<?php include('layout/footer.php');