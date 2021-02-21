<?php
// include './class/Category.php';
// include './class/User.php';
// include './class/New.php';
include './class/Database.php';
class News extends Database{

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
</head>
<body>
<?php
// $id = NULL;
// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
// }
$id = $_GET['id']??$_POST['id'];
$newObject = new News();
$postDetail = $newObject->getOne($id);
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $detail = trim($_POST['detail']);
    $category_code = trim($_POST['category_code']);
    $user_code= trim($_POST['user_code']);
    //query for update
    // $row=["title"=>$title,"detail"=>$detail,"user_code"=>$user_code,"category_code"=>$category_code];
    // $update=$newObject->update('news',$row,[$sid]);
   
    $update = $newObject->update($id,$title,$detail,$category_code,$user_code);
    if ($update) {
        header('Location:index.php');
    } else {
        header('Location:edit.php');
    }
}
?>
    <div class="container">
        <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <h3>Edit News</h3>
        </div>
        <div class="card-body">
          <form  action="<?= $_SERVER['PHP_SELF']?>?id=<?=$postDetail['id']?>"  method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Title</label>
                        <input type="text" name="title" value="<?=$postDetail['title']?>" class="form-control" required>
                    </div>
                    </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Detail</label>
                        <textarea name="detail"  cols="30" rows="10"   class="form-control" required><?=$postDetail['detail']?></textarea>
                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label for="">Category</label>
                    <select name="category_code" class="form-control">
                    <?php
                        if ($newObject->getAll('categories')) {
                            foreach($newObject->getAll('categories') as $cat) {
                                if ($postDetail['category_code'] == $cat['category_code']) {
                                    echo '<option selected value="'. $cat['category_code'] .'">'. $cat['name'] .'</option>';
                                } 
                                else {
                                    echo '<option value="'. $cat['category_code'] .'">'. $cat['name'] .'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="col-md-6">
                    <label for="">Post_By</label>
                    <select name="user_code" class="form-control">
                    <?php
                        if ($newObject->getAll('users')) {
                            foreach($newObject->getAll('users') as $us) {
                                if ($postDetail['user_code'] == $us['user_code']) {
                                    echo '<option selected value="'. $us['user_code'] .'">'. $us['name'] .'</option>';
                                } 
                                else {
                                    echo '<option  value="'. $us['user_code'] .'">'. $us['name'] .'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                    </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $postDetail['id']?>"> 
                    <button type="submit" name="submit" class="btn btn-primary px-4 py-2" style="margin-top: 10px; float:right;">Submit</button>     
          </form>
        </div>
        </div>

</body>
</html>