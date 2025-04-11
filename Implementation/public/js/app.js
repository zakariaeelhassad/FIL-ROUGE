
function createFootball() {
    const football = document.createElement('div');
    football.className = 'football';
    
    // Position initiale aléatoire
    const startX = Math.random() * window.innerWidth;
    const startY = -50; // Démarre au-dessus de l'écran
    
    football.style.left = `${startX}px`;
    football.style.top = `${startY}px`;
    
    // Paramètres de mouvement
    const speedX = (Math.random() - 0.5) * 5;
    const speedY = Math.random() * 3 + 2;
    const gravity = 0.1;
    const bounce = 0.7;
    
    let x = startX;
    let y = startY;
    let vx = speedX;
    let vy = speedY;
    
    // Durée de vie du ballon
    const lifespan = Math.random() * 5000 + 5000; // 5-10 secondes
    const container = document.getElementById('football-container');
    container.appendChild(football);
    
    let startTime = Date.now();
    
    function updatePosition() {
        // Appliquer la gravité
        vy += gravity;
        
        // Mettre à jour la position
        x += vx;
        y += vy;
        
        // Rebondir sur les bords
        if (x <= 0 || x + 50 >= window.innerWidth) {
            vx = -vx * 0.8;
            x = x <= 0 ? 0 : window.innerWidth - 50;
        }
        
        if (y + 50 >= window.innerHeight) {
            y = window.innerHeight - 50;
            vy = -vy * bounce;
            
            // Si le ballon touche le bas avec une vitesse suffisante, jouer un son
            if (vy < -3) {
                // Réduire la vitesse à chaque rebond
                vx *= 0.9;
            }
        }
        
        // Appliquer la position
        football.style.left = `${x}px`;
        football.style.top = `${y}px`;
        
        // Vérifier si le ballon doit être supprimé
        const elapsedTime = Date.now() - startTime;
        if (elapsedTime < lifespan && Math.abs(vy) > 0.1) {
            requestAnimationFrame(updatePosition);
        } else {
            container.removeChild(football);
        }
    }
    
    requestAnimationFrame(updatePosition);
}

// Fonction pour ajouter une rafale de ballons
function addBallBurst(count) {
    for (let i = 0; i < count; i++) {
        setTimeout(() => createFootball(), i * 100);
    }
}

// Créer un nouveau ballon plus fréquemment (toutes les 500ms)
setInterval(createFootball, 500);

// Créer une rafale périodiquement (5 ballons tous les 3 secondes)
setInterval(() => addBallBurst(5), 3000);

// Créer plus de ballons initiaux (10 au lieu de 3)
for (let i = 0; i < 10; i++) {
    setTimeout(() => createFootball(), i * 200);
}

// Animation de but lorsque le formulaire est soumis
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Création de plusieurs ballons pour célébration
    for (let i = 0; i < 20; i++) { // Augmenté de 10 à 20 ballons
        setTimeout(() => createFootball(), i * 100);
    }
    
    // Afficher l'animation "BUT!!!"
    const goalFlash = document.getElementById('goal-flash');
    const goalText = document.getElementById('goal-text');
    
    goalFlash.style.opacity = '1';
    setTimeout(() => {
        goalText.style.transform = 'scale(1)';
    }, 100);
    
    setTimeout(() => {
        goalText.style.transform = 'scale(0)';
        setTimeout(() => {
            goalFlash.style.opacity = '0';
        }, 500);
    }, 2000);
    
    // Normalement, vous redirigeriez vers une autre page après la connexion
    // window.location.href = 'dashboard.html';
});