<?php include_once 'lib/header.php';?>


<div class="mb-2 mt-4 ml-2 mr-2 col row">
    <a href="<?=BASE_URL;?>paket/create" class="btn btn-success ml-auto">Paket Baru</a>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Paket
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md text-center" id="tabel">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Gambar</th>
                <th scope="col">Edit</th>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `paket`";

                    $data = mysqli_query($conn, $sql);
                    // Membaca data array menggunakan foreach
                    while ($row = mysqli_fetch_assoc($data)):
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['name']?></td>
                    <td><?=$row['price']?></td>
                    <td><img src="<?=$row['image']?>" style="max-height: 250px;"></td>
                    <td>
                        <a href="<?=BASE_URL;?>paket/delete/<?=$row['id']?>" class="btn btn-danger">Hapus</a>
                        <a href="<?=BASE_URL;?>paket/detail/<?=$row['id']?>" class="btn btn-success">Makanan</a>
                    </td>
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

    var element = document.getElementById("paket");
    element.classList.add("active");
</script>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';?>
