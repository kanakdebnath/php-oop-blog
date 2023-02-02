<?php

include_once('inc/header.php');


// for delete data 
if(isset($_GET['id'])){
  $id = $_GET['id'];


  $sql_post = "SELECT * FROM posts WHERE id = '$id'";
  $result_post = $db->select($sql_post);
  $row_post = mysqli_fetch_assoc($result_post);

  if ($row_post['photo']) {
    unlink($row_post['photo']);
  }
  
  $sql_delete = "DELETE FROM posts WHERE id = '$id'"; 
  $delete = $db->delete($sql_delete);

  if($delete){
    echo 'Data Delete Successfully';
  }else{
    echo 'Data Delete failed';
  }

}
// for delete data 


// $sql = "SELECT * FROM posts";

$sql = "SELECT *, posts.id AS pid, categories.id AS cid,categories.name
                      FROM posts
                      INNER JOIN categories ON posts.category_id = categories.id";

$result = $db->select($sql);

 ?>
  <!-- ======= Sidebar ======= -->
<?php include_once('inc/sidebar.php') ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Posts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">All Posts</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->



    <section class="section">
     
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">All Posts <a class="btn btn-success" href="add_post.php">Create</a></h5>


              <!-- Table with stripped rows -->
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Photo</th>
                    <th scope="col">status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $i = 0;
                    if ($result) {
                     
                      while($row = mysqli_fetch_assoc($result)){
                        $i++ 


                    ?>

                  <tr>
                    <td><?php echo $i  ?></td>
                    <td><?php echo $row['title']  ?></td>

                    <td><?php echo $row['name']  ?></td>
                    <td>
                      <img width="120" height="80" src="<?php echo $row['photo']  ?>">
                    </td>
                    <td><?php echo $row['status']  ?></td>
                    <td><?php echo $row['created_at']  ?></td>

                    <td>

                    <a href="edit_post.php?id=<?php echo $row['id']  ?>" class="btn btn-warning">Edit</a>
                      
                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="?id=<?php echo $row['id']  ?>" class="btn btn-danger">Delete</a></td>

                  </tr>
                  <?php } }else{  ?>

                  <tr>
                    <td colspan="7" class="text-center">No data Found</td>
                  </tr>
                  
                <?php } ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>


        </div>
    </section>


  </main><!-- End #main -->
<?php include_once('inc/footer.php') ?>