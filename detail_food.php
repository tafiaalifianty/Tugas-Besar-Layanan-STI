<?php include_once 'lib/header.php';
  if(!isset($_GET['id'])){
    header("Location: " . BASE_URL);
    exit;
  }

  $data = explode("/",$_GET['id']);
  
  $id = $data[0];
  

  $sql = "SELECT * FROM `food` WHERE `id` = $id;";

  $data = mysqli_query($conn, $sql);
  $total_row = mysqli_num_rows($data);

  if($total_row == 0):
    header("Location: " . BASE_URL);
    exit;
  endif;

  $cur_qty = 0;

  //Mendapatkan data food dari cart untuk menyetel quantity nya
  if(isset($_COOKIE['cart_cookie_food'])){
    $cart = unserialize($_COOKIE['cart_cookie_food'], ["allowed_classes" => false]);
    $cart_length = count($cart);

    for($i = 0; $i < $cart_length; $i++){
      if($cart[$i]['id'] == $id){
        $cur_qty = $cart[$i]['qty'];
        break;
      }
    }
  }

  //Apabila tombol submit di klik maka akan ditambahkan quantity ke cookie cart
  if(isset($_POST['submit'])){
    if(isset($_COOKIE['cart_cookie_food'])){
      $cart = unserialize($_COOKIE['cart_cookie_food'], ["allowed_classes" => false]);
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
        setcookie('cart_cookie_food', serialize($cart), time() + (86400 * 30), "/");
    }

    header("Location: ".BASE_URL."index.php");
    exit;
  }

  while ($row = mysqli_fetch_assoc($data)):
    // var_dump($row); die();
?>

<div class="mb-2 mt-4 ml-2 mr-2 col row">
  <img class="col-5" src="<?=BASE_URL;?>admin/<?=$row['image']?>" height="350px" style="display:block; width:auto;">
  <div class="col ml-2">
    <p class="mt-3" style="color: black; font-size: 30px;"><b><?=$row['name']?></b></p>
    <form method="post" action="<?=BASE_URL;?>detail/<?=$row['id'];?>" enctype="multipart/form-data">
      <input id="qty" name="qty" class="ml-1 mr-1 row form-control" style="max-width: 200px;" value="<?=$cur_qty?>" step="1" min="0" type="number" placeholder="Jumlah Makanan" required>
      <button id="submit" name="submit" value="submit" type="submit" class="mt-3 btn btn-warning">Tambah ke Keranjang</button>
    </form>
  </div>
</div>

<?php 
    endwhile;
    include_once 'lib/footer.php';
    $conn->close();
?>
