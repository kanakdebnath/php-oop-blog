<?php

include_once('inc/header.php');


$title = $category = $short_description = $description = $photo =  $status = $result = '';
$title_err = $category_err = $short_description_err = $description_err = $photo_err = $status_err = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


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
      $filename = $_FILES['photo']['name'];
      $temp_name = $_FILES['photo']['tmp_name'];
      $photo = 'uploads/'.$filename;
      move_uploaded_file($temp_name, $photo);
    }else{
      $photo_err = "Photo Field Is Required";
    }
    


    // photo upload 

    $slug = $hp->makeslug($title);


    if($title_err == null && $category_err == null && $short_description_err == null && $description_err == null && $photo_err == null && $status_err == null){



      $sql = "INSERT INTO posts (title,category_id,short_description,description,photo,status,slug) VALUES ('$title','$category','$short_description','$description','$photo','$status','$slug')";
      $insert = $db->insert($sql);

      if ($insert) {
        $result = 'Post Insert Successfully';
        ?>
        <script type="text/javascript">
          setTimeout(function(){
            window.location.href = 'all_post.php';
          },2000);
        </script>

        <?php
          }else{
        $result = 'Post Insert Failed. Error: ' .$insert . '<br>' . $db->error;
      }

    }

}


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
          <li class="breadcrumb-item active">Create Post</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->



    <section class="section">
      <div >
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Create Post</h5>

              <h6 class="card-title"><?php echo $result ?></h6>

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" enctype='multipart/form-data' method="POST" novalidate>
                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">Post Title</label>
                  <input type="text" name="title" class="form-control" id="validationCustom01" placeholder="Type Post title" required>
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
                        <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php }} ?>
                  </select>
                  <div class="invalid-feedback">
                    Please select Status.
                  </div>
                  <span class="text-danger"><?php echo $category_err ?></span>
                </div>


                <div class="col-md-12">
                  <label for="validationCustom05" class="form-label">Short Description</label>
                  <textarea class="form-control" required id="validationCustom05" name="short_description"></textarea>
                  <div class="invalid-feedback">
                    Short Description Required
                  </div>
                  <span class="text-danger"><?php echo $short_description_err ?></span>
                </div>


                <div class="col-md-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" required id="description" name="description"></textarea>
                  <div class="invalid-feedback">
                    Description Required
                  </div>
                  <span class="text-danger"><?php echo $description_err ?></span>
                </div>



                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Post Photo</label>
                  <input type="file" name="photo" class="form-control" id="validationCustom02"  required>
                  <div class="invalid-feedback">
                    Post Photo Required
                  </div>
                  <span class="text-danger"><?php echo $photo_err ?></span>
                </div>


                <div class="col-md-6">
                  <label for="validationCustom04" class="form-label">Status</label>
                  <select class="form-select" name="status" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="Active">Active</option>
                    <option value="InActive">InActive</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select Status.
                  </div>
                  <span class="text-danger"><?php echo $status_err ?></span>
                </div>
                
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Create</button>
                </div>
              </form><!-- End Custom Styled Validation -->

            </div>
          </div>

        </div>
      </div>
    </section>


  </main><!-- End #main -->
<?php include_once('inc/footer.php') ?>