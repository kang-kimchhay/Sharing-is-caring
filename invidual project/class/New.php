<?php
include './class/Database.php';
class News extends Database{

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
</head>
<body>
<?php
    //call class news
    // $database= new Database();
    $newObject = new News(); 
    
    // //submit action
    if (isset($_POST['submit'])) { 
        $title = trim($_POST['title']);
        $detail = trim($_POST['detail']);
        $image = $_FILES['image'];
        $category_code = trim($_POST['category_code']);
        $user_code= trim($_POST['user_code']);
        //for store image
        if ($image['size'] > 0) {
            $targetDir = './uploads/';
            $fileName = $image['name'];
            $target_file = $targetDir .time(). '_' . $fileName;
            $file_extension = pathinfo($target_file, 
                                    PATHINFO_EXTENSION);

            $allowExtensions = array('jpg','JPG', 'jpeg','JPG','PNG', 'png', 'gif', 'bmp');
            if (in_array($file_extension, $allowExtensions)) {
                if (move_uploaded_file($image['tmp_name'], $target_file)) {
                    $image = $target_file;
                    echo 'File has been uploaded!';
                } else {
                    echo 'Error while uploading...!';
                }
            } else {
                echo 'File is not an image!';
            }
            
        }
        $value=[$title,$detail,$image,$category_code,$user_code];
        $fill=("title,detail,image,category_code,user_code");
        // for execute insert
        $result = $newObject->insert('news',$value,$fill);
        if ($result) {
            header('Location: index.php');
        } else {
            header('Location: index.php');
        }
    }
    ?>
        <div class="container">
            <div class="card" style="margin-top: 20px;">
            <div class="card-header">
                <h3>Add News</h3>
            </div>
            <div class="card-body">
            <form action="<?=$_SERVER['PHP_SELF']?>"  method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label for="">Detail</label>
                            <textarea name="detail" class="form-control" cols="30" rows="5"></textarea>
                           
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-md-6">
                        <label for="">Category</label>
                        <!-- Get data from table category -->
                        <select name="category_code" class="form-control">
                            <?php
                            if ($newObject->getAll('categories')) {
                                foreach($newObject->getAll('categories') as $cat) {
                                    echo '<option value="'. $cat['category_code'] .'">'. $cat['name'] .'</option>';
                                }
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-md-6">
                        <label for="">Post_By</label>
                        <!-- Get data from table user -->
                        <select name="user_code" class="form-control">
                            <?php
                            if ($newObject->getAll('users')) {
                                foreach($newObject->getAll('users') as $us) {
                                    echo '<option value="'. $us['user_code'] .'">'. $us['name'] .'</option>';
                                }
                            }
                            ?>
                        </select>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary px-4 py-2" style="margin-top: 10px; float:right;">Submit</button>     
            </form>
            </div>
            </div>
            <div class="card" style="margin-top: 20px;">
            <div class="card-header">
            <h3>ALl NEWS</h3>
            </div>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                        <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Detail</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Post_By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //loop data to table
                    foreach($newObject->getAllTable() as $i=>$list) {
                        echo '<tr>';
                        echo '<td>'. ++$i .'</td>';
                        echo '<td>'. $list['title'] .'</td>';
                        echo '<td>'. $list['detail'] .'</td>';
                        echo '<td style="text-align:center;"><img src="'. trim($list['image'], './') .'" width="40px"></td>';  
                        echo '<td>'. $list['category_name'] .'</td>';
                        echo '<td>'. $list['post_by'] .'</td>';
                        echo '<td>';
                            echo '<a href="edit.php?id='.$list['id'].'" class="btn btn-primary px-4">Edit</a>';
                            echo '  <a href="delete.php?id='.$list['id'].'"  class="btn btn-danger">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                        ?>
                    </tbody>
            </table>

                
        </div>
    
    </body>
    <script>
        $(document).ready(function() {
        $('#example').DataTable();
    } );
        </script>
    </html>