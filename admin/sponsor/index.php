<?php 
require_once('../include/connection.php');
 require_once('../layout/header.php'); ?>
<?php require_once('../layout/leftsidebar.php'); 

$ob = new query_function();
?>

<?php

    $select_query = "SELECT conference_sponsor_detail.sponsor_id
    ,conference_sponsor_detail.sponsor_companyname,
    conference_sponsor_detail.sponsor_logo,conference_detail.conference_title
    FROM conference_sponsor_detail
    LEFT JOIN conference_detail ON conference_sponsor_detail.conference_id = 
    conference_detail.conference_id and conference_sponsor_detail.admin_id =
    conference_detail.admin_id";


    $result_data = mysqli_query($_connection,$select_query);
    $_increment = 1;
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">All Sponsor</h4>
                        <a class="pull-right" href='sponsor_manipulation.php'> Add Sponsor </a>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Company Name</th>
                                <th>Image</th>
                                <th>Conference </th>
                            </thead>
                            <?php
                                while($rows = mysqli_fetch_assoc($result_data)){ 
                            ?>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php 
                                            echo $_increment ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo $rows['sponsor_companyname']; ?> 
                                    </td>
                                    <td>
                                        <img src="http://localhost/EventOZ/sponsor_image/<?php echo $rows['sponsor_logo'];?>" height="100" width="100"> </td>
                                    <td>
                                        <?php 
                                            echo $rows['conference_title']?>
                                    </td>
                                    <td>
                                        <a href='sponsor_manipulation.php?id=<?php echo $rows['sponsor_id']; ?>&action=edit'>Edit</a>
                                    </td>
                                    <td>
                                        <a href='sponsor_manipulation.php?id=<?php echo $rows['sponsor_id']; ?>&action=delete' onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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

<?php include('../layout/footer.php'); ?>
