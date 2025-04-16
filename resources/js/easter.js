const gameArea = document.getElementById('game-area');
const scoreDisplay = document.getElementById('score');
const timerDisplay = document.getElementById('timer');
const missedDisplay = document.getElementById('missed');
let score = 0;
let missed = 0;
let time = 0;
let gameInterval;
const imageUrl = '/images/python.png'; // URL directe à l'image dans le dossier public

function spawnBug() {
    const bug = document.createElement('div');
    bug.classList.add('bug');

    const size = Math.random() * 20 + 30; // 30px - 50px
    const x = Math.random() * (gameArea.offsetWidth - size);
    const y = Math.random() * (gameArea.offsetHeight - size);

    // Utilisation de l'URL directe
    Object.assign(bug.style, {
        width: `${size}px`,
        height: `${size}px`,
        position: 'absolute',
        top: `${y}px`,
        left: `${x}px`,
        backgroundImage: `url(${imageUrl})`, // Utilisation de l'URL directe
        backgroundSize: 'contain',
        backgroundRepeat: 'no-repeat',
        cursor: 'pointer',
        transition: 'transform 0.1s',
        zIndex: 10
    });

    bug.addEventListener('click', () => {
        score++;
        scoreDisplay.textContent = "Score : " + score;
        bug.remove();
    });

    gameArea.appendChild(bug);

    setTimeout(() => {
        if (bug.parentNode) {
            bug.remove();
            missed++; // Incrémentation des cibles ratées
            missedDisplay.textContent = "Manqué : " + missed;
        }
    }, 1500);
}

function updateTimer() {
    time++;
    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    timerDisplay.textContent = `Temps : ${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}

function startGame() {
    gameInterval = setInterval(spawnBug, 800); // Créer une cible toutes les 800ms
    setInterval(updateTimer, 1000); // Mettre à jour le chrono toutes les secondes
}

startGame();
