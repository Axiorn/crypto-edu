<div id="file-demo-card" class="text-center text-[#F8F8F8]">
    <h2 id="fileDemoTitle" class="text-xl font-bold mb-4 text-[#FCA311]">Enkripsi File</h2>

    <p id="fileDemoHint" class="text-sm text-gray-300 mb-4">
        Unggah file asli (belum terenkripsi), lalu klik tombol untuk mengenkripsi dan mengunduh hasilnya.
    </p>


    <input type="file" id="fileInput" class="mb-4 mx-auto block text-[#1E1E24]" />

    <button id="fileEncryptBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-2">
        Enkripsi & Unduh
    </button>

    <button id="fileDecryptBtn" class="bg-green-500 text-white px-4 py-2 rounded-md mb-2 hidden">
        Dekripsi File
    </button>

    <button id="fileExplainBtn" class="bg-purple-500 text-white px-4 py-2 rounded-md mb-2 hidden">
        Penjelasan Algoritma
    </button>

    <div id="fileOutput" class="mt-4 text-sm"></div>

    <div id="fileExplainCard" class="mt-6 text-left hidden max-w-xl mx-auto">
        <p class="text-sm leading-relaxed">
            File dienkripsi menggunakan kombinasi <strong>AES-GCM</strong> dan <strong>XOR keystream</strong>. XOR digunakan untuk menyamarkan isi file sebelum dienkripsi, dan AES-GCM memberikan keamanan autentikasi serta integritas. Proses dekripsi membalik urutan ini untuk mengembalikan isi asli file.
        </p>
    </div>


</div>
