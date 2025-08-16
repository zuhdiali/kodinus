// Membutuhkan (require) file database.js yang sudah kita buat
const db = require("./database.js");

// Menunggu hingga seluruh konten halaman dimuat
document.addEventListener("DOMContentLoaded", () => {
  const formAsesmenMembaca = document.getElementById("form-asesmen");
  const asesmen_id = document.getElementById("asesmen-id");
  const nama = document.getElementById("nama");
  const kelas = document.getElementById("kelas");
  const soal_1 = document.getElementById("soal-1");
  const soal_2 = document.getElementById("soal-2");
  const soal_3 = document.getElementById("soal-3");
  const clearBtn = document.getElementById("clear-btn");

  // Fungsi untuk merender/menampilkan semua produk ke dalam list
  function renderProducts() {
    db.getAllProducts((err, rows) => {
      if (err) {
        return console.error("Gagal mengambil produk:", err.message);
      }
      // Kosongkan list sebelum diisi ulang
      soal_3.innerHTML = "";
      rows.forEach((product) => {
        const item = document.createElement("div");
        item.className = "product-item";
        item.innerHTML = `
                    <span><strong>${
                      product.name
                    }</strong> - Rp ${product.price.toLocaleString(
          "id-ID"
        )}</span>
                    <div>
                        <button class="btn-edit" data-id="${
                          product.id
                        }" data-name="${product.name}" data-price="${
          product.price
        }">Edit</button>
                        <button class="btn-delete" data-id="${
                          product.id
                        }">Hapus</button>
                    </div>
                `;
        soal_3.appendChild(item);
      });
    });
  }

  // Event listener untuk form submit (menambah atau mengupdate produk)
  formAsesmenMembaca.addEventListener("submit", (event) => {
    event.preventDefault();
    const id = asesmen_id.value;
    const asesmen = {
      nama: nama.value,
      kelas: kelas.value,
      soal_1: soal_1.value,
      soal_2: soal_2.value,
      soal_3: soal_3.value,
    };

    if (id) {
      // Jika ada ID, berarti ini adalah operasi update
      asesmen.id = id;
      db.updateProduct(asesmen, function (err) {
        if (err) return console.error("Gagal update produk:", err.message);
        // resetForm();
        // renderProducts();
      });
    } else {
      // Jika tidak ada ID, ini operasi tambah
      db.addProduct(asesmen, function (err) {
        if (err) return console.error("Gagal menambah produk:", err.message);
        // resetForm();
        // renderProducts();
      });
    }
  });

  // Event listener untuk tombol di dalam list produk (edit dan hapus)
  // soal_3.addEventListener("click", (event) => {
  //   const target = event.target;
  //   const id = target.getAttribute("data-id");

  //   // Jika tombol Edit yang diklik
  //   if (target.classList.contains("btn-edit")) {
  //     nama.value = id;
  //     soal_1.value = target.getAttribute("data-name");
  //     soal_2.value = target.getAttribute("data-price");
  //     soal_1.focus(); // Fokuskan kursor ke input nama
  //   }

  //   // Jika tombol Hapus yang diklik
  //   if (target.classList.contains("btn-delete")) {
  //     if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
  //       db.deleteProduct(id, function (err) {
  //         if (err) return console.error("Gagal hapus produk:", err.message);
  //         renderProducts();
  //       });
  //     }
  //   }
  // });

  // Event listener untuk tombol Batal Edit
  clearBtn.addEventListener("click", resetForm);

  function resetForm() {
    formAsesmenMembaca.reset();
    nama.value = "";
  }

  // Panggil renderProducts() saat aplikasi pertama kali dimuat
  // renderProducts();
});
