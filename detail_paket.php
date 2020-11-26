<?php include_once 'lib/header.php';
  //Bekerja mirip seperti detail_food.php
  if(!isset($_GET['id'])){
    header("Location: paket.php");
    exit;
  }

  $data = explode("/",$_GET['id']);
  
  $id = $data[0];

  include_once 'lib/db_conf.php';

  $sql = "SELECT * FROM `paket` WHERE `id` = $id;";

  $data = mysqli_query($conn, $sql);
  $total_row = mysqli_num_rows($data);

  if($total_row == 0):
    header("Location: paket.php");
    exit;
  endif;

  $cur_qty = 0;

  if(isset($_COOKIE['cart_cookie_paket'])){
    $cart = unserialize($_COOKIE['cart_cookie_paket'], ["allowed_classes" => false]);
    $cart_length = count($cart);

    for($i = 0; $i < $cart_length; $i++){
      if($cart[$i]['id'] == $id){
        $cur_qty = $cart[$i]['qty'];
        break;
      }
    }
  }

  if(isset($_POST['submit'])){
    if(isset($_COOKIE['cart_cookie_paket'])){
      $cart = unserialize($_COOKIE['cart_cookie_paket'], ["allowed_classes" => false]);
    }else{
      $cart = array();
    }

    $cart_length = count($cart);
    $indeks = -1;

    for($i = 0; $i < $cart_length; $i++){
      if($cart[$i]['id'] == $id){
        $indeks = $i;
        break;
      }
    }

    if($indeks == -1){
      $indeks = $cart_length;
    }
    if(!isset($cart[$indeks])){
      $cart[$indeks] = array();
    }

    $kuantitas = $_POST['qty'];
    
    $isRemoving = $indeks != $cart_length && $kuantitas == 0;

    if($isRemoving){
        array_splice($cart, $indeks, 1);
    }else if($kuantitas > 0){
        $cart[$indeks]['id'] = $id;
        $cart[$indeks]['qty'] = $kuantitas; 
    }

    if($isRemoving || $kuantitas > 0){
        setcookie('cart_cookie_paket', serialize($cart), time() + (86400 * 30), "/");
    }

    header("Location: ". BASE_URL ."keranjang");
    exit;
  }

  while ($row = mysqli_fetch_assoc($data)):
    $nama_paket = $row['name'];
?>

<div class="mb-2 mt-4 ml-2 mr-2 col row">
  <img class="col-5" src="<?=BASE_URL;?>admin/<?=$row['image']?>" height="350px" style="display:block; width:auto;">
  <div class="col ml-2">
    <p class="mt-3" style="color: black; font-size: 30px;"><b><?=$nama_paket?></b></p>
    <form method="post" action="<?=BASE_URL;?>detail-paket/<?=$row['id'];?>" enctype="multipart/form-data">
      <input id="qty" name="qty" class="ml-1 mr-1 row form-control" style="max-width: 200px;" value="<?=$cur_qty?>" step="1" min="0" type="number" placeholder="Jumlah Makanan" required>
      <button id="submit" name="submit" value="submit" type="submit" class="mt-3 btn btn-warning">Tambah ke Keranjang</button>
    </form>
  </div>
</div>
<?php endwhile;?>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Makanan untuk <?=$nama_paket?>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Gambar</th>
            </thead>
            <tbody>
                <?php
                    include_once 'lib/db_conf.php';

                    $sql = "SELECT `f`.`id` AS `id`, `f`.`name` AS `name`, 
                        `f`.`price` AS `price`, `kp`.`food_qty` AS `qty`, 
                        `f`.`image` AS `image` 
                        FROM `konten_paket` AS `kp` 
                        JOIN `food` AS `f` ON `kp`.`id_food`=`f`.`id` 
                        WHERE `kp`.`id_paket`=$id;";

                    $data = mysqli_query($conn, $sql);
                    // Membaca data array menggunakan foreach
                    while ($row = mysqli_fetch_assoc($data)):
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['name']?></td>
                    <td><?=$row['price']?></td>
                    <td><?=$row['qty']?></td>
                    <td><img src="<?=BASE_URL;?>admin/<?=$row['image']?>" style="max-height: 250px;"></td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table> 
    </div>
</div>

<script>
    $(document).ready(function(){
        var table = $('#tabel').DataTable({});
    });
</script>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';
  $conn->close();
?>
