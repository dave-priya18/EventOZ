<?php 
 require_once('../include/connection.php');
     $query_object = new query_function();
 //Delete Functionality
    $table_name = 'user_profile';
    $where_field = 'user_userid';
   

    if(isset($_POST['action']) && $_POST['action']=="ajax_delete"){
     $where_data = $_POST['user_userid'];
    $delete_output = $query_object->delete_data($table_name,$where_field,$where_data,$_connection);
    if($delete_output){
        $delete_json = json_encode($delete_output);
        echo $delete_json;
        exit;
        }
    }

 ?>
<?php require_once('../layout/header.php'); ?>
<?php require_once('../layout/leftsidebar.php'); 
$ob = new query_function();

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
                                	<td><?php echo $rows['company_name'];?></td>
                                	<td><?php echo $rows['user_username'];?></td>
                                	<td><?php echo $rows['user_email'];?></td>
                                	<td><?php echo $rows['user_fname'];?></td>
                                    <td><?php echo $rows['user_lname'];?></td>
                                    <td><a href='user_manipulation.php?id=<?php echo $rows['user_userid'];?>&action=edit'>Edit</a></td>
                                    <td><a href='javascript:void(0);' class="delete_records" data-user_userid="<?php echo $rows['user_userid'];?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
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


<?php include('../layout/footer.php'); ?>
<script type="text/javascript">
    
    jQuery(document).ready(function(){
        jQuery(".delete_records").on('click',function(){
            var user_userid = jQuery(this).data('user_userid');
            var td = jQuery(this);
            jQuery.ajax({
                method: "post",
                url:"<?php echo BASE_URL; ?>user/index.php",
                data:{user_userid:user_userid,action:"ajax_delete"}
            }).done(function(msg){
             if(msg != ""){
                var delete_decode=jQuery.parseJSON(msg);
               td.parent().parent().remove();
             }
             else{
                alert("Something is Wrong!! Try Again");
                window.location.href="<?php echo BASE_URL; ?>user/index.php";
             }
                
                       
             });
   
      


        });
    });

</script>