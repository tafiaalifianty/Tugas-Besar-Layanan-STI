<?php include_once 'lib/header.php';
    if(!isset($_GET['id'])){
        echo "<script language=\"javascript\">window.location.href = '".BASE_URL."paket';</script>";
    }
    // $id = $_GET['id'];
    $data = explode("/",$_GET['id']);

    // var_dump($data); die;
  
    $id = $data[0];

    $sql = "SELECT * FROM `paket` WHERE `id`=$id";

    $data = mysqli_query($conn, $sql);
    $total_row = mysqli_num_rows($data);
    if($total_row == 0){
        echo "<script language=\"javascript\">window.location.href = '".BASE_URL."paket';</script>";
    }

    //Apabila tombol tambah ditekan
    if(isset($_POST['tambah'])){
        $id_food = $_POST['nama'];
        $qty = $_POST['qty'];
        //Menambahkan makanan ke paket
        $sql = "INSERT INTO `konten_paket` SET `id_food`=$id_food, `id_paket`=$id, `food_qty`=$qty;";

        if(mysqli_query($conn, $sql)){
            echo "<script language=\"javascript\">window.location.href = '".BASE_URL."paket/detail/$id';</script>";
        }
    }
?>

<h1 class="text-center mt-3">Tambah Makanan ke Paket</h1>

<div class="card ml-3 mr-3">
    <div class="card-body">
        <form method="post" action="<?=BASE_URL;?>paket/detail/<?=$id;?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Makanan</label>
                <select class="form-control" id="nama" name="nama" title="Pilih Makanan" required>
                    <option disabled selected value="">Pilih Makanan</option>
                    <?php
                        $sql = "SELECT * FROM `food`";

                        $data = mysqli_query($conn, $sql);
                        // Membaca data array menggunakan foreach
                        while ($row = mysqli_fetch_assoc($data)):
                    ?>
                    <tr>
                        <option value="<?=$row['id']?>"><?=$row['name']?> (Rp <?=$row['price']?>)</option>
                    </tr>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group">
                <label for="qty">Kuantitas</label>
                <input type="number" class="form-control" min="1" max="100" id="qty" name="qty" required>
            </div>
            </br>
            <button type="submit" class="btn btn-success" id="tambah" name="tambah" value="tambah">Tambah</button>
        </form>
    </div>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Makanan Untuk Paket dengan ID <?=$id?>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Kuantitas</th>
            </thead>
            <tbody>
                <?php
                    include_once 'lib/db_conf.php';

                    $sql = "SELECT `f`.`id` AS `id`, `f`.`name` AS `name`, 
                        `f`.`price` AS `price`, `kp`.`food_qty` AS `qty` 
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