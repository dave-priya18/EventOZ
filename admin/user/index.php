<?php 
require_once('../include/session.php');require_once('../include/constant.php');
require_once('../include/function.php');  ?>
<?php require_once('../layout/header.php'); ?>
<?php require_once('../layout/leftsidebar.php'); 
require_once('../include/connection.php');
$ob = new query_function();
$_connection = $ob->__construct();
?>
<?php
                                    
    $select_query = "SELECT * from `user_profile` WHERE admin_id='".$_SESSION['admin_credential']['admin_id']."'";
    $result_data = mysqli_query($_connection,$select_query); 
?>
<div class="content">   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Enrolled User Profile</h4>
                        <a class="pull-right" href='user_manipulation.php'>Add User Profile</a>
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
                                    <td><a href='user_manipulation.php?id=<?php echo $rows['user_userid'];?>&action=edit'>Edit</a></td> 
                                    <td><a href='user_manipulation.php?id=<?php echo $rows['user_userid']; ?>&action=delete' onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
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


<?php include('../layout/footer.php');