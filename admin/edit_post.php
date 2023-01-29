<?php

include_once('inc/header.php');


$title = $category = $short_description = $description = $photo =  $status = $result = '';
$title_err = $category_err = $short_description_err = $description_err = $photo_err = $status_err = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['post_id'];

    if($_POST['title'] != ''){
        $title = $db->verify($_POST['title']);
    }else{
        $title_err = "Post Title Field Is Required";
    }

    if($_POST['category_id'] != ''){
        $category = $db->verify($_POST['category_id']);
    }else{
        $category_err = "Category Field Is Required";
    }

    if($_POST['short_description'] != ''){
        $short_description = $db->verify($_POST['short_description']);
    }else{
        $short_description_err = "Short Description Field Is Required";
    }

    if($_POST['description'] != ''){
        $description = $_POST['description'];
    }else{
        $description_err = "Description Field Is Required";
    }

    if($_POST['status'] != ''){
        $status = $db->verify($_POST['status']);
    }else{
        $status_err = "Status Field Is Required";
    }


    // photo upload 
    if ($_FILES['photo']['name'] != '') {
      if ($_POST['old_photo'] != null) {
        unlink($_POST['old_photo']);
      }
      $filename = $_FILES['photo']['name'];
      $temp_name = $_FILES['photo']['tmp_name'];
      $photo = 'uploads/'.$filename;
      move_uploaded_file($temp_name, $photo);
    }else{
      $photo = $_POST['old_photo'];
    }
    


    // photo upload 

    $slug = $hp->makeslug($title);


    if($title_err == null && $category_err == null && $short_description_err == null && $description_err == null && $status_err == null){



      $sql = "UPDATE posts SET
       title = '$title',
       category_id = '$category',
       short_description = '$short_description',
       description = '$description',
       photo = '$photo',
       status = '$status',
       slug = '$slug',
       updated_at = now()
       WHERE id = '$id'";

      $update = $db->update($sql);

      if ($update) {
        $result = 'Post Update Successfully';
        ?>
        <script type="text/javascript">
          setTimeout(function(){
            window.location.href = 'all_post.php';
          },2000);
        </script>

        <?php
          }else{
        $result = 'Post update Failed. Error: ' .$update . '<br>' . $db->error;
      }

    }

}




// Select Old Data 
if(isset($_GET['id'])){
  $id_post = $_GET['id'];
  
  $sql_post = "SELECT * FROM posts WHERE id = '$id_post'";
  $result_post = $db->select($sql_post);
  $row_post = mysqli_fetch_assoc($result_post);

}
// Select Old Data 



$sql = "SELECT * FROM categories";
$result1 = $db->select($sql);



 ?>
  <!-- ======= Sidebar ======= -->
<?php include_once('inc/sidebar.php') ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Posts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Update Post</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->



    <section class="section">
      <div >
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update Post</h5>

              <h6 class="card-title"><?php echo $result ?></h6>

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" enctype='multipart/form-data' method="POST" novalidate>
                <input type="hidden" name="post_id" value="<?php echo $row_post['id'] ?>">
                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">Post Title</label>
                  <input type="text" name="title" value="<?php echo $row_post['title'] ?>" class="form-control" id="validationCustom01" placeholder="Type Post title" required>
                  <div class="invalid-feedback">
                    Post title Required
                  </div>
                  <span class="text-danger"><?php echo $title_err ?></span>
                </div>
                
                <div class="col-md-6">
                  <label for="validationCustom04" class="form-label">Category</label>
                  <select class="form-select" name="category_id" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <?php 
                    if ($result1){
                      while ($category = mysqli_fetch_assoc($result1)) {?>
                        <option <?php echo $row_post['category_id'] == $category['id']?'selected':'' ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php }} ?>
                  </select>
                  <div class="invalid-feedback">
                    Please select Status.
                  </div>
                  <span class="text-danger"><?php echo $category_err ?></span>
                </div>


                <div class="col-md-12">
                  <label for="validationCustom05" class="form-label">Short Description</label>
                  <textarea class="form-control" required id="validationCustom05" name="short_description"><?php echo $row_post['short_description'] ?></textarea>
                  <div class="invalid-feedback">
                    Short Description Required
                  </div>
                  <span class="text-danger"><?php echo $short_description_err ?></span>
                </div>


                <div class="col-md-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" required id="description" name="description"><?php echo $row_post['description'] ?></textarea>
                  <div class="invalid-feedback">
                    Description Required
                  </div>
                  <span class="text-danger"><?php echo $description_err ?></span>
                </div>



                <div class="col-md-6">
                  <label for="validationCustom002" class="form-label">Old Photo</label>
                  <input type="hidden" name="old_photo" value="<?php echo $row_post['photo'] ?>" >
                  <img width="120" height="80" src="<?php echo $row_post['photo'] ?>">
                </div>


                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Post Photo</label>
                  <input type="file" name="photo" class="form-control" id="validationCustom02">
                </div>


                <div class="col-md-6">
                  <label for="validationCustom04" class="form-label">Status</label>
                  <select class="form-select" name="status" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option 
                    <?php 
                      if ($row_post['status'] == 'Active') {
                        echo 'selected';
                      }else{
                        echo '';
                      }

                     ?>
                     value="Active">Active</option>
                    <option <?php echo $row_post['status'] == 'InActive'?'selected':'' ?> value="InActive">InActive</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select Status.
                  </div>
                  <span class="text-danger"><?php echo $status_err ?></span>
                </div>
                
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Update</button>
                </div>
              </form><!-- End Custom Styled Validation -->

            </div>
          </div>

        </div>
      </div>
    </section>


  </main><!-- End #main -->
<?php include_once('inc/footer.php') ?>