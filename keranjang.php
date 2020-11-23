<?php include_once 'lib/header.php';
    function clear_cookie($cookie_name){
        if(isset($_COOKIE[$cookie_name])){
            unset($_COOKIE[$cookie_name]);
            setcookie($cookie_name, null, -1, '/');
        }
    }
  function keranjangKosong(){
    echo '<script>alert(\'Keranjang kosong, mari buat Order terlebih dahulu!\');
        window.location.href = \'index.php\';</script>';
    exit;
  }

  if(!isset($_COOKIE['cart_cookie_food']) && !isset($_COOKIE['cart_cookie_paket'])){
      keranjangKosong();
  }

  //Mendapatkan data dari cookie dan memetakanya ke tabel
  $cart_food = array();
  $cart_length_food = 0;
  $cart_paket = array();
  $cart_length_paket = 0;

  if(isset($_COOKIE['cart_cookie_food'])){
    $cart_food = unserialize($_COOKIE['cart_cookie_food'], ["allowed_classes" => false]);
    $cart_length_food = count($cart_food);
  }
  if(isset($_COOKIE['cart_cookie_paket'])){
    $cart_paket = unserialize($_COOKIE['cart_cookie_paket'], ["allowed_classes" => false]);
    $cart_length_paket = count($cart_paket);
  }

  if($cart_length_food == 0 && $cart_length_paket == 0){
      keranjangKosong();
  }

  $tot_price = 0;
  
  include_once 'lib/db_conf.php';

  if(isset($_POST['order'])){
    $tot_items = $cart_length_food + $cart_length_paket;
    $cust_name = $_POST['nama'];
    $cust_phone = $_POST['phone'];
    $sql = "INSERT INTO `order` SET `total_price`=$tot_price, 
        `total_items`=$tot_items, `cust_name`='$cust_name', 
        `cust_phone`='$cust_phone';";

    if(mysqli_query($conn, $sql)){
        $order_id = mysqli_insert_id($conn);
        for($i = 0; $i < $cart_length_food; $i++):
            $sql = "SELECT `price` FROM `food` WHERE `id` = ".$cart_food[$i]['id'].";";
            $data = mysqli_query($conn, $sql);
            $subtotal = 0;
            $kuantitas = 0;
            $c_id = $cart_food[$i]['id'];
            while ($row = mysqli_fetch_assoc($data)):
                $kuantitas = $cart_food[$i]['qty'];
                $subtotal = $kuantitas * $row['price'];
                $tot_price += $subtotal;
            endwhile;
            $sql = "INSERT INTO `order_detail_food` SET `id_food`=$c_id,
                `subtotal`=$subtotal,`quantity`=$kuantitas,`id_order`=$order_id;";
            if(mysqli_query($conn, $sql)){}
        endfor;
        for($i = 0; $i < $cart_length_paket; $i++):
            $sql = "SELECT `price` FROM `paket` WHERE `id` = ".$cart_paket[$i]['id'].";";
            $data = mysqli_query($conn, $sql);
            $subtotal = 0;
            $kuantitas = 0;
            $c_id = $cart_paket[$i]['id'];
            while ($row = mysqli_fetch_assoc($data)):
                $kuantitas = $cart_paket[$i]['qty'];
                $subtotal = $kuantitas * $row['price'];
                $tot_price += $subtotal;
            endwhile;
            $sql = "INSERT INTO `order_detail_paket` SET `id_paket`=$c_id,
                `subtotal`=$subtotal,`quantity`=$kuantitas,`id_order`=$order_id;";
            if(mysqli_query($conn, $sql)){}
        endfor;

        $sql = "UPDATE `order` SET `total_price`=$tot_price WHERE `id`=$order_id";
        if(mysqli_query($conn, $sql)){}

        clear_cookie('cart_cookie_food');
        clear_cookie('cart_cookie_paket');
        echo '<script>alert(\'Berhasil membuat order, tunggu pihak restoran mengkontak anda!\');
            window.location.href = \'index.php\';</script>';
    }
  }
?>

<h1 class="text-center mt-3">Keranjang</h1>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Makanan di Keranjang
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel_food">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Kuantitas</th>
                <th scope="col">Subtotal</th>
            </thead>
            <tbody>
<?php
  for($i = 0; $i < $cart_length_food; $i++):
    $sql = "SELECT * FROM `food` WHERE `id` = ".$cart_food[$i]['id'].";";
    $data = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($data)):
?>

<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['name']?></td>
    <td><?=$row['price']?></td>
    <td><?=$cart_food[$i]['qty']?></td>
    <td><?php $sub = $row['price']*$cart_food[$i]['qty'];
        $tot_price += $sub;
        echo $sub;?></td>
</tr>

<?php endwhile; endfor;?>
            </tbody>
        </table> 
    </div>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Paket di Keranjang
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel_paket">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Kuantitas</th>
                <th scope="col">Subtotal</th>
            </thead>
            <tbody>
<?php
  for($i = 0; $i < $cart_length_paket; $i++):
    $sql = "SELECT * FROM `paket` WHERE `id` = ".$cart_paket[$i]['id'].";";
    $data = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($data)):
?>

<tr>
    <td><?=$row['id']?></td>
    <td><?=$row['name']?></td>
    <td><?=$row['price']?></td>
    <td><?=$cart_paket[$i]['qty']?></td>
    <td><?php $sub = $row['price']*$cart_paket[$i]['qty'];
        $tot_price += $sub;
        echo $sub;?></td>
</tr>

<?php endwhile; endfor;?>
            </tbody>
        </table> 
    </div>
</div>

<div class="mb-2 mt-4 ml-2 mr-2 col row">
  <div class="flex ml-auto mr-5">
    <p class="row" id="total_price" style="color: black; font-size: 15px;">Total: Rp <?=$tot_price?>.00</p>
  </div>
  <div class="flex" style="display: flex; align-items: center;">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Buat Order</button>
  </div>
</div>

<form method="post" enctype="multipart/form-data" class="modal fade bd-example-modal-md" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukan Data Diri Anda:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" class="form-control" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="phone">No. Telepon/WhatsApp:</label>
                    <input type="text" id="phone" class="form-control" name="phone" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="order" name="order" value="order">Order</button>
            </div>
            </form>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        var table = $('#tabel_food').DataTable({});
        var table = $('#tabel_paket').DataTable({});
    });

    var element = document.getElementById("keranjang");
    element.classList.add("active");
</script>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';
    $conn->close();
?>
