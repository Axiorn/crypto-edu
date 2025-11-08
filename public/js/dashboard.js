document.addEventListener("DOMContentLoaded", () => {
    const demoButtons = document.querySelectorAll("[data-demo]");
    const demoContainer = document.getElementById("demo-container");
    const demoCard = document.getElementById("demo-card");

    demoButtons.forEach(btn => {
        btn.addEventListener("click", async () => {
            const demoType = btn.getAttribute("data-demo");
            try {
                const response = await fetch(`/crypto-edu/public/Dashboard/demo/${demoType}`);
                const content = await response.text();
                demoCard.innerHTML = content;
                demoContainer.classList.remove("hidden");
                demoContainer.classList.add("flex");
                setTimeout(() => {
                switch (demoType) {
                    case "login":
                        setupLoginDemo();
                        break;
                    case "database":
                        setupDatabaseDemo();
                        break;
                    case "superenkripsi":
                        setupSuperEnkripsiDemo();
                        break;
                    case "file":
                        setupFileDemo();
                        break;
                    case "steganografi":
                        setupStegDemo();
                        break;
                    default:
                        console.warn("Demo type tidak dikenali:", demoType);
                }
            }, 50);

            } catch (err) {
                console.error("Gagal memuat konten demo:", err);
                alert("Gagal memuat konten demo!");
            }
        });
    });

    demoContainer.addEventListener("click", (e) => {
        if (e.target === demoContainer) {
            demoContainer.classList.add("hidden");
            demoContainer.classList.remove("flex");
        }
    });
});

function setupLoginDemo() {
    const steps = document.querySelectorAll("#login-demo-content .step");
    if (!steps.length) return;

    const showStep = (n) => steps.forEach((s, i) => s.classList.toggle("hidden", i !== n - 1));

    document.getElementById("encryptBtn").onclick = async () => {
        const password = document.getElementById("userPassword").value;
        if (!password) return alert("Masukkan password terlebih dahulu!");

        const output = document.getElementById("encryptOutput");
        output.textContent = "⏳ Sedang memproses hashing dengan Scrypt...";

        try {
            const res = await fetch("/crypto-edu/public/DemoLogin/handle", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `action=encrypt&password=${encodeURIComponent(password)}`
            });
            const data = await res.json();

            if (data.hash) {
                output.textContent = `🔐 Hash (Scrypt): ${data.hash}`;
                showStep(2);
            } else {
                output.textContent = "❌ Gagal memproses hashing.";
            }
        } catch (err) {
            console.error("Error hashing:", err);
            output.textContent = "❌ Terjadi kesalahan saat hashing.";
        }
    };

    document.getElementById("nextStep").onclick = () => showStep(3);

    document.getElementById("verifyBtn").onclick = async () => {
    const input = document.getElementById("verifyPassword").value;

    try {
        const res = await fetch("/crypto-edu/public/DemoLogin/handle", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `action=verify&verify=${encodeURIComponent(input)}`
        });
        const data = await res.json();

        const resultEl = document.getElementById("verifyResult");
        resultEl.classList.remove("text-green-400", "text-red-400");

        if (data.verified === true) {
            resultEl.textContent = "✅ Password cocok! Login berhasil.";
            resultEl.classList.add("text-green-400");
            showStep(4); // hanya lanjut jika verifikasi berhasil
        } else {
            resultEl.textContent = "❌ Password tidak cocok.";
            resultEl.classList.add("text-red-400");
            // tidak lanjut ke step 4
        }
    } catch (err) {
        console.error("Error verifikasi:", err);
        alert("Gagal melakukan verifikasi.");
    }
};


    document.addEventListener("click", (e) => {
        if (e.target.id === "closeDemo") {
            document.getElementById("demo-container").classList.add("hidden");
        }
    });

    showStep(1);
}

