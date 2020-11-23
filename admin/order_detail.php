<?php include_once 'lib/header.php';
    if(!isset($_GET['id'])){
        echo "<script language=\"javascript\">window.location.href = 'index.php';</script>";
    }

    $id = $_GET['id'];
    
    include_once 'lib/db_conf.php';

    //Mendapatkan data detail order bedasarkan id
    $sql = "SELECT * FROM `order` WHERE `id`=$id;";

    $data = mysqli_query($conn, $sql);
    $total_row = mysqli_num_rows($data);

    if($total_row == 0):
        header("Location: index.php");
        exit;
    endif;
    
    $tot_price = 0;
    $tot_items = 0;
    $date = 0;
    $cust_name = '';
    $cust_phone = '';

    while ($row = mysqli_fetch_assoc($data)):
        $tot_price = $row['total_price'];
        $tot_items = $row['total_items'];
        $date = $row['order_date'];
        $cust_name = $row['cust_name'];
        $cust_phone = $row['cust_phone'];
    endwhile;

    //mendapatkan data makanan bedasarkan id order untuk ditampilkan pada tabel
    $food_order = array();
    $sql = "SELECT * FROM `order_detail_food` WHERE `id_order`=$id;";
    $data = mysqli_query($conn, $sql);
    $cnt = 0;
    while ($row = mysqli_fetch_assoc($data)):
        $food_order[$cnt]['id_food'] = $row['id_food'];
        $food_order[$cnt]['subtotal'] = $row['subtotal'];
        $food_order[$cnt]['quantity'] = $row['quantity'];
        $cnt++;
    endwhile;
    $food_length = $cnt;

    //mendapatkan data paket bedasarkan id order untuk ditampilkan pada tabel
    $paket_order = array();
    $sql = "SELECT * FROM `order_detail_paket` WHERE `id_order`=$id;";
    $data = mysqli_query($conn, $sql);
    $cnt = 0;
    while ($row = mysqli_fetch_assoc($data)):
        $paket_order[$cnt]['id_paket'] = $row['id_paket'];
        $paket_order[$cnt]['subtotal'] = $row['subtotal'];
        $paket_order[$cnt]['quantity'] = $row['quantity'];
        $cnt++;
    endwhile;
    $paket_length = $cnt;
?>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Order #<?=$id?>
    </div>
    <div class="card-body">
        Tanggal Waktu: <?=$date?></br>
        Total Harga: <?=$tot_price?></br>
        Jumlah Item: <?=$tot_items?></br>
        Nama Customer: <?=$cust_name?></br>
        Telepon Customer: <?=$cust_phone?></br>
    </div>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Makanan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel_food">
            <thead class="thead-dark">
                <th scope="col">ID Makanan</th>
                <th scope="col">Kuantitas</th>
                <th scope="col">Subtotal</th>
            </thead>
            <tbody>
                <?php
                    for($i=0;$i<$food_length;$i++):
                ?>
                <tr>
                    <td><?=$food_order[$i]['id_food']?></td>
                    <td><?=$food_order[$i]['quantity']?></td>
                    <td><?=$food_order[$i]['subtotal']?></td>
                </tr>
                    <?php endfor;?>
            </tbody>
        </table> 
    </div>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Paket
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel_paket">
            <thead class="thead-dark">
                <th scope="col">ID Paket</th>
                <th scope="col">Kuantitas</th>
                <th scope="col">Subtotal</th>
            </thead>
            <tbody>
                <?php
                    for($i=0;$i<$paket_length;$i++):
                ?>
                <tr>
                    <td><?=$paket_order[$i]['id_paket']?></td>
                    <td><?=$paket_order[$i]['quantity']?></td>
                    <td><?=$paket_order[$i]['subtotal']?></td>
                </tr>
                    <?php endfor;?>
            </tbody>
        </table> 
    </div>
</div>

<script>
    $(document).ready(function(){
        var table = $('#tabel_food').DataTable({});
        var table = $('#tabel_paket').DataTable({});
    });
</script>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';
    $conn->close();
?>