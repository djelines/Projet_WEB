// Get references to HTML elements for the game area and displays
const gameArea = document.getElementById('game-area');
const scoreDisplay = document.getElementById('score');
const timerDisplay = document.getElementById('timer');
const missedDisplay = document.getElementById('missed');

// Initialize game variables
let score = 0;
let missed = 0;
let time = 0;
let gameInterval;
let timerInterval;

// Path to the image used for the bugs
const imageUrl = '/images/python.png';

// Starts the game: spawns bugs and starts the timer
function startGame() {
    gameInterval = setInterval(spawnBug, 800); // Create a bug every 800ms
    timerInterval = setInterval(updateTimer, 1000); // Update timer every second
}

// Creates and displays a bug in a random position
function spawnBug() {
    const bug = document.createElement('div');
    bug.classList.add('bug');

    // Set random size and position for the bug
    const size = Math.random() * 20 + 30;
    const x = Math.random() * (gameArea.offsetWidth - size);
    const y = Math.random() * (gameArea.offsetHeight - size);

    // Style the bug element
    Object.assign(bug.style, {
        width: `${size}px`,
        height: `${size}px`,
        position: 'absolute',
        top: `${y}px`,
        left: `${x}px`,
        backgroundImage: `url(${imageUrl})`,
        backgroundSize: 'contain',
        backgroundRepeat: 'no-repeat',
        cursor: 'pointer',
        transition: 'transform 0.1s',
        zIndex: 10
    });

    // When the user clicks the bug: increase score and remove it
    bug.addEventListener('click', () => {
        score++;
        scoreDisplay.textContent = "Score : " + score;
        bug.remove();
    });

    // Add the bug to the game area
    gameArea.appendChild(bug);

    // If not clicked within 1.5 seconds, consider it missed
    setTimeout(() => {
        if (bug.parentNode) {
            bug.remove();
            missed++;
            missedDisplay.textContent = "Missed : " + missed;

            // End the game if 5 bugs are missed
            if (missed >= 5) {
                endGame();
            }
        }
    }, 1500);
}

// Updates the game timer every second
function updateTimer() {
    time++;
    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    timerDisplay.textContent = `Time : ${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}

// Stops the game and displays the final score and time
function endGame() {
    clearInterval(gameInterval); // Stop spawning bugs
    clearInterval(timerInterval); // Stop the timer

    // Show final score and time
    document.getElementById('final-score').textContent = "Score : " + score;
    document.getElementById('final-time').textContent = timerDisplay.textContent;

    // Display the game over popup
    document.getElementById('game-over-popup').classList.remove('hidden');
}

// Launch the game as soon as the script loads
startGame();