function setupSuperEnkripsiDemo() {
    const input = document.getElementById("superInput");
    const output = document.getElementById("superOutput");

    document.getElementById("superEncryptBtn").onclick = async () => {
        const text = input.value;
        if (!text) return alert("Masukkan teks terlebih dahulu!");

        output.textContent = "⏳ Mengenkripsi...";
        try {
            const res = await fetch("/crypto-edu/public/SuperEnc/handle", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `action=encrypt&text=${encodeURIComponent(text)}`
            });
            const data = await res.json();
            if (data.salsa) {
                output.textContent = `🔐 Enkripsi (Salsa20): ${data.salsa}`;
            } else {
                output.textContent = `❌ ${data.error || "Gagal mengenkripsi."}`;
            }
        } catch (err) {
            console.error("Error:", err);
            output.textContent = "❌ Gagal mengenkripsi.";
        }
    };

    document.getElementById("superDecryptBtn").onclick = async () => {
        const cipher = prompt("Masukkan teks terenkripsi (Salsa20):");
        if (!cipher) return;

        output.textContent = "⏳ Mendekripsi...";
        try {
            const res = await fetch("/crypto-edu/public/SuperEnc/handle", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `action=decrypt&cipher=${encodeURIComponent(cipher)}`
            });
            const data = await res.json();
            if (data.plain) {
                output.textContent = `🔓 Plaintext: ${data.plain}`;
            } else {
                output.textContent = `❌ ${data.error || "Gagal mendekripsi."}`;
            }
        } catch (err) {
            console.error("Error:", err);
            output.textContent = "❌ Gagal mendekripsi.";
        }
    };
}

function setupFileDemo() {
    const input = document.getElementById("fileInput");
    const output = document.getElementById("fileOutput");
    const title = document.getElementById("fileDemoTitle");
    const encryptBtn = document.getElementById("fileEncryptBtn");
    const decryptBtn = document.getElementById("fileDecryptBtn");
    const explainBtn = document.getElementById("fileExplainBtn");
    const explainCard = document.getElementById("fileExplainCard");
    const hint = document.getElementById("fileDemoHint");


    encryptBtn.onclick = async () => {
        const file = input.files[0];
        if (!file) return alert("Pilih file terlebih dahulu!");

        output.textContent = "⏳ Mengenkripsi...";
        const formData = new FormData();
        formData.append("file", file);

        const res = await fetch("/crypto-edu/public/FileEnc/handle", {
            method: "POST",
            body: formData
        });
        const data = await res.json();
        if (data.encoded) {
            output.innerHTML = `
                ✅ File terenkripsi:<br>
                <a href="/crypto-edu/public/FileEnc/download/${data.encoded}" class="text-blue-400 underline">
                    Unduh ${data.filename}
                </a>
            `;
            title.textContent = "Dekripsi File";
            hint.textContent = "Unggah file yang telah terenkripsi tadi, lalu klik untuk mendekripsi dan mengunduh hasilnya.";
            encryptBtn.classList.add("hidden");
            decryptBtn.classList.remove("hidden");
        } else {
            output.textContent = `❌ ${data.error || "Gagal mengenkripsi file."}`;
        }
    };

    decryptBtn.onclick = async () => {
        const file = input.files[0];
        if (!file) return alert("Pilih file terenkripsi terlebih dahulu!");

        output.textContent = "⏳ Mendekripsi...";
        const formData = new FormData();
        formData.append("file", file);

        const res = await fetch("/crypto-edu/public/FileEnc/decrypt", {
            method: "POST",
            body: formData
        });
        const data = await res.json();
        if (data.encoded) {
            output.innerHTML = `
                ✅ File hasil dekripsi:<br>
                <a href="/crypto-edu/public/FileEnc/download/${data.encoded}" class="text-green-400 underline">
                    Unduh ${data.filename}
                </a>
            `;
            decryptBtn.classList.add("hidden");
            explainBtn.classList.remove("hidden");
        } else {
            output.textContent = `❌ ${data.error || "Gagal mendekripsi file."}`;
        }
    };

    explainBtn.onclick = () => {
        title.textContent = "Penjelasan Algoritma";
        hint.textContent = ""; // Kosongkan petunjuk
        explainCard.classList.remove("hidden");

        // Sembunyikan elemen lain
        explainBtn.classList.add("hidden");
        decryptBtn.classList.add("hidden");
        input.classList.add("hidden");
        output.innerHTML = ""; // Hapus link download
    };

}

