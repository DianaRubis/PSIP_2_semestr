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


      document.getElementById('collabForm').addEventListener('submit', function(e) {
          e.preventDefault();

          const formData = new FormData(this);

          fetch('send_collab.php', {
              method: 'POST',
              body: formData
          })
              .then(response => response.json())
              .then(data => {
                  if(data.status === 'success') {
                      alert('Спасибо! Мы скоро свяжемся с вами.');
                      this.reset();
                  } else {
                      alert('Произошла ошибка при отправке.');
                  }
              });
      });












// В самом начале scripts.js добавьте проверку, чтобы не было ошибок
      document.addEventListener('click', function (e) {
          // 1. Проверяем, нажали ли именно на кнопку (или иконку внутри неё)
          const cartBtn = e.target.closest('.add-to-cart');

          if (cartBtn) {
              e.preventDefault(); // Остановить стандартное поведение

              // 2. Проверка авторизации (переменная из index.php)
              if (typeof isLoggedIn === 'undefined' || isLoggedIn === false) {
                  alert('Чтобы сделать заказ, необходимо авторизоваться!');
                  return;
              }

              const productId = cartBtn.getAttribute('data-id');

              // 3. Отправляем запрос (путь должен быть верным относительно index.php)
              fetch('add_to_cart.php?id=' + productId + '&qty=1')
                  .then(response => {
                      if (!response.ok) throw new Error('Файл add_to_cart.php не найден');
                      return response.text();
                  })
                  .then(data => {
                      console.log('Ответ сервера:', data); // Посмотрим в консоли (F12)
                      if (data.trim() === 'success') {
                          alert('Товар добавлен в корзину! 🐟');
                      } else {
                          alert('Сервер ответил: ' + data);
                      }
                  })
                  .catch(error => {
                      console.error('Ошибка:', error);
                      alert('Ошибка при добавлении. Проверьте консоль (F12)');
                  });
          }
      });
  })();



  let currentProductId = null;
  const qtyModal = new bootstrap.Modal(document.getElementById('quantityModal'));

  // 1. При нажатии на кнопку "В корзину" в списке товаров
  document.addEventListener('click', function(e) {
      if (e.target.classList.contains('add-to-cart')) {
          e.preventDefault();
          currentProductId = e.target.getAttribute('data-id');
          document.getElementById('inputQuantity').value = 1; // Сброс счетчика
          qtyModal.show();
      }
  });

  function addToCart(productId) {
      fetch('add_to_cart.php?id=' + productId)
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  // Информируем пользователя
                  alert('Товар успешно добавлен в корзину! Изменить количество можно во вкладке "Корзина".');

                  // Опционально: обновляем счетчик корзины на иконке, если он есть
                  const cartCounter = document.getElementById('cart-count');
                  if (cartCounter) {
                      cartCounter.innerText = data.cart_count;
                  }
              } else {
                  alert('Ошибка при добавлении товара.');
              }
          })
          .catch(error => console.error('Ошибка:', error));
  }
