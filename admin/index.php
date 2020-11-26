<?php include_once 'lib/header.php';?>
<div class="mb-2 mt-4 ml-2 mr-2 col row">
    <a href="./ekspor_customer" class="btn btn-success ml-auto">Ekspor Data Customer</a>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Order
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Jumlah Item</th>
                <th scope="col">Nama Customer</th>
                <th scope="col">Telepon Customer</th>
                <th scope="col">Menu</th>
            </thead>
            <tbody>
                <?php
                    
                    //Menampilkan order yang memiliki status 0 (belum selesai)
                    $sql = "SELECT * FROM `order` order by `status` asc";

                    $data = mysqli_query($conn, $sql);
                    // Membaca data array menggunakan foreach
                    while ($row = mysqli_fetch_assoc($data)):
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['order_date']?></td>
                    <td>Rp <?=$row['total_price']?></td>
                    <td><?=$row['total_items']?></td>
                    <td><?=$row['cust_name']?></td>
                    <td><?=$row['cust_phone']?></td>
                    <td>
                        <?php if($row['status'] == 0){ ?>
                        <a href="./finish/<?=$row['id']?>" class="btn btn-success">Selesai</a>
                        <?php }else{ ?>
                        <span class="btn btn-default">Selesai</span>
                        <?php } ?>
                        <a href="./order-detail/<?=$row['id']?>" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table> 
    </div>
</div>

<script>
    $(document).ready(function(){
        //tabel order diurutkan bedasarkan tanggal order terakhir
        //asc atau desc
        var table = $('#tabel').DataTable({
            // order: [
            //     [1, 'desc']
            // ]
        });
    });
    var element = document.getElementById("beranda");
    element.classList.add("active");
</script>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';?>
