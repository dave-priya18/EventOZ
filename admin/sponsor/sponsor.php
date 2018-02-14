<?php
include('include/connection.php'); ?>

<?php
    if(isset($_POST['add_sponsor'])){
       ob_start();
       header('Location: addsponsor.php');

    }

?>

<?php include('layout/header.php'); ?>
<?php include('layout/leftsidebar.php'); ?>
    <form method="post">
        <div class="content">
                      <button type="submit" class="btn btn-info btn-fill pull-right" name="add_sponsor">Add
                      Sponsor</button>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">All Sponsor</h4>
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

  $select_query = "SELECT conference_sponsor_detail.sponsor_id,conference_sponsor_detail.sponsor_companyname,
 conference_sponsor_detail.sponsor_logo,conference_detail.conference_title
FROM conference_sponsor_detail
LEFT JOIN conference_detail ON conference_sponsor_detail.conference_id = conference_detail.conference_id and conference_sponsor_detail.admin_id = conference_detail.admin_id";


                                        $result_data = mysqli_query($_connection,$select_query);
                                        $_increment = 1;

                                        while($rows = mysqli_fetch_assoc($result_data)){ ?>
                                    <tbody>
                                        <tr>
                                        	<td><?php
                                            echo $_increment ?></td>
                                          <td><?php echo $rows['sponsor_companyname']; ?> </td>


                                             <td>
                                            <img src="../sponsor/<?php echo $rows['sponsor_logo'];?>" height="100" width="100"> </td>
                                            <td><?php echo $rows['conference_title']?></td>

                                            <td>
                                            <?php

                                        echo "<a href='editsponsor.php?id=" . $rows['sponsor_id'] . "'>Edit</a>"; ?>
                                        <?php
                                        echo "<td><a href='deletesponsor.php?id=" . $rows['sponsor_id'] . "'>Delete</a></td>"; ?>



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
