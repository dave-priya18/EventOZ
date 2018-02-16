<?php 
require_once('../include/session.php');
require_once('../include/constant.php');
require_once('../include/function.php');  ?>
<?php require_once('../layout/header.php'); ?>
<?php require_once('../layout/leftsidebar.php'); 
$ob = new query_function();
$_connection = $ob->__construct();
?>

<?php
    $select_query = "SELECT conference_speaker_detail.speaker_id,conference_speaker_detail.speaker_name, conference_speaker_detail.speaker_designation,conference_speaker_detail.speaker_image, conference_detail.conference_title FROM conference_speaker_detail LEFT JOIN conference_detail ON conference_speaker_detail.conference_id = conference_detail.conference_id and conference_speaker_detail.admin_id = conference_detail.admin_id";

    $result_data = mysqli_query($_connection,$select_query);
    $_increment = 1;
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">All Speaker</h4>
                        <a href="speaker_manipulation.php" class="pull=right"> Add Speaker </a>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Image</th>
                                <th>Conference </th>
                            </thead>
                            <?php
                                while($rows = mysqli_fetch_assoc($result_data)){ ?>
                            <tbody>
                            <tr>
                                <td><?php
                                    echo $_increment 
                                ?></td>
                                <td><?php 
                                    echo $rows['speaker_name']; 
                                ?> </td>
                                <td><?php 
                                    echo $rows['speaker_designation']
                                ?></td>
                                <td>
                                    <img src="http://localhost/EventOZ/speaker_image/<?php echo $rows['speaker_image'];?>" height="100" width="100"> 
                                </td>
                                <td><?php 
                                    echo $rows['conference_title']?>
                                </td>         
                                <td>
                                    <a href='speaker_manipulation.php?id=<?php echo $rows['speaker_id']; ?>&action=edit'>Edit</a>
                                </td>
                                <td>
                                    <a href='speaker_manipulation.php?id=<?php echo $rows['speaker_id']; ?>&action=delete'>Delete</a>
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
