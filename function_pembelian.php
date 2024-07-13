<?php
session_start();

//Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db_anugrah");

//Menambah SUPPLIER
if (isset($_POST['addsupplier'])) {
    $Code = $_POST['supplier_id'];
    $supplier = $_POST['supplier_name'];
    $address = $_POST['supplier_address'];
    $city = $_POST['supplier_city'];
    $contact = $_POST['supplier_contact'];
    $status = $_POST['supplier_status'];

    $addtotable = mysqli_query($koneksi, "INSERT INTO supplier (supplier_id, supplier_name, supplier_address, supplier_city, supplier_contact, supplier_status) VALUES('$Code', '$supplier', '$address', '$city', '$contact', '$status')");
    if ($addtotable) {
        header('location: supplier_pembelian.php');
    } else {
        echo 'Gagal';
        header('location: supplier_pembelian.php');
    }
};

//UPDATE SUPPLIER 
if (isset($_POST['updatesupplier'])) {
    $id = $_POST['id'];
    $Code = $_POST['supplier_id'];
    $supplier = $_POST['supplier_name'];
    $address = $_POST['supplier_address'];
    $city = $_POST['supplier_city'];
    $contact = $_POST['supplier_contact'];
    $status = $_POST['supplier_status'];
    $updatequery = mysqli_query($koneksi, "UPDATE supplier SET supplier_id='$Code', supplier_name='$supplier', supplier_address='$address', supplier_city='$city', supplier_contact='$contact', supplier_status='$status' WHERE supplier_id='$id'");

    if ($updatequery) {
        header('Location: supplier_pembelian.php');
        exit();
    } else {
        echo 'Gagal mengupdate data supplier';
        header('Location: supplier_pembelian.php');
        exit();
    }
}


