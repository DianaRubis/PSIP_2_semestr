// БАЗОВЫЙ КЛАСС ДЛЯ ВСЕХ ШАРИКОВ
class Ball {
    constructor(type, size, speed, color, points) {
        this.element = document.createElement('div');
        this.element.className = 'ball';
        this.type = type;
        this.size = size;
        this.speed = speed;
        this.color = color;
        this.points = points;
        
        this.x = Math.random() * (400 - size);
        this.y = -size;
        
        this.element.style.width = size + 'px';
        this.element.style.height = size + 'px';
        this.element.style.background = color;
        this.element.style.left = this.x + 'px';
        this.element.style.top = this.y + 'px';
    }
    
    // Метод обновления позиции (будет переопределен в дочерних классах)
    update() {
        this.y += this.speed;
        this.element.style.top = this.y + 'px';
        return this.y > 400; // Возвращает true, если шарик ушел за экран
    }
    
    // Метод обработки столкновения
    onCollision(game) {
        game.score += this.points;
        game.updateScore();
        return true; // Удалять шарик после столкновения
    }
}

// КЛАСС ОБЫЧНОГО ШАРИКА (наследуется от Ball)
class NormalBall extends Ball {
    constructor() {
        super('normal', 30, 2 + Math.random() * 2, '#e74c3c', 1);
    }
}

// КЛАСС БОНУСНОГО ШАРИКА (наследуется от Ball)
class BonusBall extends Ball {
    constructor() {
        super('bonus', 25, 3 + Math.random() * 2, '#f1c40f', 3);
        this.element.style.boxShadow = '0 0 10px gold';
    }
    
    // Переопределяем метод обновления - бонусный шарик движется быстрее
    update() {
        this.y += this.speed * 1.2;
        this.element.style.top = this.y + 'px';
        return this.y > 400;
    }
}

// КЛАСС ОПАСНОГО ШАРИКА (наследуется от Ball)
class DangerBall extends Ball {
    constructor() {
        super('danger', 35, 1.5 + Math.random() * 1.5, '#9b59b6', -2);
    }
    
    // Переопределяем метод обработки столкновения
    onCollision(game) {
        game.lives -= 2;
        game.updateScore();
        if (game.lives <= 0) {
            game.stop();
            alert('Игра окончена! Вы потеряли все жизни!');
        }
        return true;
    }
}

// КЛАСС ИГРОКА
class Player {
    constructor() {
        this.element = document.getElementById('player');
        this.speed = 15;
        this.x = 175;
        this.setupControls();
    }
    
    setupControls() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.moveLeft();
            if (e.key === 'ArrowRight') this.moveRight();
        });
    }
    
    moveLeft() {
        this.x = Math.max(0, this.x - this.speed);
        this.element.style.left = this.x + 'px';
    }
    
    moveRight() {
        this.x = Math.min(350, this.x + this.speed);
        this.element.style.left = this.x + 'px';
    }
    
    getPosition() {
        return {
            left: this.x,
            right: this.x + 50,
            top: 370, // Позиция платформы
            bottom: 390
        };
    }
}

// ГЛАВНЫЙ КЛАСС ИГРЫ
class Game {
    constructor() {
        this.score = 0;
        this.lives = 5;
        this.isPlaying = false;
        this.player = new Player();
        this.balls = [];
        this.gameElement = document.getElementById('game');
        this.scoreElement = document.getElementById('score');
    }
    
    start() {
        if (this.isPlaying) return;
        
        this.score = 0;
        this.lives = 5;
        this.isPlaying = true;
        this.balls = [];
        this.updateScore();
        
        this.ballInterval = setInterval(() => this.createBall(), 800);
        this.gameLoop = setInterval(() => this.update(), 50);
    }
    
    createBall() {
        if (!this.isPlaying) return;
        
        // Создаем разные типы шариков с разной вероятностью
        const random = Math.random();
        let ball;
        
        if (random < 0.6) { // 60% chance - обычный шарик
            ball = new NormalBall();
        } else if (random < 0.8) { // 20% chance - бонусный шарик
            ball = new BonusBall();
        } else { // 20% chance - опасный шарик
            ball = new DangerBall();
        }
        
        this.balls.push(ball);
        this.gameElement.appendChild(ball.element);
    }
    
    update() {
        if (!this.isPlaying) return;
        
        for (let i = this.balls.length - 1; i >= 0; i--) {
            const ball = this.balls[i];
            const isOutOfScreen = ball.update();
            
            if (isOutOfScreen) {
                this.removeBall(i);
                continue;
            }
            
            if (this.checkCollision(ball)) {
                const shouldRemove = ball.onCollision(this);
                if (shouldRemove) {
                    this.removeBall(i);
                }
            }
        }
    }
    
    checkCollision(ball) {
        const playerPos = this.player.getPosition();
        const ballRect = ball.element.getBoundingClientRect();
        const gameRect = this.gameElement.getBoundingClientRect();
        
        const ballTop = ballRect.top - gameRect.top + ball.size / 2;
        
        return ballTop >= playerPos.top && 
               ballTop <= playerPos.bottom &&
               ball.x + ball.size >= playerPos.left &&
               ball.x <= playerPos.right;
    }
    
    removeBall(index) {
        if (this.balls[index].element.parentNode === this.gameElement) {
            this.gameElement.removeChild(this.balls[index].element);
        }
        this.balls.splice(index, 1);
    }
    
    updateScore() {
        this.scoreElement.textContent = `Счет: ${this.score} | Жизни: ${this.lives}`;
    }
    
    stop() {
        this.isPlaying = false;
        clearInterval(this.ballInterval);
        clearInterval(this.gameLoop);
        
        this.balls.forEach(ball => {
            if (ball.element.parentNode === this.gameElement) {
                this.gameElement.removeChild(ball.element);
            }
        });
        this.balls = [];
    }
}

// Создаем экземпляр игры
const game = new Game();