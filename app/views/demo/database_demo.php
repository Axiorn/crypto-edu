<div id="db-demo-container" class="text-[#F8F8F8] text-center">

    <!-- Step 1: Input Card -->
    <div id="dbInputCard">
        <h2 class="text-xl font-bold mb-4 text-[#FCA311]">Demo Enkripsi ke Database</h2>
        <p class="text-sm text-gray-300 mb-4">Pilih jenis input yang ingin dienkripsi dan disimpan ke database demo.</p>

        <div class="flex justify-center gap-4 mb-6">
            <button id="dbPasswordBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md">Enkripsi Password</button>
            <button id="dbTextBtn" class="bg-green-600 text-white px-4 py-2 rounded-md">Enkripsi Teks</button>
        </div>

        <div id="dbInputSection" class="hidden">
            <textarea id="dbInputField" rows="3" placeholder="Masukkan data..." 
                class="w-3/4 mx-auto p-2 mb-4 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-[#3da9fc] text-black"></textarea>
            <button id="dbEncryptBtn" class="bg-purple-600 text-white px-4 py-2 rounded-md">Enkripsi & Simpan</button>
        </div>

        <div id="dbOutput" class="mt-4 text-sm"></div>
    </div>

    <!-- Step 2: Explanation Card -->
    <div id="dbExplainCard" class="hidden text-left max-w-xl mx-auto">
        <h3 class="text-lg font-semibold text-[#FCA311] mb-2">Penjelasan Algoritma ChaCha20</h3>
        <p class="text-sm leading-relaxed mb-4">
            ChaCha20 adalah algoritma stream cipher yang cepat dan aman, digunakan untuk mengenkripsi data secara simetris. Algoritma ini bekerja dengan menghasilkan keystream dari kunci dan nonce, lalu melakukan XOR dengan data asli. Dalam demo ini, hasil enkripsi password atau teks akan dienkripsi lagi dengan ChaCha20 sebelum disimpan ke database.
        </p>

        <div class="flex flex-col items-center gap-4 mt-4">
            <div class="flex justify-center gap-4">
                <button id="backToPassword" class="bg-blue-600 text-white px-4 py-2 rounded-md">Enkripsi Password</button>
                <button id="backToText" class="bg-green-600 text-white px-4 py-2 rounded-md">Enkripsi Teks</button>
            </div>

            <a href="<?= BASEURL ?>/Database" class="bg-[#FCA311] text-black px-4 py-2 rounded-md">
                Lihat Isi Database Demo
            </a>
        </div>
    </div>
</div>
