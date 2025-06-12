-- Automotive Workshop Management System Database
-- Estonian Personal ID and email validation included
-- Normalized database structure (3NF)

CREATE DATABASE autoremondi_susteem CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE autoremondi_susteem;

-- Klientide tabel
CREATE TABLE kliendid (
    id INT PRIMARY KEY AUTO_INCREMENT,
    eesnimi VARCHAR(50) NOT NULL,
    perekonnanimi VARCHAR(50) NOT NULL,
    isikukood CHAR(11) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    parool VARCHAR(255) NOT NULL,
    telefon VARCHAR(20),
    aadress VARCHAR(200),
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_isikukood (isikukood),
    INDEX idx_email (email)
);

-- Töötajate tabel
CREATE TABLE toottajad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    eesnimi VARCHAR(50) NOT NULL,
    perekonnanimi VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    parool VARCHAR(255) NOT NULL,
    roll ENUM('admin', 'mehhaanik') DEFAULT 'mehhaanik',
    telefon VARCHAR(20),
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);

-- Teenuste tabel
CREATE TABLE teenused (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nimi VARCHAR(100) NOT NULL,
    kirjeldus TEXT,
    kestus INT NOT NULL, -- minutites
    hind DECIMAL(8,2) NOT NULL,
    kategooria VARCHAR(50) NOT NULL,
    aktiivne BOOLEAN DEFAULT TRUE,
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_kategooria (kategooria)
);

-- Töökohtade tabel
CREATE TABLE tookohad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nimi VARCHAR(50) NOT NULL,
    kirjeldus VARCHAR(200),
    aktiivne BOOLEAN DEFAULT TRUE,
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Broneeringute tabel
CREATE TABLE broneeringud (
    id INT PRIMARY KEY AUTO_INCREMENT,
    klient_id INT NOT NULL,
    teenus_id INT NOT NULL,
    tookoht_id INT NOT NULL,
    kuupaev DATE NOT NULL,
    algus_aeg TIME NOT NULL,
    lopp_aeg TIME NOT NULL,
    staatus ENUM('kinnitatud', 'tyhistatud', 'valmis') DEFAULT 'kinnitatud',
    markused TEXT,
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    muudetud TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (klient_id) REFERENCES kliendid(id) ON DELETE CASCADE,
    FOREIGN KEY (teenus_id) REFERENCES teenused(id) ON DELETE CASCADE,
    FOREIGN KEY (tookoht_id) REFERENCES tookohad(id) ON DELETE CASCADE,
    INDEX idx_kuupaev (kuupaev),
    INDEX idx_klient (klient_id),
    INDEX idx_tookoht_aeg (tookoht_id, kuupaev, algus_aeg)
);

-- Sessioonidetabel
CREATE TABLE sessioonid (
    id VARCHAR(128) PRIMARY KEY,
    kasutaja_id INT NOT NULL,
    kasutaja_tyyp ENUM('klient', 'toottaja') NOT NULL,
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    kehtib_kuni TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 4 HOUR),
    INDEX idx_kasutaja (kasutaja_id, kasutaja_tyyp),
    INDEX idx_kehtivus (kehtib_kuni)
);

-- Algandmete sisestamine

-- Töökohad
INSERT INTO tookohad (nimi, kirjeldus) VALUES
('Töökoht 1', 'Peamine mehhaanikatöökoht'),
('Töökoht 2', 'Diagnostika ja elektroonikatöökoht'),
('Töökoht 3', 'Keretööde töökoht'),
('Töökoht 4', 'Värvitööde töökoht');

-- Teenused
INSERT INTO teenused (nimi, kirjeldus, kestus, hind, kategooria) VALUES
('Õlivahetus', 'Mootoriõli ja filtri vahetus', 30, 45.00, 'Hooldus'),
('Tehnokontroll', 'Sõiduki tehnokontrolli ettevalmistus', 60, 80.00, 'Kontroll'),
('Pidurite kontroll', 'Piduriklotside ja -ketaste kontroll', 45, 65.00, 'Ohutus'),
('Diagnostika', 'Arvuti diagnostika ja vigade tuvastamine', 90, 120.00, 'Diagnostika'),
('Rehvivahetus', 'Hooajaliste rehvide vahetus', 20, 25.00, 'Hooldus'),
('Kliimaseadme hooldus', 'Kliimaseadme kontroll ja täitmine', 60, 85.00, 'Hooldus'),
('Keretööd', 'Väiksemate keretööde teostamine', 180, 200.00, 'Remont'),
('Elektritööd', 'Elektrisüsteemi remont ja paigaldus', 120, 150.00, 'Elekter');

-- Admin kasutaja (parool: admin123)
INSERT INTO toottajad (eesnimi, perekonnanimi, email, parool, roll) VALUES
('Admin', 'Kasutaja', 'admin@autoremondi.ee', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Näidis klient (parool: klient123)
INSERT INTO kliendid (eesnimi, perekonnanimi, isikukood, email, parool) VALUES
('Mart', 'Tamm', '38001013711', 'mart.tamm@email.ee', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');