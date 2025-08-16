// Dapatkan elemen-elemen dari HTML
const recordButton = document.getElementById("recordButton");
const stopButton = document.getElementById("stopButton");
const audioPlayback = document.getElementById("audioPlayback");
const statusDisplay = document.getElementById("status");
const audioForm = document.getElementById("form-asesmen");

// Variabel untuk menyimpan objek MediaRecorder dan potongan data audio
let mediaRecorder;
let audioChunks = [];
let recordedAudioBlob = null; // Variabel untuk menyimpan hasil rekaman (Blob)

// --- Kode untuk event tombol rekam dan berhenti tetap SAMA dari sebelumnya ---
recordButton.addEventListener("click", async () => {
  // ... (kode dari jawaban sebelumnya tidak berubah)
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    recordedAudioBlob = null; // Reset blob saat mulai merekam baru
    mediaRecorder = new MediaRecorder(stream);
    mediaRecorder.ondataavailable = (event) => {
      audioChunks.push(event.data);
    };
    mediaRecorder.onstop = () => {
      recordedAudioBlob = new Blob(audioChunks, { type: "audio/wav" });
      const audioUrl = URL.createObjectURL(recordedAudioBlob);
      audioPlayback.src = audioUrl;
      audioChunks = [];
    };
    mediaRecorder.start();
    statusDisplay.textContent = "Status: Merekam...";
    recordButton.disabled = true;
    stopButton.disabled = false;
  } catch (error) {
    console.error("Error mengakses mikrofon:", error);
    statusDisplay.textContent = "Error: Izin mikrofon ditolak.";
  }
});

stopButton.addEventListener("click", () => {
  // ... (kode dari jawaban sebelumnya tidak berubah)
  mediaRecorder.stop();
  statusDisplay.textContent = "Status: Rekaman selesai.";
  recordButton.disabled = false;
  stopButton.disabled = true;
});

// --- BAGIAN BARU: Menangani Pengiriman Form ---
audioForm.addEventListener("submit", async (event) => {
  // 1. Mencegah form mengirim halaman secara default
  event.preventDefault();

  // Cek apakah sudah ada rekaman suara
  if (!recordedAudioBlob) {
    alert("Harap rekam audio terlebih dahulu sebelum mengirim!");
    return;
  }

  // 2. Membuat objek FormData
  const formData = new FormData();

  // 3. Menambahkan data ke FormData
  // Menambahkan input teks (nama)
  const nama = document.getElementById("nama").value;
  formData.append("nama", nama);

  // Menambahkan file audio dari Blob
  // Argumen ketiga adalah nama file yang akan diterima di server
  formData.append("rekaman-suara", recordedAudioBlob, "pesan-suara.wav");

  // Tampilkan status pengiriman
  statusDisplay.textContent = "Status: Mengirim data...";

  // 4. Mengirim data ke server menggunakan Fetch API
  try {
    const response = await fetch("/url-tujuan-server", {
      // <-- GANTI DENGAN URL SERVER ANDA
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      statusDisplay.textContent = "Status: Data berhasil terkirim!";
      //   alert("Terima kasih! Pesan suara Anda telah terkirim.");
      audioForm.reset(); // Mengosongkan form
      audioPlayback.src = "";
    } else {
      throw new Error("Gagal mengirim data.");
    }
  } catch (error) {
    console.error("Error saat mengirim form:", error);
    statusDisplay.textContent = "Status: Gagal mengirim data. Cek konsol.";
    alert("Terjadi kesalahan saat mengirim data.");
  }
});
