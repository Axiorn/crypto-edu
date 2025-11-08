<div id="steg-card" class="text-center">
    <h2 id="stegTitle" class="text-xl font-bold mb-4 text-[#FCA311]">Steganografi: Sisipkan Pesan</h2>
    <p id="stegHint" class="text-sm text-gray-300 mb-4">
        Unggah gambar (.jpg/.png) dan masukkan pesan yang ingin disisipkan.
    </p>

    <input type="file" id="stegImageInput" accept="image/png, image/jpeg" class="mb-4 mx-auto block text-white" />
    <textarea id="stegMessageInput" placeholder="Masukkan pesan..." rows="3"
        class="w-3/4 mx-auto p-2 mb-4 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-[#0f0e17] text-black"></textarea>

    <button id="stegEmbedBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-2">
        Sisipkan Pesan
    </button>

    <button id="stegExtractBtn" class="bg-green-600 text-white px-4 py-2 rounded-md mb-2 hidden">
        Dekripsikan Gambar
    </button>

    <button id="stegExplainBtn" class="bg-purple-500 text-white px-4 py-2 rounded-md mb-2 hidden">
        Penjelasan Algoritma
    </button>

    <div id="stegOutput" class="mt-4 text-sm"></div>

    <div id="stegExplainCard" class="mt-6 text-left hidden max-w-xl mx-auto">
        <h3 class="text-lg font-semibold text-[#FCA311] mb-2">Algoritma PVD dan Penerapan di Steganografi</h3>
        <p class="text-sm leading-relaxed">
            Algoritma <strong>PVD (Pixel Value Differencing)</strong> menyisipkan pesan ke dalam gambar dengan memanfaatkan perbedaan intensitas antar piksel. Pesan dikonversi ke biner dan disisipkan ke channel warna (misalnya merah) secara bertahap. Saat dekripsi, pesan diekstrak kembali dan ditampilkan sebagai overlay pada gambar. Teknik ini cocok untuk menyembunyikan informasi tanpa merusak tampilan visual gambar.
        </p>
    </div>
</div>
