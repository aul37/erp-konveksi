<?php
session_start();

//Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "anugrah");

//Menambah Company
if (isset($_POST['addnewcompany'])) {
    $company = $_POST['company_id'];
    $name = $_POST['company_name'];
    $city = $_POST['company_city'];
    $contact = $_POST['company_contact'];
    $email = $_POST['company_email'];
    $address = $_POST['company_address'];
    $status = $_POST['company_status'];

    $addtotable = mysqli_query($koneksi, "INSERT INTO company (company_id, company_name, company_city, company_contact, company_email, company_address, company_status) VALUES('$company', '$name','$city','$contact','$email', '$address','$status')");
    if ($addtotable) {
        header('location: company.php');
    } else {
        echo 'Gagal';
        header('location: company.php');
    }
};

//UPDATE COMPANY
if (isset($_POST['updatecompany'])) {
    $id = $_POST['id'];
    $company_id = $_POST['company_id'];
    $name = $_POST['company_name'];
    $city = $_POST['company_city'];
    $contact = $_POST['company_contact'];
    $email = $_POST['company_email'];
    $address = $_POST['company_address'];
    $status = $_POST['company_status'];

    $updatequery = mysqli_query($koneksi, "UPDATE company SET company_id='$company_id', company_name='$name', company_city='$city', company_contact='$contact', company_email='$email', company_address='$address', company_status='$status' WHERE id='$id'");

    if ($updatequery) {
        header('Location: company.php');
        exit();
    } else {
        echo 'Gagal mengupdate data company';
        header('Location: company.php');
        exit();
    }
}


