<?php
//koneksi kedata base
$conn = mysqli_connect("localhost", "root", "", "kantinsehat");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;

     $nama = htmlspecialchars($data["nama"]);
     $kelas = htmlspecialchars($data["kelas"]);
     $jurusan = htmlspecialchars($data["jurusan"]);
     $pesanan = htmlspecialchars($data["pesanan"]);
    

    
    $query ="INSERT INTO pembeli
        VALUES
        ('', '$nama', '$kelas', '$jurusan', '$pesanan' )
    ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM pembeli WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data){
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $kelas = htmlspecialchars($data["kelas"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $pesanan = htmlspecialchars($data["pesanan"]);


    $query = "UPDATE pembeli SET
                nama = '$nama',
                kelas = '$kelas',
                jurusan = '$jurusan',
                pesanan = '$pesanan'
                WHERE id = $id
        ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username sudah terdaftar!')
            </script>";

            return false;
    }
    //cek konfirmasi password
    if($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
            </script>";

            return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    

    //tambahkan user baru ke database

    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}

?>