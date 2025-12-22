// ПРИМЕР 2: Функция для подсчета кроликов
function countRabbits() {
    for(let i = 1; i <= 3; i++) {
        alert("Кролик номер " + i);
    }
}

// ПРИМЕР 3: Назначение обработчика через свойство DOM
document.getElementById('elem').onclick = function() {
    alert('Спасибо');
};

// ПРИМЕР 5: Несколько обработчиков через addEventListener
const multiElem = document.getElementById('multiElem');

function handler1() {
    alert('Спасибо!');
}

function handler2() {
    alert('Спасибо ещё раз!');
}

// Назначаем несколько обработчиков на одну кнопку
multiElem.onclick = () => alert("Привет");
multiElem.addEventListener("click", handler1);
multiElem.addEventListener("click", handler2);

// ПРИМЕР 6: Добавление и удаление обработчика
const removeElem = document.getElementById('removeElem');
const removeBtn = document.getElementById('removeBtn');
const removeStatus = document.getElementById('removeStatus');

function removableHandler() {
    alert('Этот обработчик можно удалить!');
    removeStatus.textContent = 'Обработчик активен. Попробуйте удалить его.';
}

// Обработчик для добавления другого обработчика
removeElem.addEventListener('click', function addHandler() {
    // Добавляем основной обработчик
    removeElem.addEventListener('click', removableHandler);
    
    // Активируем кнопку удаления
    removeBtn.disabled = false;
    removeStatus.textContent = 'Обработчик добавлен! Теперь нажмите на первую кнопку еще раз.';
    removeStatus.style.color = 'green';
    
    // Удаляем этот обработчик после первого использования
    removeElem.removeEventListener('click', addHandler);
});

// Обработчик для удаления обработчика
removeBtn.addEventListener('click', function() {
    removeElem.removeEventListener('click', removableHandler);
    removeBtn.disabled = true;
    removeStatus.textContent = 'Обработчик удален!';
    removeStatus.style.color = 'red';
});

// Дополнительная функция для демонстрации this
function showElementText(element) {
    alert('Текст элемента: ' + element.innerHTML);
}