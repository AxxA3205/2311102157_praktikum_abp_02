-- Jalankan file ini di phpMyAdmin atau MySQL CLI

CREATE DATABASE IF NOT EXISTS quiz_db;
USE quiz_db;

CREATE TABLE IF NOT EXISTS questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question_text TEXT NOT NULL,
  option_a VARCHAR(255) NOT NULL,
  option_b VARCHAR(255) NOT NULL,
  option_c VARCHAR(255) NOT NULL,
  option_d VARCHAR(255) NOT NULL,
  correct_answer ENUM('A','B','C','D') NOT NULL,
  difficulty ENUM('easy','medium','hard') NOT NULL DEFAULT 'medium',
  prize_level INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS participants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS scores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  participant_id INT NOT NULL,
  score INT DEFAULT 0,
  total_questions INT DEFAULT 0,
  correct_answers INT DEFAULT 0,
  played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (participant_id) REFERENCES participants(id) ON DELETE CASCADE
);

-- Sample data soal
INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, prize_level) VALUES
('Ibu kota Indonesia adalah?', 'Surabaya', 'Bandung', 'Jakarta', 'Medan', 'C', 'easy', 1),
('Berapa hasil dari 7 x 8?', '54', '56', '58', '60', 'B', 'easy', 2),
('Siapa penemu telepon?', 'Thomas Edison', 'Nikola Tesla', 'Alexander Graham Bell', 'Albert Einstein', 'C', 'medium', 3),
('Planet terbesar di tata surya adalah?', 'Saturnus', 'Jupiter', 'Uranus', 'Neptunus', 'B', 'medium', 4),
('Apa simbol kimia untuk emas?', 'Ag', 'Fe', 'Au', 'Cu', 'C', 'hard', 5),
('Siapa penulis novel "Harry Potter"?', 'J.R.R. Tolkien', 'J.K. Rowling', 'C.S. Lewis', 'George R.R. Martin', 'B', 'easy', 1),
('Berapa jumlah sisi pada sebuah oktagon?', '6', '7', '8', '9', 'C', 'medium', 3),
('Gunung tertinggi di dunia adalah?', 'K2', 'Kangchenjunga', 'Everest', 'Lhotse', 'C', 'medium', 4),
('Apa nama planet merah?', 'Venus', 'Mars', 'Jupiter', 'Merkurius', 'B', 'easy', 2),
('Berapa kecepatan cahaya (km/s)?', '200.000', '250.000', '300.000', '350.000', 'C', 'hard', 5);

-- Sample data peserta
INSERT INTO participants (name, email) VALUES
('Budi Santoso', 'budi@example.com'),
('Siti Rahayu', 'siti@example.com'),
('Ahmad Fauzi', 'ahmad@example.com');
