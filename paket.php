<?php include_once 'lib/header.php';?>

<?php
    //Memiliki logika yang sama seperti index.php
    include_once 'lib/db_conf.php';
    $cnt = 0;
    $sql = "SELECT * FROM `paket`;";
    $data = mysqli_query($conn, $sql);
    $total_row = mysqli_num_rows($data);
    if ($total_row != 0):
      while ($row = mysqli_fetch_assoc($data)):
          if($cnt%4==0){
              echo '<div class="row mt-3 mb-3">';
          }
?>
    <a href="detail-paket/<?=$row['id']?>" class="col card text-center ml-3 mr-3 text-decoration-none" style="padding: 1rem;">
        <div class="row card-body justify-content-center">
            <img src="<?=BASE_URL;?>admin/<?=$row['image']?>" class="card-img-top img-fluid mt-2" style="display:block; margin-left:auto; margin-right:auto; max-height:200px; width:auto;">
        </div>
        <div class="card-footer text-center">
            <p class="mt-3" style="color: black;"><b><?=$row['name']?></b></p>
            <p class="mt-3" style="color: black;">Rp <?=$row['price']?></p>
        </div>
    </a>
<?php
          if($cnt%4 == 3 || $cnt == $total_row-1){
              echo '</div>';
          }
          $cnt++;
      endwhile;
    endif;
    $conn->close();
?>

<script>
    var element = document.getElementById("paket");
    element.classList.add("active");
</script>
<?php include_once 'lib/footer.php';?>
