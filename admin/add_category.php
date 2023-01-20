<?php

include_once('inc/header.php');


$name = $status = $result = '';
$name_err = $status_err = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if($_POST['name'] != ''){
        $name = $db->verify($_POST['name']);
    }else{
        $name_err = "Category Name Field Is Required";
    }

    if($_POST['status'] != ''){
        $status = $db->verify($_POST['status']);
    }else{
        $status_err = "Status Field Is Required";
    }

    $slug = $hp->makeslug($name);


    if($name_err == null && $status_err == null){

      $sql = "INSERT INTO categories (name,status,slug) VALUES ('$name','$status','$slug')";
      $insert = $db->insert($sql);

      if ($insert) {
        $result = 'Category Insert Successfully';
        ?>
        <script type="text/javascript">
          setTimeout(function(){
            window.location.href = 'all_category.php';
          },2000);
        </script>

        <?php
          }else{
        $result = 'Category Insert Failed. Error: ' .$insert . '<br>' . $db->error;
      }

    }

}




 ?>
  <!-- ======= Sidebar ======= -->
<?php include_once('inc/sidebar.php') ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Categories</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Create Category</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->



    <section class="section">
      <div 
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Create Category</h5>

              <h6 class="card-title"><?php echo $result ?></h6>

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" method="POST" novalidate>
                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">Category name</label>
                  <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="Type Category Name" required>
                  <div class="invalid-feedback">
                    Category Name Required
                  </div>
                  <span class="text-danger"><?php echo $name_err ?></span>
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
                  <button class="btn btn-primary" type="submit">Submit form</button>
                </div>
              </form><!-- End Custom Styled Validation -->

            </div>
          </div>

        </div>
      </div>
    </section>


  </main><!-- End #main -->
<?php include_once('inc/footer.php') ?>