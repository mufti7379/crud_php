CREATE TABLE pengguna (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'penulis') DEFAULT 'penulis',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE berita (
    id_berita INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT NOT NULL,
    id_user INT NOT NULL,
    id_kategori INT NOT NULL,
    tanggal_publish DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('draft', 'publish') DEFAULT 'draft',

    CONSTRAINT fk_berita_user
        FOREIGN KEY (id_user)
        REFERENCES pengguna(id_user)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_berita_kategori
        FOREIGN KEY (id_kategori)
        REFERENCES kategori(id_kategori)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);



insert into pengguna (id_user,nama,email,password,role)
VALUES (1,"Mufti","mufutirf@gmail.com","Mufti1012","admin");



