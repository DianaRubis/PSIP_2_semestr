// 1. Примеры встроенных объектов
function showMathExamples() {
    const mathExamples = document.getElementById('mathExamples');
    mathExamples.innerHTML = `
        <div class="property">Math.PI: ${Math.PI}</div>
        <div class="property">Math.sqrt(16): ${Math.sqrt(16)}</div>
        <div class="property">Math.round(4.7): ${Math.round(4.7)}</div>
        <div class="property">Math.random(): ${Math.random()}</div>
        <div class="property">Math.max(10, 20, 5): ${Math.max(10, 20, 5)}</div>
    `;
    mathExamples.style.display = 'block';
}

function showDateExamples() {
    const now = new Date();
    const dateExamples = document.getElementById('dateExamples');
    dateExamples.innerHTML = `
       
        <div class="property">getFullYear(): ${now.getFullYear()}</div>
        <div class="property">getMonth(): ${now.getMonth()} (0-11, где 0 - январь)</div>
        <div class="property">getDate(): ${now.getDate()}</div>
        <div class="property">toLocaleDateString(): ${now.toLocaleDateString()}</div>
    `;
    dateExamples.style.display = 'block';
}

// 2. Пользовательский объект
let car = {
    brand: "Toyota",
    model: "Camry",
    year: 2020,
    color: "синий",
    startEngine: function() {
        return "Двигатель запущен!";
    },
    getInfo: function() {
        return `${this.brand} ${this.model}, ${this.year} года, цвет: ${this.color}`;
    }
};

function showCarInfo() {
    const carInfo = document.getElementById('carInfo');
    carInfo.innerHTML = `
        <div class="property">${car.getInfo()}</div>
        <div class="property">${car.startEngine()}</div>
    `;
    carInfo.style.display = 'block';
}

// 3. Доступ к свойствам объекта
let person = {
    name: "Иван",
    age: 30,
    "favorite color": "синий"
};

function showPersonInfo() {
    const personInfo = document.getElementById('personInfo');
    personInfo.innerHTML = `
        <div class="property">person.name: ${person.name}</div>
        <div class="property">person["age"]: ${person["age"]}</div>
        <div class="property">person["favorite color"]: ${person["favorite color"]}</div>
    `;
    personInfo.style.display = 'block';
}

// 4. Удаление свойства
let book = {
    title: "JavaScript для начинающих",
    author: "Иванов И.И.",
    pages: 350,
    price: 1200
};

function showBookBeforeDelete() {
    const bookInfo = document.getElementById('bookInfo');
    bookInfo.innerHTML = `
        <div class="property">До удаления:</div>
        <div class="property">title: ${book.title}</div>
        <div class="property">author: ${book.author}</div>
        <div class="property">pages: ${book.pages}</div>
        <div class="property">price: ${book.price}</div>
        <div class="property">"price" in book: ${"price" in book}</div>
    `;
    bookInfo.style.display = 'block';
}

function deleteBookPrice() {
    delete book.price;
    const bookInfo = document.getElementById('bookInfo');
    bookInfo.innerHTML = `<div class="property">Свойство price удалено!</div>`;
    bookInfo.style.display = 'block';
}

function showBookAfterDelete() {
    const bookInfo = document.getElementById('bookInfo');
    bookInfo.innerHTML = `
        <div class="property">После удаления:</div>
        <div class="property">title: ${book.title}</div>
        <div class="property">author: ${book.author}</div>
        <div class="property">pages: ${book.pages}</div>
        <div class="property">price: ${book.price}</div>
        <div class="property">"price" in book: ${"price" in book}</div>
    `;
    bookInfo.style.display = 'block';
}

// 5. Проверка существования свойства
let student = {
    name: "Мария",
    age: 20,
    course: 2
};

function checkStudentProperties() {
    const propertyCheck = document.getElementById('propertyCheck');
    propertyCheck.innerHTML = `
        <div class="property">"name" in student: ${"name" in student}</div>
        <div class="property">"grade" in student: ${"grade" in student}</div>
        <div class="property">student.hasOwnProperty("age"): ${student.hasOwnProperty("age")}</div>
        <div class="property">student.hasOwnProperty("subject"): ${student.hasOwnProperty("subject")}</div>
    `;
    propertyCheck.style.display = 'block';
}

// 6. Перебор свойств объекта
let phone = {
    brand: "Samsung",
    model: "Galaxy S21",
    storage: 128,
    color: "черный"
};

function showPhonePropertiesForIn() {
    let result = "";
    for (let key in phone) {
        result += `<div class="property">${key}: ${phone[key]}</div>`;
    }
    const phoneProperties = document.getElementById('phoneProperties');
    phoneProperties.innerHTML = `<div class="property">Перебор с помощью for...in:</div>${result}`;
    phoneProperties.style.display = 'block';
}

function showPhonePropertiesKeys() {
    const keys = Object.keys(phone);
    const phoneProperties = document.getElementById('phoneProperties');
    phoneProperties.innerHTML = `
        <div class="property">Object.keys(phone):</div>
        <div class="property">${JSON.stringify(keys)}</div>
    `;
    phoneProperties.style.display = 'block';
}

function showPhonePropertiesValues() {
    const values = Object.values(phone);
    const phoneProperties = document.getElementById('phoneProperties');
    phoneProperties.innerHTML = `
        <div class="property">Object.values(phone):</div>
        <div class="property">${JSON.stringify(values)}</div>
    `;
    phoneProperties.style.display = 'block';
}

function showPhonePropertiesEntries() {
    const entries = Object.entries(phone);
    const phoneProperties = document.getElementById('phoneProperties');
    phoneProperties.innerHTML = `
        <div class="property">Object.entries(phone):</div>
        <div class="property">${JSON.stringify(entries)}</div>
    `;
    phoneProperties.style.display = 'block';
}