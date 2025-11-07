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
                setupLoginDemo(); // jalankan setup jika ini demo login
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
