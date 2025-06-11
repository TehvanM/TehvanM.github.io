-- Andmebaasi loomine
CREATE DATABASE IF NOT EXISTS autoremontiks;
USE autoremontiks;

-- Kasutajate tabel
CREATE TABLE kasutajad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    parool VARCHAR(255) NOT NULL,
    roll ENUM('klient', 'tootaja') DEFAULT 'klient',
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Klientide tabel
CREATE TABLE kliendid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eesnimi VARCHAR(100) NOT NULL,
    perenimi VARCHAR(100) NOT NULL,
    isikukood VARCHAR(11) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    kasutaja_id INT,
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kasutaja_id) REFERENCES kasutajad(id)
);

-- Teenuste tabel
CREATE TABLE teenused (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nimi VARCHAR(255) NOT NULL,
    kirjeldus TEXT,
    kestus_tunnid INT NOT NULL,
    hind DECIMAL(10,2) NOT NULL,
    aktiivne BOOLEAN DEFAULT TRUE,
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Broneeringute tabel
CREATE TABLE broneeringud (
    id INT AUTO_INCREMENT PRIMARY KEY,
    klient_id INT NOT NULL,
    teenus_id INT NOT NULL,
    kuupaev DATE NOT NULL,
    kellaaeg TIME NOT NULL,
    tookoht VARCHAR(50) NOT NULL,
    staatus ENUM('kinnitatud', 'tyhistatud') DEFAULT 'kinnitatud',
    loodud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (klient_id) REFERENCES kliendid(id),
    FOREIGN KEY (teenus_id) REFERENCES teenused(id)
);

-- Vaikimisi andmed
INSERT INTO kasutajad (email, parool, roll) VALUES 
('tootaja@autoremontiks.ee', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tootaja'),
('admin@autoremontiks.ee', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tootaja');

INSERT INTO teenused (nimi, kirjeldus, kestus_tunnid, hind) VALUES 
('Õlivahetus', 'Mootoriõli ja filtri vahetus', 1, 45.00),
('Diagnostika', 'Täielik auto diagnostika', 2, 80.00),
('Pidurite kontroll', 'Piduriklotside ja ketaste kontroll', 1, 35.00),
('Rehvivahetus', 'Suve/talverehvide vahetus', 1, 25.00);