<div class="main-banner header-text">
      <div class="container-fluid">
        <div class="owl-banner owl-carousel">

          <?php 
              $sql = "SELECT *,categories.id AS cid, posts.id AS pid, categories.name
                      FROM posts
                      INNER JOIN categories ON posts.category_id = categories.id";

              $result = $db->select($sql);

              if ($result) {
                
               while($row = mysqli_fetch_assoc($result)){ 

                ?>
                 
             
                <div class="item">
                  <img src="admin/<?php echo $row['photo'] ?>" alt="">
                  <div class="item-content">
                    <div class="main-content">
                      <div class="meta-category">
                        <span><?php echo $row['name'] ?></span>
                      </div>
                      <a href="post-details.php"><h4><?php echo $row['title'] ?></h4></a>
                      <ul class="post-info">
                        <li><a href="#">Admin</a></li>
                        <li><a href="#"><?php echo date_format(date_create($row['created_at']), 'M d, Y') ?></a></li>
                        <li><a href="#">12 Comments</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


           <?php }
             }

            ?>
          
        </div>
      </div>
    </div>