function setupStegDemo() {
    const title = document.getElementById("stegTitle");
    const hint = document.getElementById("stegHint");
    const imageInput = document.getElementById("stegImageInput");
    const messageInput = document.getElementById("stegMessageInput");
    const embedBtn = document.getElementById("stegEmbedBtn");
    const extractBtn = document.getElementById("stegExtractBtn");
    const explainBtn = document.getElementById("stegExplainBtn");
    const output = document.getElementById("stegOutput");
    const explainCard = document.getElementById("stegExplainCard");

    embedBtn.onclick = async () => {
        const file = imageInput.files[0];
        const message = messageInput.value.trim();
        if (!file || !message) return alert("Gambar dan pesan harus diisi!");

        output.textContent = "⏳ Menyisipkan pesan...";
        const formData = new FormData();
        formData.append("image", file);
        formData.append("message", message);

        const res = await fetch("/crypto-edu/public/Steg/embed", {
            method: "POST",
            body: formData
        });
        const data = await res.json();
        if (data.encoded) {
            output.innerHTML = `
                ✅ Gambar berhasil disisipi:<br>
                <a href="/crypto-edu/public/Steg/download/${data.encoded}" class="text-blue-400 underline">
                    Unduh ${data.filename}
                </a>
            `;
            title.textContent = "Steganografi: Dekripsi Gambar";
            hint.textContent = "Unggah gambar yang telah disisipi untuk mengekstrak pesan.";
            embedBtn.classList.add("hidden");
            messageInput.classList.add("hidden");
            extractBtn.classList.remove("hidden");
        } else {
            output.textContent = `❌ ${data.error || "Gagal menyisipkan pesan."}`;
        }
    };

    extractBtn.onclick = async () => {
        const file = imageInput.files[0];
        if (!file) return alert("Pilih gambar yang telah disisipi!");

        output.textContent = "⏳ Mendekripsi gambar...";
        const formData = new FormData();
        formData.append("image", file);

        const res = await fetch("/crypto-edu/public/Steg/extract", {
            method: "POST",
            body: formData
        });
        const data = await res.json();
        if (data.encoded) {
            output.innerHTML = `
                ✅ Pesan berhasil diekstrak:<br>
                <a href="/crypto-edu/public/Steg/download/${data.encoded}" class="text-green-400 underline">
                    Unduh gambar dengan pesan overlay
                </a>

            `;
            title.textContent = "Penjelasan Algoritma";
            hint.textContent = "";
            extractBtn.classList.add("hidden");
            explainBtn.classList.remove("hidden");
        } else {
            output.textContent = `❌ ${data.error || "Gagal mengekstrak pesan."}`;
        }
    };

    explainBtn.onclick = () => {
        explainCard.classList.remove("hidden");
        explainBtn.classList.add("hidden");
        imageInput.classList.add("hidden");
        output.innerHTML = "";
    };
}

function setupDatabaseDemo() {
    const passwordBtn = document.getElementById("dbPasswordBtn");
    const textBtn = document.getElementById("dbTextBtn");
    const inputSection = document.getElementById("dbInputSection");
    const inputField = document.getElementById("dbInputField");
    const encryptBtn = document.getElementById("dbEncryptBtn");
    const output = document.getElementById("dbOutput");

    const inputCard = document.getElementById("dbInputCard");
    const explainCard = document.getElementById("dbExplainCard");
    const backToPassword = document.getElementById("backToPassword");
    const backToText = document.getElementById("backToText");

    let mode = null;

    passwordBtn.onclick = () => {
        mode = "password";
        inputSection.classList.remove("hidden");
        inputField.placeholder = "Masukkan password...";
        output.innerHTML = "";
    };

    textBtn.onclick = () => {
        mode = "text";
        inputSection.classList.remove("hidden");
        inputField.placeholder = "Masukkan teks...";
        output.innerHTML = "";
    };

    encryptBtn.onclick = async () => {
        const value = inputField.value.trim();
        if (!value) return alert("Input tidak boleh kosong!");

        output.textContent = "⏳ Memproses enkripsi...";
        const formData = new FormData();
        formData.append(mode, value);

        try {
            const res = await fetch(`/crypto-edu/public/Database/storeDemo${mode === "password" ? "Password" : "Text"}`, {
                method: "POST",
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                inputCard.classList.add("hidden");
                explainCard.classList.remove("hidden");
            } else {
                output.textContent = `❌ ${data.error || "Gagal menyimpan data."}`;
            }
        } catch (err) {
            output.textContent = "❌ Gagal menghubungi server.";
        }
    };

    backToPassword.onclick = () => {
        mode = "password";
        inputField.value = "";
        inputField.placeholder = "Masukkan password...";
        inputSection.classList.remove("hidden");
        explainCard.classList.add("hidden");
        inputCard.classList.remove("hidden");
        output.innerHTML = "";
    };

    backToText.onclick = () => {
        mode = "text";
        inputField.value = "";
        inputField.placeholder = "Masukkan teks...";
        inputSection.classList.remove("hidden");
        explainCard.classList.add("hidden");
        inputCard.classList.remove("hidden");
        output.innerHTML = "";
    };
}






