  (function () {
    'use strict';

    // Форма "Получить КП"
    const businessForm = document.getElementById('businessForm');
    if (businessForm) {
      businessForm.addEventListener('submit', function (event) {
        if (!businessForm.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        businessForm.classList.add('was-validated');
      }, false);
    }

    // Форма "Сотрудничество"
    const collabForm = document.getElementById('collabForm');
    if (collabForm) {
      collabForm.addEventListener('submit', function (event) {
        if (!collabForm.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        collabForm.classList.add('was-validated');
      }, false);
    }

    const swiper = new Swiper('.mySwiper', {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true, // Зацикливание слайдов
  autoplay: {
    delay: 3000, // Интервал в миллисекундах (3 секунды)
    disableOnInteraction: false, // Продолжать автопрокрутку после ручного переключения
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});


(function () {
  'use strict';

  // Попап "Каталог"
  const catalogLink = document.getElementById('openCatalogForm');
  const popup = document.getElementById('catalogPopup');

  if (catalogLink && popup) {
    catalogLink.addEventListener('click', e => {
      e.preventDefault();
      popup.classList.toggle('d-none');
    });

    document.addEventListener('click', e => {
      if (!popup.contains(e.target) && !catalogLink.contains(e.target))
        popup.classList.add('d-none');
    });
  }
})();

  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('catalogForm');

    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }

      form.classList.add('was-validated');
    });
  });
  

    const toTopBtn = document.getElementById("toTopBtn");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      toTopBtn.classList.add("show");
    } else {
      toTopBtn.classList.remove("show");
    }
  });

  toTopBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


const logoLink = document.querySelector('a.d-flex');

logoLink.addEventListener('mouseenter', () => {
  const logos = logoLink.querySelectorAll('img');
  
  // Анимация разлета
  gsap.to(logos, {
    x: () => Math.random() * 30 - 15,
    y: () => Math.random() * 30 - 15,
    rotation: () => Math.random() * 360,
    duration: 0.5,
    ease: "power2.out"
  });
  
  // Возвращение на место через секунду
  setTimeout(() => {
    gsap.to(logos, {
      x: 0,
      y: 0,
      rotation: 0,
      duration: 0.8,
      ease: "elastic.out(1, 0.5)"
    });
  }, 1000);
});
  })();


  // СОБЫТИЯ МЫШИ
document.querySelectorAll('.text-right a').forEach(card => {
  card.addEventListener('click', () => {
    console.log('Клик по карточке товара');
  });

  card.addEventListener('mouseenter', () => {
    card.style.outline = '2px solid #ffc107';
  });

  card.addEventListener('mouseleave', () => {
    card.style.outline = 'none';
  });
});

// СОБЫТИЯ КЛАВИАТУРЫ
document.querySelectorAll('input[type="text"]').forEach(input => {
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      console.log('Нажата клавиша Enter');
    }
  });
});

// DRAG & DROP
document.querySelectorAll('.text-right').forEach(item => {
  item.addEventListener('dragstart', () => {
    console.log('Начато перетаскивание элемента');
  });

  item.addEventListener('dragend', () => {
    console.log('Перетаскивание завершено');
  });
});

// POINTER EVENTS
document.body.addEventListener('pointerdown', () => {
  console.log('Событие указателя: pointerdown');
});

// SCROLL EVENT
window.addEventListener('scroll', () => {
  console.log('Прокрутка страницы');
});

// TIMER EVENTS
setTimeout(() => {
  console.log('Событие таймера: прошло 5 секунд');
}, 5000);


// ===== ЗАДАНИЕ 1. ПОЛУЧЕНИЕ ДАННЫХ ИЗ ФОРМЫ =====
document.getElementById('businessForm').addEventListener('submit', function (e) {
  e.preventDefault(); // не отправляем форму

  const selects = this.querySelectorAll('select');
  const inputs = this.querySelectorAll('input');

  const data = {
    niche: selects[0].value,
    delivery: selects[1].value,
    volume: selects[2].value,
    name: inputs[0].value,
    email: inputs[1].value,
    phone: inputs[2].value,
    agree: inputs[3].checked
  };

  alert(
    `Данные формы:
Ниша: ${data.niche}
Способ получения: ${data.delivery}
Объем: ${data.volume}
Имя: ${data.name}
Email: ${data.email}
Телефон: ${data.phone}
Согласие: ${data.agree ? 'Да' : 'Нет'}`
  );
});

// ===== JS ВАЛИДАЦИЯ =====
document.getElementById('collabForm').addEventListener('submit', function (e) {
  const name = this.querySelector('input[type="text"]').value.trim();
  const phone = this.querySelector('input[type="tel"]').value.trim();

  if (name === '') {
    alert('Имя не может быть пустым');
    e.preventDefault();
    return;
  }

  if (phone.length < 10) {
    alert('Телефон введен неверно');
    e.preventDefault();
    return;
  }
});

