// Mengimpor modul sqlite3. Verbose() untuk pesan error yang lebih detail.
const sqlite3 = require("sqlite3").verbose();

// Membuat atau menyambungkan ke file database 'products.db'
const db = new sqlite3.Database("./kodinus.db", (err) => {
  if (err) {
    console.error("Error saat membuka database", err.message);
  } else {
    console.log("Terhubung ke database SQLite.");
    // Membuat tabel asesmen_membaca jika belum ada
    db.run(
      `CREATE TABLE IF NOT EXISTS asesmen_membaca (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        nama TEXT NOT NULL,
                        kelas INTEGER NOT NULL,
                        soal_1 TEXT NOT NULL,
                        soal_2 TEXT NOT NULL,
                        soal_3 TEXT NULL
                )`,
      (err) => {
        if (err) {
          console.error(
            "Error saat membuat tabel asesmen_membaca",
            err.message
          );
        }
      }
    );
    // Membuat tabel asesmen_menyimak jika belum ada
    db.run(
      `CREATE TABLE IF NOT EXISTS asesmen_menyimak (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        nama TEXT NOT NULL,
                        soal_1 TEXT NOT NULL,
                        soal_2 TEXT NOT NULL,
                        soal_3 TEXT NULL
                )`,
      (err) => {
        if (err) {
          console.error("Error saat membuat tabel products", err.message);
        }
      }
    );
    // Membuat tabel asesmen_berbicara jika belum ada
    db.run(
      `CREATE TABLE IF NOT EXISTS asesmen_berbicara (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        nama TEXT NOT NULL,
                        file TEXT NOT NULL,
                )`,
      (err) => {
        if (err) {
          console.error(
            "Error saat membuat tabel asesmen_berbicara",
            err.message
          );
        }
      }
    );
  }
});

// CRUD untuk tabel asesmen_membaca
exports.getAllAsesmenMembaca = (callback) => {
  db.all("SELECT * FROM asesmen_membaca ORDER BY nama", [], callback);
};

exports.addAsesmenMembaca = (data, callback) => {
  db.run(
    "INSERT INTO asesmen_membaca (nama, kelas, soal_1, soal_2, soal_3) VALUES (?, ?, ?, ?, ?)",
    [data.nama, data.kelas, data.soal_1, data.soal_2, data.soal_3],
    callback
  );
};

exports.updateAsesmenMembaca = (data, callback) => {
  db.run(
    "UPDATE asesmen_membaca SET nama = ?, kelas = ?, soal_1 = ?, soal_2 = ?, soal_3 = ? WHERE id = ?",
    [data.nama, data.kelas, data.soal_1, data.soal_2, data.soal_3, data.id],
    callback
  );
};

exports.deleteAsesmenMembaca = (id, callback) => {
  db.run("DELETE FROM asesmen_membaca WHERE id = ?", id, callback);
};

// CRUD untuk tabel asesmen_menyimak
exports.getAllAsesmenMenyimak = (callback) => {
  db.all("SELECT * FROM asesmen_menyimak ORDER BY nama", [], callback);
};

exports.addAsesmenMenyimak = (data, callback) => {
  db.run(
    "INSERT INTO asesmen_menyimak (nama, soal_1, soal_2, soal_3) VALUES (?, ?, ?, ?)",
    [data.nama, data.soal_1, data.soal_2, data.soal_3],
    callback
  );
};

exports.updateAsesmenMenyimak = (data, callback) => {
  db.run(
    "UPDATE asesmen_menyimak SET nama = ?, soal_1 = ?, soal_2 = ?, soal_3 = ? WHERE id = ?",
    [data.nama, data.soal_1, data.soal_2, data.soal_3, data.id],
    callback
  );
};

exports.deleteAsesmenMenyimak = (id, callback) => {
  db.run("DELETE FROM asesmen_menyimak WHERE id = ?", id, callback);
};

// CRUD untuk tabel asesmen_berbicara
exports.getAllAsesmenBerbicara = (callback) => {
  db.all("SELECT * FROM asesmen_berbicara ORDER BY nama", [], callback);
};

exports.addAsesmenBerbicara = (data, callback) => {
  db.run(
    "INSERT INTO asesmen_berbicara (nama, file) VALUES (?, ?)",
    [data.nama, data.file],
    callback
  );
};

exports.updateAsesmenBerbicara = (data, callback) => {
  db.run(
    "UPDATE asesmen_berbicara SET nama = ?, file = ? WHERE id = ?",
    [data.nama, data.file, data.id],
    callback
  );
};

exports.deleteAsesmenBerbicara = (id, callback) => {
  db.run("DELETE FROM asesmen_berbicara WHERE id = ?", id, callback);
};
