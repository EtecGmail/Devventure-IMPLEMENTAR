const can = document.getElementById("canvas");
const ctx = can.getContext("2d");

can.width = window.innerWidth;
can.height = window.innerHeight;
can.style.background = "black";

let particles = [];

function Clear() {
  ctx.fillStyle = "rgba(0, 0, 0, 0.07)";
  ctx.fillRect(0, 0, can.width, can.height);
}

function Particle(x, y, speed, color) {
  this.x = x;
  this.y = y;
  this.speed = speed;
  this.color = color;

  this.update = function () {
    ctx.strokeStyle = this.color;
    ctx.lineWidth = 1;
    ctx.lineCap = "round";

    ctx.beginPath();
    ctx.moveTo(this.x, this.y);

    this.x += this.speed.x;
    this.y += this.speed.y;

    ctx.lineTo(this.x, this.y);
    ctx.stroke();

    const angle = Math.atan2(this.speed.y, this.speed.x);
    const magnitude = Math.sqrt(this.speed.x ** 2 + this.speed.y ** 2);
    const options = [angle + Math.PI / 4, angle - Math.PI / 4];
    const choice = Math.floor(Math.random() * options.length);

    // Pequena chance de mudar direção
    if (Math.random() < 0.05) {
      this.speed.x = Math.cos(options[choice]) * magnitude;
      this.speed.y = Math.sin(options[choice]) * magnitude;
    }
  };
}

// ⚙️ Parâmetros
const speed = 2.5;
const period = 4500;

function pulse() {
  setTimeout(pulse, period);

  // Paleta roxa e azul (240 a 300 no HSL)
  const hue = Math.random() * (300 - 240) + 240;

  // 🔹 Vários pontos de emissão
  const origins = [
    { x: can.width / 2, y: can.height / 2 },  // centro
    { x: 0, y: 0 },                           // canto superior-esquerda
    { x: can.width, y: 0 },                   // canto superior-direita
    { x: 0, y: can.height },                  // canto inferior-esquerda
    { x: can.width, y: can.height }           // canto inferior-direita
  ];

  for (let origin of origins) {
    for (let i = 0; i < 56; i++) {
      const angle = (i / 8) * 2 * Math.PI;
      particles.push(
        new Particle(
          origin.x,
          origin.y,
          {
            x: Math.cos(angle) * speed,
            y: Math.sin(angle) * speed,
          },
          `hsl(${hue}, 100%, 50%)`
        )
      );
    }
  }
}

function animate() {
  requestAnimationFrame(animate);
  Clear();

  for (let i = 0; i < particles.length; i++) {
    particles[i].update();

    // Remove partículas fora da tela
    if (
      particles[i].x < 0 ||
      particles[i].x > can.width ||
      particles[i].y < 0 ||
      particles[i].y > can.height
    ) {
      particles.splice(i, 1);
      i--;
    }
  }
}

pulse();
animate();

const reveals = document.querySelectorAll('.reveal');

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('active');
    }
  });
}, { threshold: 0.1 });

reveals.forEach(el => observer.observe(el));



