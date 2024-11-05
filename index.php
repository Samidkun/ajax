<?php
include 'auth.php'; // Ensures user authentication
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Csrf Token -->
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlW1YBJy1r1R7h7u7ni7Udi9RwhKhhpvLWIUPS8GfpG+6F5g8d4K6U6p" crossorigin="anonymous">
    <!-- DataTable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <title>Data Anggota</title>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="index.php" style="color: #fff;">
        CRUD Dengan Ajax 
    </a>
</nav>
<div class="container">
    <h2 align="center" style="margin: 30px;">Data Anggota</h2>
    <form method="post" class="form-data" id="form-data">
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" name="id" id="id">
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <p class="text-danger" id="err_nama"></p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Jenis Kelamin</label><br>
                    <input type="radio" name="jenis_kelamin" id="jenkel1" value="L" required> Laki-laki
                    <input type="radio" name="jenis_kelamin" id="jenkel2" value="P"> Perempuan
                    <p class="text-danger" id="err_jenis_kelamin"></p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required></textarea>
            <p class="text-danger" id="err_alamat"></p>
        </div>
        <div class="form-group">
            <label>No Telepon</label>
            <input type="tel" name="no_telp" id="no_telp" class="form-control" required pattern="[0-9]{10,15}">
            <p class="text-danger" id="err_no_telp"></p>
        </div>
        <div class="form-group">
            <button type="button" name="simpan" id="simpan" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan
            </button>
        </div>
    </form>

    <hr>
    <div class="data"></div>
</div>
<div class="text-center">© <?= date('Y'); ?> Copyright:
    <a href="https://google.com/"> Desain Dan Pemrograman Web</a>
</div>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- DataTable -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Set up CSRF token for secure AJAX requests
    $.ajaxSetup({
        headers: {
            'Csrf-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Load data initially
    $('.data').load('data.php');

    // Save button click event
    $('#simpan').click(function() {
        var data = $('.form-data').serialize();
        var nama = $('#nama').val();
        var alamat = $('#alamat').val();
        var no_telp = $('#no_telp').val();

        // Clear previous error messages
        $('.text-danger').text('');

        // Validation
        let isValid = true;

        if (nama === '') {
            $('#err_nama').text('Nama Harus Diisi');
            isValid = false;
        }
        if (alamat === '') {
            $('#err_alamat').text('Alamat Harus Diisi');
            isValid = false;
        }
        if (!$('input[name="jenis_kelamin"]:checked').length) {
            $('#err_jenis_kelamin').text('Jenis Kelamin Harus Dipilih');
            isValid = false;
        }
        if (no_telp === '') {
            $('#err_no_telp').text('No Telepon Harus Diisi');
            isValid = false;
        }

        // If all validations pass
        if (isValid) {
            $.ajax({
                type: 'POST',
                url: 'form_action.php',
                data: data,
                success: function() {
                    // Reload data and reset form after successful submission
                    $('.data').load('data.php');
                    $('#id').val('');
                    $('#form-data')[0].reset();
                },
                error: function(response) {
                    console.log(response.responseText);
                }
            });
        }
    });
});
</script>
</body>
</html>