// ===== ЗАДАНИЕ 3. REGEXP (РБ) =====
document.getElementById('collabForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const name = this.querySelector('input[type="text"]').value.trim();
  const phone = this.querySelector('input[type="tel"]').value.trim();
  const email = this.querySelector('input[type="email"]').value.trim();

  // REGEXP (Беларусь)
  const phoneReg = /^\+375(25|29|33|44)\d{7}$/;
  const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // test()
  if (!phoneReg.test(phone)) {
    alert('Введите номер телефона в формате +375XXXXXXXXX');
    return;
  }

  if (!emailReg.test(email)) {
    alert('Email введён некорректно');
    return;
  }

  // exec()
  const phoneExec = phoneReg.exec(phone);
  console.log('exec():', phoneExec);

  // match()
  console.log('match():', email.match(/@.+/));

  // search()
  console.log('search():', email.search(/@/));

  // replace()
  const hiddenPhone = phone.replace(/\d{7}$/, '*******');
  console.log('replace():', hiddenPhone);

  // split()
  const emailParts = email.split('@');
  console.log('split():', emailParts);

  alert(
    `Форма успешно проверена (РБ)
Имя: ${name}
Телефон: ${hiddenPhone}
Email: ${email}`
  );
});


// ====== СОХРАНЕНИЕ ДАННЫХ ======
document.getElementById('cookieForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const data = {
    fio: fio.value,
    email: email.value,
    birth: birth.value,
    city: city.value,
    hobby: hobby.value
  };

  // LocalStorage
  localStorage.setItem('userData', JSON.stringify(data));

  // Cookie (на 7 дней)
  document.cookie = "userData=" + encodeURIComponent(JSON.stringify(data)) + "; max-age=604800; path=/";

  alert('Данные сохранены в Cookie и LocalStorage');
});

// ====== ЧТЕНИЕ COOKIE ======
function readCookie() {
  const cookies = document.cookie.split('; ');
  const cookie = cookies.find(row => row.startsWith('userData='));

  if (!cookie) {
    alert('Cookie не найдены');
    return;
  }

  const data = JSON.parse(decodeURIComponent(cookie.split('=')[1]));
  alert(
    `ФИО: ${data.fio}
Email: ${data.email}
Дата рождения: ${data.birth}
Город: ${data.city}
Хобби: ${data.hobby}`
  );
}

// ====== ОЧИСТКА COOKIE ======
function clearCookie() {
  document.cookie = "userData=; max-age=0; path=/";
  alert('Cookie очищены');
}

// ====== ОЧИСТКА LOCALSTORAGE ======
function clearLocal() {
  localStorage.removeItem('userData');
  alert('LocalStorage очищен');
}









function updateCart() {
  const cartList = document.getElementById("cart");
  cartList.innerHTML = "";

  cart.forEach(item => {
    const li = document.createElement("li");
    li.textContent = `${item.name} – ${item.price} BYN`;
    cartList.appendChild(li);
  });
}



document.getElementById("cookieForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const data = {
    fio: fio.value,
    email: email.value,
    birth: birth.value,
    city: city.value,
    hobby: hobby.value
  };

  document.cookie = "user=" + JSON.stringify(data) + "; max-age=86400";
  alert("Данные сохранены в Cookie");
});

function readCookie() {
  const cookie = document.cookie
    .split("; ")
    .find(row => row.startsWith("user="));

  if (cookie) {
    alert(cookie.split("=")[1]);
  }
}

function clearCookie() {
  document.cookie = "user=; max-age=0";
  alert("Cookie очищены");
}


function saveLocal() {
  const data = {
    fio: fio.value,
    email: email.value,
    birth: birth.value,
    city: city.value,
    hobby: hobby.value
  };

  localStorage.setItem("userData", JSON.stringify(data));
  alert("Данные сохранены в LocalStorage");
}

function loadLocal() {
  const data = localStorage.getItem("userData");
  if (data) alert(data);
}

function clearLocal() {
  localStorage.removeItem("userData");
  alert("LocalStorage очищен");
}



let cart = [];

fetch("data/products.json")
  .then(response => response.json())
  .then(products => {
    const productList = document.getElementById('productList');

    products.forEach(item => {
      productList.innerHTML += `
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title">${item.name}</h5>
              <p class="card-text">Цена: ${item.price} ₽</p>
              <button class="btn btn-primary"
                onclick="addToCart(${item.id}, '${item.name}', ${item.price})">
                В корзину
              </button>
            </div>
          </div>
        </div>
      `;
    });
  })
  .catch(error => {
    console.error('Ошибка загрузки JSON:', error);
  });

  const productList = document.getElementById('productList');

products.forEach(item => {
  productList.innerHTML += `
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">${item.name}</h5>
          <p class="card-text">Цена: ${item.price} ₽</p>
          <button class="btn btn-primary">В корзину</button>
        </div>
      </div>
    </div>
  `;
});