//HAPUS SUPPLIER
if (isset($_POST['hapussupplier'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM supplier WHERE supplier_id='$id'");

    if ($hapus) {
        header('Location: supplier_pembelian.php');
        exit();
    } else {
        echo 'Gagal menghapus data supplier';
        header('Location: supplier_pembelian.php');
        exit();
    }
}


//Menambah Product
if (isset($_POST['addproduct'])) {
    $product = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $price = $_POST['product_price'];
    $note = $_POST['product_note'];
    $status = $_POST['product_status'];
    $satuan = $_POST['product_satuan'];


    $addtotable = mysqli_query($koneksi, "INSERT INTO product (product_id, product_name, product_satuan, product_category, product_price, product_note, product_status) VALUES ('$product', '$name', '$satuan', '$category', '$price', '$note', '$status')");

    if ($addtotable) {
        header('location: product_pembelian.php');
    } else {
        echo 'Gagal';
        header('location: product_pembelian.php');
    }
}

//UPDATE PRODUCT 
if (isset($_POST['updateproduct'])) {
    $id = $_POST['product_id'];
    $product_id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $price = $_POST['product_price'];
    $note = $_POST['product_note'];
    $status = $_POST['product_status'];
    $satuan = $_POST['product_satuan'];


    $updatequery = mysqli_query($koneksi, "UPDATE product SET product_id='$product_id', product_name='$name', product_satuan='$satuan', product_category='$category', product_price='$price', product_note='$note', product_status='$status' WHERE product_id='$id'");

    if ($updatequery) {
        header('Location: product_pembelian.php');
        exit();
    } else {
        echo 'Gagal mengupdate data product';
        header('Location: product_pembelian.php');
        exit();
    }
}



//HAPUS PRODUCT
if (isset($_POST['hapusproduct'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM product WHERE product_id='$id'");

    if ($hapusdata) {
        header('Location: product_pembelian.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: product_pembelian.php');
    }
};



//HAPUS Permintaan Pembelian
if (isset($_POST['hapuspr'])) {
    $id = $_POST['pr_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM pr WHERE pr_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM pr_detail WHERE pr_id='$id'");

    if ($hapus && $hapus1) {
        header('Location: pr_pembelian.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: pr_pembelian.php');
        exit();
    }
}



//UPDATE PEMBELIAN
if (isset($_POST['updatepembelian'])) {
    $prid = $myData['pr_id'];
    $prdate = $myData['pr_date'];
    $prreq = $myData['request'];
    $prnote = $myData['pr_note'];
    $prfor = $myData['pr_for'];
    $updatedate = $myData['updated_date'];
    $status = $myData['pr_status'];

    $updatequery = mysqli_query($koneksi, "UPDATE pr SET pr_id='$cprid', pr_date ='$prdate', request='$prreq', pr_note='$prnote', pr_for='$prfor', 
    updated_date='$updatedate', pr_status='$status' WHERE pr_id='$prid'");

    if ($updatequery) {
        header('Location: pr_pembelian.php');
        exit();
    } else {
        echo 'Gagal mengupdate data company';
        header('Location: pr_pembelian.php');
        exit();
    }
}

// // UPDATE Permintaan Pembelian
if (isset($_POST['updatepr'])) {
    $id = $_POST['pr_id'];
    $pr_for = $_POST['txtFor'];

    // $updatequery = mysqli_query($koneksi, "UPDATE pr SET tanggal='$tanggal', produk='$produk', qty='$qty', pemohon='$pemohon', catatan='$catatan' WHERE pr_id='$id'");
    $updatequery = mysqli_query($koneksi, "UPDATE pr SET pr_for = '$pr_for' WHERE pr_id='$id'");

    if ($updatequery) {
        header('Location: pr_pembelian.php');
        exit();
    } else {
        echo 'Gagal mengupdate data pr';
        header('Location: pr_pembelian.php');
        exit();
    }
}

// Menambah Pesanan Pembelian
if (isset($_POST['addpo'])) {
    $tanggal = $_POST['tanggal'];
    $supplier = $_POST['supplier'];
    $produk = $_POST['produk'];
    $karyawan = $_POST['karyawan'];
    $total = $_POST['total'];
    $status = $_POST['status'];

    $addtotable = mysqli_query($koneksi, "INSERT INTO po (tanggal, supplier, produk, karyawan, total, status) VALUES ('$tanggal', '$supplier', '$produk', '$karyawan', '$total', '$status')");

    if ($addtotable) {
        header('location: po_pembelian.php');
    } else {
        echo 'Error: ' . mysqli_error($koneksi);
        // Add an error message or handle the error appropriately
    }
}

//UPDATE Pesanan Pembelian 
if (isset($_POST['updatepo'])) {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $supplier = $_POST['supplier'];
    $produk = $_POST['produk'];
    $karyawan = $_POST['karyawan'];
    $total = $_POST['total'];
    $status = $_POST['status'];

    $updatequery = mysqli_query($koneksi, "UPDATE po SET tanggal='$tanggal', supplier='$supplier', produk='$produk', karyawan='$karyawan', total='$total', status='$status' WHERE id='$id'");

    if ($updatequery) {
        header('Location: po_pembelian.php');
        exit();
    } else {
        echo 'Gagal mengupdate data pr';
        header('Location: po_pembelian.php');
        exit();
    }
}

//HAPUS Pesanan Pembelian
if (isset($_POST['hapuspo'])) {
    $id = $_POST['purchase_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM po WHERE purchase_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM po_detail WHERE purchase_id='$id'");

    if ($hapus && $hapus1) {
        header('Location: po_pembelian.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: po_pembelian.php');
        exit();
    }
}

//HAPUS Surat Masuk Barang
if (isset($_POST['hapussmb'])) {
    $id = $_POST['stock_order_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM stock_order WHERE stock_order_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM stock_order_detail WHERE stock_order_id='$id'");
    $hapus3 = mysqli_query($koneksi, "DELETE FROM stock WHERE stock_order_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: surat_masuk_barang_pembelian.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: surat_masuk_barang_pembelian.php');
        exit();
    }
}


//HAPUS Penerimaan Invoice
if (isset($_POST['hapusPI'])) {
    $id = $_POST['purchase_invoice_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM purchase_invoice WHERE purchase_invoice_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM purchase_invoice_detail WHERE purchase_invoice_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: penerimaan_invoice_pembelian.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: penerimaan_invoice_pembelian.php');
        exit();
    }
}

//HAPUS Pembayaran Pembelian
if (isset($_POST['hapusPP'])) {
    $id = $_POST['payment_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM purchase_payment WHERE payment_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM purchase_payment_detail WHERE payment_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: pembayaran_pembelian_pembelian.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: pembayaran_pembelian_pembelian.php');
        exit();
    }
}
