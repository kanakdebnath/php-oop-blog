<?php

include_once('inc/header.php');


$name = $status = $result_data = '';
$name_err = $status_err = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $id = $_POST['id'];

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

      $sql = "UPDATE categories SET
             name = '$name',
             status = '$status',
             slug = '$slug',
             updated_at = now()
             WHERE id = '$id'";

      $update = $db->update($sql);

      if ($update) {
        $result_data = 'Category Update Successfully';
        ?>
        <script type="text/javascript">
          setTimeout(function(){
            window.location.href = 'all_category.php';
          },2000);
        </script>

        <?php
          }else{
        $result_data = 'Category Update Failed. Error: ' .$update . '<br>' . $db->error;
      }

    }

}


// Select Old Data 
if(isset($_GET['id'])){
  $id = $_GET['id'];
  
  $sql = "SELECT * FROM categories WHERE id = '$id'";
  $result = $db->select($sql);
  $row = mysqli_fetch_assoc($result);

}
// Select Old Data 




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

              <h6 class="card-title"><?php echo $result_data ?></h6>

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" method="POST" novalidate>
                <div class="col-md-6">
                  <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                  <label for="validationCustom01" class="form-label">Category name</label>
                  <input type="text" name="name" value='<?php echo $row['name'] ?>' class="form-control" id="validationCustom01" placeholder="Type Category Name" required>
                  <div class="invalid-feedback">
                    Category Name Required
                  </div>
                  <span class="text-danger"><?php echo $name_err ?></span>
                </div>
                
                <div class="col-md-6">
                  <label for="validationCustom04" class="form-label">Status</label>
                  <select class="form-select" name="status" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option <?php echo $row['status'] == 'Active'?'selected':'' ?> value="Active">Active</option>
                    <option <?php echo $row['status'] == 'InActive'?'selected':'' ?> value="InActive">InActive</option>
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