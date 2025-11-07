<div id="login-demo-content" class="text-[#F8F8F8] text-center">
    <!-- STEP 1 -->
    <div class="step" data-step="1">
        <h2 class="text-lg font-semibold mb-2 text-[#FCA311]">Langkah 1: Input Password</h2>
        <p class="text-sm mb-4">Masukkan password yang ingin dienkripsi menggunakan algoritma <strong>Scrypt</strong>.</p>

        <input
            type="password"
            id="userPassword"
            placeholder="Masukkan password..."
            class="w-full px-3 py-2 mb-4 rounded-md border border-black text-[#1E1E24]"
        />

        <button
            id="encryptBtn"
            class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md border border-black font-medium hover:bg-[#3295e8] transition"
        >
            Enkripsi
        </button>
    </div>

    <!-- STEP 2 -->
    <div class="step hidden" data-step="2">
        <h2 class="text-lg font-semibold mb-2 text-[#FCA311]">Langkah 2: Proses Enkripsi</h2>
        <p class="text-sm mb-4">Password Anda sedang dienkripsi menggunakan parameter Scrypt.</p>

        <pre
            id="encryptOutput"
            class="bg-[#1E1E24] text-[#F8F8F8] p-3 rounded-md overflow-auto text-sm text-left"
        ></pre>

        <button
            id="nextStep"
            class="mt-4 bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md border border-black font-medium hover:bg-[#3295e8] transition"
        >
            Lanjutkan
        </button>
    </div>

    <!-- STEP 3 -->
    <div class="step hidden" data-step="3">
        <h2 class="text-lg font-semibold mb-2 text-[#FCA311]">Langkah 3: Verifikasi Password</h2>
        <p class="text-sm mb-4">
            Simulasikan proses login dengan membandingkan input pengguna dan password awal.
        </p>

        <input
            type="password"
            id="verifyPassword"
            placeholder="Masukkan ulang password..."
            class="w-full px-3 py-2 mb-4 rounded-md border border-black text-[#1E1E24]"
        />

        <button
            id="verifyBtn"
            class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md border border-black font-medium hover:bg-[#3295e8] transition"
        >
            Verifikasi
        </button>

        <p id="verifyResult" class="mt-3 text-sm font-semibold"></p>
    </div>

    <!-- STEP 4 -->
    <div class="step hidden" data-step="4">
        <h2 class="text-lg font-semibold mb-2 text-[#FCA311]">Penjelasan Algoritma Scrypt</h2>
        <p class="text-sm leading-relaxed text-left">
            <strong>Scrypt</strong> adalah algoritma derivasi kunci yang dirancang untuk mempersulit serangan brute-force
            dengan menambah kebutuhan memori. <br /><br />
            Rumus dasar:
            <code>DK = scrypt(P, S, N, r, p, dkLen)</code><br /><br />
            Di mana:
            <ul class="list-disc list-inside text-left ml-4">
                <li><strong>P</strong> = Password</li>
                <li><strong>S</strong> = Salt</li>
                <li><strong>N, r, p</strong> = Parameter cost dan paralelisme</li>
                <li><strong>dkLen</strong> = Panjang output kunci</li>
            </ul>
            Scrypt digunakan di banyak sistem modern karena keamanan dan efisiensinya terhadap serangan hardware GPU/ASIC.
        </p>

        <button
            id="closeDemo"
            class="mt-4 bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md border border-black font-medium hover:bg-[#3295e8] transition"
        >
            Selesai
        </button>
    </div>
</div>