//HAPUS COMPANY
if (isset($_POST['hapuscompany'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM company WHERE id='$id'");

    if ($hapus) {
        header('Location: company.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: company.php');
    }
}



//Menambah User
if (isset($_POST['adduser'])) {
    $department = $_POST['user_department'];
    $Code = $_POST['user_id'];
    $name = $_POST['user_name'];
    $address = $_POST['user_address'];
    $contact = $_POST['user_contact'];
    $status = $_POST['user_status'];

    $addtotable = mysqli_query($koneksi, "INSERT INTO user (user_id, user_department, user_name, user_contact, user_address, user_status) VALUES('$Code', '$department', '$name', '$contact', '$address','$status')");
    if ($addtotable) {
        header('location: user.php');
    } else {
        echo 'Gagal';
        header('location: user.php');
    }
};

//UPDATE USER 
if (isset($_POST['updateuser'])) {
    $Code = $_POST['user_id'];
    $id = $_POST['id'];
    $department = $_POST['user_department'];
    $name = $_POST['user_name'];
    $address = $_POST['user_address'];
    $contact = $_POST['user_contact'];
    $status = $_POST['user_status'];

    $updatequery = mysqli_query($koneksi, "UPDATE user SET  user_id='$Code', user_department='$department', user_name='$name', user_address='$address', user_contact='$contact', user_status='$status' WHERE id='$id'");

    if ($updatequery) {
        header('Location: user.php');
        exit();
    } else {
        echo 'Gagal mengupdate data user';
        header('Location: user.php');
        exit();
    }
}

//HAPUS USER
if (isset($_POST['hapususer'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");

    if ($hapusdata) {
        header('Location: user.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: user.php');
    }
};

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
        header('location: customer.php');
    } else {
        echo 'Gagal';
        header('location: customer.php');
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

    $updatequery = mysqli_query($koneksi, "UPDATE customer SET customer_id='$Code', customer_name='$customer', customer_npwp='$npwp', customer_contact='$contact', customer_address='$address', customer_status='$status' WHERE id='$id'");

    if ($updatequery) {
        header('Location: customer.php');
        exit();
    } else {
        echo 'Gagal mengupdate data customer';
        header('Location: customer.php');
        exit();
    }
}

//HAPUS CUSTOMER
if (isset($_POST['hapuscustomer'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM customer WHERE id='$id'");

    if ($hapusdata) {
        header('Location: customer.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: customer.php');
    }
};

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
        header('location: supplier.php');
    } else {
        echo 'Gagal';
        header('location: supplier.php');
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
        header('Location: supplier.php');
        exit();
    } else {
        echo 'Gagal mengupdate data supplier';
        header('Location: supplier.php');
        exit();
    }
}


//HAPUS SUPPLIER
if (isset($_POST['hapussupplier'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM supplier WHERE supplier_id='$id'");

    if ($hapus) {
        header('Location: supplier.php');
        exit();
    } else {
        echo 'Gagal menghapus data supplier';
        header('Location: supplier.php');
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

    $addtotable = mysqli_query($koneksi, "INSERT INTO product (product_id, product_name, product_category, product_price, product_note, product_status) VALUES ('$product', '$name', '$category', '$price', '$note', '$status')");

    if ($addtotable) {
        header('location: product.php');
    } else {
        echo 'Gagal';
        header('location: product.php');
    }
}

//UPDATE PRODUCT 
if (isset($_POST['updateproduct'])) {
    $id = $_POST['id'];
    $product_id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $price = $_POST['product_price'];
    $note = $_POST['product_note'];
    $status = $_POST['product_status'];

    $updatequery = mysqli_query($koneksi, "UPDATE product SET product_id='$product_id', product_name='$name', product_category='$category', product_price='$price', product_note='$note', product_status='$status' WHERE id='$id'");

    if ($updatequery) {
        header('Location: product.php');
        exit();
    } else {
        echo 'Gagal mengupdate data product';
        header('Location: product.php');
        exit();
    }
}



//HAPUS PRODUCT
if (isset($_POST['hapusproduct'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM product WHERE id='$id'");

    if ($hapusdata) {
        header('Location: product.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: product.php');
    }
};

//HAPUS PR
if (isset($_POST['pr_id'])) {
    $dataCode = $_POST['pr_id'];

    // Buat query SQL untuk menghapus data berdasarkan pr_id
    $mySql = "DELETE FROM pr WHERE pr_id = '$dataCode'";
    $myQry = mysqli_query($koneksi, $mySql);

    // Periksa apakah penghapusan berhasil atau tidak
    if ($myQry) {
        header('Location: pr.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: pr.php');
    }
}



// // UPDATE PR
// if (isset($_POST['updatepr'])) {
//     $id = $_POST['id'];
//     $tanggal = $_POST['tanggal'];
//     $produk = $_POST['produk'];
//     $qty = $_POST['qty'];
//     $pemohon = $_POST['pemohon'];
//     $catatan = $_POST['catatan'];

//     $updatequery = mysqli_query($koneksi, "UPDATE pr SET tanggal='$tanggal', produk='$produk', qty='$qty', pemohon='$pemohon', catatan='$catatan' WHERE id='$id'");

//     if ($updatequery) {
//         header('Location: pr.php');
//         exit();
//     } else {
//         echo 'Gagal mengupdate data pr';
//         header('Location: pr.php');
//         exit();
//     }
// }

// //HAPUS PR
// if (isset($_POST['hapuspr'])) {
//     $id = $_POST['id'];

//     $hapus = mysqli_query($koneksi, "DELETE FROM pr WHERE id='$id'");

//     if ($hapusdata) {
//         header('Location: pr.php');
//         exit();
//     } else {
//         echo 'Gagal';
//         header('Location: pr.php');
//     }
// };

// Menambah PO
if (isset($_POST['addpo'])) {
    $tanggal = $_POST['tanggal'];
    $supplier = $_POST['supplier'];
    $produk = $_POST['produk'];
    $karyawan = $_POST['karyawan'];
    $total = $_POST['total'];
    $status = $_POST['status'];

    $addtotable = mysqli_query($koneksi, "INSERT INTO po (tanggal, supplier, produk, karyawan, total, status) VALUES ('$tanggal', '$supplier', '$produk', '$karyawan', '$total', '$status')");

    if ($addtotable) {
        header('location: po.php');
    } else {
        echo 'Error: ' . mysqli_error($koneksi);
        // Add an error message or handle the error appropriately
    }
}

//UPDATE PO 
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
        header('Location: po.php');
        exit();
    } else {
        echo 'Gagal mengupdate data pr';
        header('Location: po.php');
        exit();
    }
}

//HAPUS PO
if (isset($_POST['hapuspo'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM po WHERE id='$id'");

    if ($hapusdata) {
        header('Location: pr.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: po.php');
    }
};

//HAPUS SALESMAN
if (isset($_POST['hapussalesman'])) {
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM salesman WHERE salesman_id='$id'");

    if ($hapus) {
        header('Location: salesman.php');
        exit();
    } else {
        echo 'Gagal';
        header('Location: salesman.php');
    }
}
//UPDATE SALESMAN 
if (isset($_POST['updatesalesman'])) {
    $id = $_POST['salesman_id'];
    $txtSalesman    = strtoupper($_POST['salesman_name']);
    $txtCommission  = $_POST['commission'];
    $txtCommissionDate  = $_POST['commission_date'];
    $txtStatus      = $_POST['salesman_status'];

    $updatequery = mysqli_query($koneksi, "UPDATE salesman SET salesman_name='$txtSalesman', commission='$txtCommission', commission_date='$txtCommissionDate', salesman_status='$txtStatus' WHERE salesman_id='$id'");

    if ($updatequery) {
        header('Location: salesman.php');
        exit();
    } else {
        echo 'Gagal mengupdate data pr';
        header('Location: salesman.php');
        exit();
    }
}
