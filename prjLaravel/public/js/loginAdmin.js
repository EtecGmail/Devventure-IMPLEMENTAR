document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("login-form");
    const submitBtn = document.getElementById("submit-btn");
  
    form.addEventListener("submit", async function (e) {
      e.preventDefault();
  
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
  
      submitBtn.disabled = true;
      submitBtn.textContent = "Processando...";
  
      try {
        // Simula login (substitua por chamada real à API)
        await fakeLogin(email, password);
        alert("Login bem-sucedido! Redirecionando...");
        window.location.href = "/admin/dashboard"; // Redirecione como quiser
      } catch (error) {
        alert(error.message || "Credenciais inválidas");
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = "Entrar";
      }
    });
  
    function fakeLogin(email, password) {
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          // Simulação simples de login com credenciais hardcoded
          if (email === "admin@example.com" && password === "admin123") {
            resolve();
          } else {
            reject(new Error("Credenciais inválidas"));
          }
        }, 1000);
      });
    }
  });
  