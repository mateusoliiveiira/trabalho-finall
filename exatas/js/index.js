const sky = document.getElementById("sky");

function randomPosition(max) {
    return Math.floor(Math.random() * max);
}

function createFoguete() {
    const foguete = document.createElement("div");
    foguete.classList.add("foguete");

    // Posicionar o foguete aleatoriamente na horizontal
    foguete.style.left = `${randomPosition(window.innerWidth)}px`;

    // Quando o foguete atinge o topo, ele "explode"
    foguete.addEventListener("animationend", function() {
        sky.removeChild(foguete);
        createExplosion(foguete.style.left, foguete.style.top);
    });

    sky.appendChild(foguete);

    // Remover foguete após a animação
    setTimeout(() => {
        sky.removeChild(foguete);
    }, 3000);
}

function createExplosion(x, y) {
    const explosao = document.createElement("div");
    explosao.classList.add("explosao");
    explosao.style.left = x;
    explosao.style.top = y;

    sky.appendChild(explosao);

    // Remover explosão após animação
    setTimeout(() => {
        sky.removeChild(explosao);
    }, 500);
}

// Gerar foguetes aleatoriamente a cada 500ms
setInterval(createFoguete, 500);
