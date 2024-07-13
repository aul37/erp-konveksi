<?php
session_start();

//Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db_anugrah");

//Menambah customer
if (isset($_POST['addcustomer'])) {
    $Code = $_POST['customer_id'];
    $customer = $_POST['customer_name'];
    $npwp = $_POST['customer_npwp'];
    $address = $_POST['customer_address'];
    $contact = $_POST['customer_contact'];
    $status = $_POST['customer_status'];

    $addtotable = mysqli_query($koneksi, "INSERT INTO customer (customer_id, customer_name, customer_npwp, customer_contact, customer_address, customer_status) VALUES('$Code', '$customer', '$npwp', '$contact', '$address', '$status')");
    if ($addtotable) {
        header('location: customer_penjualan.php');
    } else {
        echo 'Gagal';
        header('location: customer_penjualan.php');
    }
};

//UPDATE CUSTOMER 
if (isset($_POST['updatecustomer'])) {
    $id = $_POST['id'];
    $Code = $_POST['customer_id'];
    $customer = $_POST['customer_name'];
    $npwp = $_POST['customer_npwp'];
    $address = $_POST['customer_address'];
    $contact = $_POST['customer_contact'];
    $status = $_POST['customer_status'];

    $updatequery = mysqli_query($koneksi, "UPDATE customer SET customer_id='$Code', customer_name='$customer', customer_npwp='$npwp', customer_contact='$contact', customer_address='$address', customer_status='$status' WHERE customer_id='$id'");

    if ($updatequery) {
        header('Location: customer_penjualan.php');
        exit();
    } else {
        echo 'Gagal mengupdate data customer';
        header('Location: customer_penjualan.php');
        exit();
    }
}

//HAPUS CUSTOMER
if (isset($_POST['hapuscustomer'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM customer WHERE customer_id='$id'");

    if ($hapusdata) {
        header('Location: customer_penjualan.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: customer_penjualan.php');
    }
};


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
        header('location: product_penjualan.php');
    } else {
        echo 'Gagal';
        header('location: product_penjualan.php');
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
        header('Location: product_penjualan.php');
        exit();
    } else {
        echo 'Gagal mengupdate data product';
        header('Location: product_penjualan.php');
        exit();
    }
}



//HAPUS PRODUCT
if (isset($_POST['hapusproduct'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM product WHERE product_id='$id'");

    if ($hapusdata) {
        header('Location: product_penjualan.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: product_penjualan.php');
    }
};






//HAPUS Surat Keluar Barang
if (isset($_POST['hapusskb'])) {
    $id = $_POST['stock_order_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM stock_order WHERE stock_order_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM stock_order_detail WHERE stock_order_id='$id'");
    $hapus3 = mysqli_query($koneksi, "DELETE FROM stock WHERE stock_order_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: surat_keluar_barang_penjualan.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: surat_keluar_barang_penjualan.php');
        exit();
    }
}

//HAPUS Sales Order
if (isset($_POST['hapusso'])) {
    $id = $_POST['sales_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM sales WHERE sales_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM sales_detail WHERE sales_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: sales_order_penjualan.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: sales_order_penjualan.php');
        exit();
    }
}

//HAPUS Faktur Penjualan
if (isset($_POST['hapusfj'])) {
    $id = $_POST['billing_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM billing WHERE billing_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM billing_detail WHERE billing_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: faktur_penjualan_penjualan.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: faktur_penjualan_penjualan.php');
        exit();
    }
}



//HAPUS Penerimaan Penjualan
if (isset($_POST['hapusPJ'])) {
    $id = $_POST['payment_id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM payment WHERE payment_id='$id'");
    $hapus1 = mysqli_query($koneksi, "DELETE FROM payment_detail WHERE payment_id='$id'");


    if ($hapus && $hapus1) {
        header('Location: penerimaan_penjualan_penjualan.php');
        exit();
    } else {
        echo 'Gagal menghapus data.';
        header('Location: penerimaan_penjualan_penjualan.php');
        exit();
    }
}
