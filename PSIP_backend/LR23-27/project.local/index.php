<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Используем абсолютный путь для надежности
$db_path = __DIR__ . '/db.php';

if (file_exists($db_path)) {
    require_once $db_path;
} else {
    die("Критическая ошибка: Файл db.php не найден по пути: " . $db_path);
}

// Проверка: создалась ли переменная?
if (!isset($pdo)) {
    die("Критическая ошибка: Файл db.php подключен, но переменная \$pdo не определена.");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Fish</title>
    <link rel="stylesheet" href="css/style_copy.css" />
    <link rel="preload" href="font/Montserrat/Montserrat-SemiBold.ttf" as="font" type="font/woff2" crossorigin>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  </head>
  <body>
    <button id="toTopBtn" title="Наверх">↑</button>

    <div class="main"> 
      <div class="frame-wrapper">
        <div class="frame">
          <div class="view">
            <!-- Первая шапка -->
             <header class="container-fluid py-3 px-3 border-bottom fixed-top bg-white">
              <div class="container-lg col-lg-10 px-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <!-- Слева: Лого -->
                  <a href="/" class="d-flex align-items-center gap-2 text-decoration-none">
                    <img src="img/header/logo.png" alt="logo" class="logo" style="height: 20px;">
                    <img src="img/header/ho-re-ca.png" alt="ho-re-ca" class="ho-re-ca d-none d-sm-inline" style="height: 20px;">
                  </a>
                  <!-- Центр: Меню только для md+ -->
                  <nav class="d-none d-md-flex gap-3 fw-medium frame-8">
                    <a href="#" class="text-decoration-none blue-text fw-semibold hover">Доставка</a>
                    <a href="#" class="text-decoration-none blue-text fw-semibold hover">Прайс</a>
                    <a href="#" class="text-decoration-none blue-text fw-semibold hover">Производство</a>
                      <a href="cart.php" class="text-decoration-none blue-text fw-semibold hover d-flex align-items-center gap-2">

                          <span>Корзина</span>

                          <?php if(!empty($_SESSION['cart'])): ?>
                              <span class="badge rounded-pill bg-danger" style="font-size: 0.7rem;">
            <?= count($_SESSION['cart']) ?>
        </span>
                          <?php endif; ?>
                      </a>
                    <a href="#" class="text-decoration-none blue-text fw-semibold hover">Контакты</a>
                    <a href="#" class="text-decoration-none blue-text fw-semibold hover">О компании</a>

                  </nav>
                  <!-- Справа: иконки и бургер (только до md) -->
                  <div class="d-md-none d-flex align-items-center gap-3">
                    <!-- Иконки -->
                    <img src="img/header/search2.png" alt="search" style="height: 24px;">
                    <img src="img/header/user.png" alt="user" style="height: 24px;">
                    <img src="img/header/favorite2.png" alt="favorite" style="height: 24px;">


                    <!-- Бургер -->
                    <div class="dropdown">
                      <!-- Бургер отображается на md и меньше -->
                      <button class="btn p-1 border-0 bg-transparent d-lg-none" type="button"
                              data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                        <img src="img/header/Burger.png" alt="Меню" style="width: 28px; height: 28px;">
                      </button>


                      <div class="offcanvas offcanvas-start fullscreen-offcanvas d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
                        <div class="offcanvas-body d-flex flex-column justify-content-between">

                          <!--  Поиск -->
                          <div class="mb-4">
                            <input type="text" class="form-control" placeholder="Поиск">
                          </div>

                          <!--  Ссылки с иконками -->
                          <div class="d-flex flex-column gap-3 mb-4">
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                              <img src="img/header/menu-dots2.png" style="width: 20px;" alt="catalog"> Каталог товаров
                            </a>
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                              <img src="img/header/user.png" style="width: 20px;" alt="user"> Вход
                            </a>
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                              <img src="img/header/favorite2.png" style="width: 20px;" alt="izbrannoe"> Избранное
                            </a>

                          </div>

                          <!--  Навигация -->
                          <div class="d-flex flex-column gap-2 mb-4">
                            <a href="#" class="text-decoration-none text-dark">Доставка</a>
                            <a href="#" class="text-decoration-none text-dark">Прайс</a>
                            <a href="#" class="text-decoration-none text-dark">Производство</a>
                            <a href="#" class="text-decoration-none text-dark">Оплата</a>
                            <a href="#" class="text-decoration-none text-dark">Контакты</a>
                            <a href="#" class="text-decoration-none text-dark">О компании</a>
                          </div>

                          <!--  Контакты и соцсети -->
                          <div class="text-center mt-auto">
                            <p class="mb-1 fw-bold text-primary">8 (495) 637-82-28</p>
                            <p class="small mb-2">ЗАКАЗАТЬ ЗВОНОК</p>
                            <div class="d-flex justify-content-center gap-3">
                              <img src="img/header/img-3.png" alt="Telegram" style="width: 40px;">
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>

                  </div>

                  <!-- Доп. изображение (только lg+) -->
                  <div class="d-none d-lg-flex align-items-center ms-3">
                    <a href="https://t.me/yourchannel" target="_blank" class="icon-link me-3" rel="noopener noreferrer">
                      <img src="img/header/tg.png" alt="Telegram" style="height: 22px;">
                    </a>
                    <a href="https://wa.me/yourphone" target="_blank" class="icon-link me-3" rel="noopener noreferrer">
                      <img src="img/header/watsup.png" alt="WhatsApp" style="height: 22px;">
                    </a>
                    <a href="https://vk.com/yourpage" target="_blank" class="icon-link" rel="noopener noreferrer">
                      <img src="img/header/img-2.png" alt="VK" style="height: 32px;">
                    </a>
                  </div>
                </div>
              </div>
            </header>

            <!-- Вторая шапка -->
            <!-- Шапка -->
            <div class="container-fluid border-bottom header-desktop position-relative">
              <div class="container-lg col-lg-10 px-0">
                <div class="d-none d-lg-flex align-items-center justify-content-between py-3 gap-4">
                  
                  <!-- Кнопка: Каталог товаров -->
                  <a href="#" id="openCatalogForm" class="d-flex align-items-center gap-2 text-white text-decoration-none hover">
                    <img src="img/header/menu-dots.png" alt="Каталог" style="height: 24px;">
                    <span class="fw-semibold">Каталог товаров</span>
                  </a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <div class="admin-link-wrapper" style="position: fixed; top: 20px; left: 20px; z-index: 9999;">
                            <a href="admin_panel.php" class="btn btn-outline-dark shadow-sm admin-nav-btn">
                                ⚙️ Панель администратора
                            </a>
                        </div>

                        <style>
                            .admin-nav-btn {
                                border-radius: 8px;
                                background-color: rgba(255, 255, 255, 0.7); /* Полупрозрачный фон */
                                backdrop-filter: blur(5px); /* Эффект размытия под кнопкой */
                                font-weight: 500;
                                font-size: 14px;
                                border-color: #333;
                                color: #333;
                                transition: all 0.3s ease;
                            }

                            .admin-nav-btn:hover {
                                background-color: #333 !important;
                                color: #fff !important;
                                transform: scale(1.05);
                            }
                        </style>
                    <?php endif; ?>
                  <!-- Поиск -->
                  <div class="d-flex align-items-center flex-grow-1 mx-3" style="max-width: 400px;">
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0">
                        <img src="img/header/search.png" alt="Поиск" style="height: 18px;">
                      </span>
                      <input type="text" class="form-control border-start-0" placeholder="Поиск">
                    </div>  
                  </div>

                  <!-- Избранное -->
                  <a href="#" class="d-flex align-items-center gap-2 text-white text-decoration-none hover">
                    <img src="img/header/favorite.png" alt="Избранное" style="height: 24px;">
                    <span class="fw-semibold">Избранное</span>
                  </a>



                  <!-- Войти -->
                    <div class="ms-3">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="dropdown d-inline-block">
                                <a href="#" class="text-white text-decoration-none fw-semibold dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 14px;">
                                    <?php
                                    // Вместо ?? используем тернарный оператор и isset
                                    echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Профиль';
                                    ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                    <li><a class="dropdown-item text-danger" href="logout.php">Выйти</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="#" class="text-white text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 14px;">
                                Войти
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
              </div>

              <!-- Попап форма "Каталог товаров" -->
              <div id="catalogPopup" class="position-absolute bg-white shadow p-4 d-none" style="top: 100%; left: 0; z-index: 1050; border-radius: 8px; min-width: 300px;">
                <form id="catalogForm" novalidate>
                  <h6 class="mb-3">Добавить товар</h6>

                  <div class="mb-3">
                    <label for="productName" class="form-label">Название товара</label>
                    <input type="text" class="form-control" id="productName" placeholder="Введите название" required>
                  </div>

                  <div class="mb-3">
                    <label for="productCategory" class="form-label">Категория</label>
                    <select class="form-select" id="productCategory" required>
                      <option selected disabled value="">Выберите категорию</option>
                      <option>Одежда</option>
                      <option>Обувь</option>
                      <option>Аксессуары</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="productPrice" class="form-label">Цена</label>
                    <input type="number" class="form-control" id="productPrice" placeholder="BYN" required>
                  </div>

                  <button type="submit" class="btn btn-primary w-100">Добавить</button>
                </form>
              </div>
            </div>

            

            
            <div class="container-fluid">
              <nav aria-label="breadcrumb " class="mt-3">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Главная</a></li>
                  <li class="breadcrumb-item"><a href="#">Каталог</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Замороженная рыба</li>
                </ol>
              </nav>


              <div class="row">
                <div class="col-12 col-lg-10 mx-auto">
                

                  <!-- СЛАЙДЕР -->
                  <div class="container my-4">
                    <!-- Слайдер для десктопа и планшета -->
                    <div id="carouselMain" class="carousel slide d-none d-sm-block" data-bs-ride="carousel">
                      <div class="carousel-inner rounded-4 overflow-hidden">
                        <div class="carousel-item active">
                          <img src="img/slide/desktop1.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="img/slide/desktop2.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="img/slide/desktop3.png" class="d-block w-100" alt="...">
                        </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                      </button>
                    </div>

                    <!-- Слайдер для телефона -->
                    <div id="carouselMobile" class="carousel slide d-block d-sm-none" data-bs-ride="carousel">
                      <div class="carousel-inner rounded-4 overflow-hidden">
                        <div class="carousel-item active">
                          <img src="img/slide/mobile1.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="img/slide/mobile2.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="img/slide/mobile3.png" class="d-block w-100" alt="...">
                        </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselMobile" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselMobile" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                      </button>
                    </div>
                  </div>

                  
                  <div class="container my-5">
                    <div class="row g-4 justify-content-center">
                      <!-- Блок 1 -->
                      <div class="col-12 col-md-6 col-lg-4">
                        <div class="position-relative p-4 bg-light rounded-4 h-100 shadow" style="min-height: 240px;">
                          <h5 class="fw-bold mb-3 blue-text">Чат-бот цен на все наши продукты питания</h5>
                          <p class="w-75 blue-text">Узнайте наши цены за пару секунд без писем и звонков менеджеру</p>
                          <img src="img/under_slider/button.png" alt="Кнопка" class="position-absolute bottom-0 start-0 mb-3 ms-3" style="height: 40px;">
                          <img src="img/under_slider/block1.png" alt="Изображение" class="position-absolute bottom-0 end-0 mb-3 me-3" style="height: 120px;">
                        </div>
                      </div>

                      <!-- Блок 2 -->
                      <div class="col-12 col-md-6 col-lg-4">
                        <div class="position-relative p-4 bg-light rounded-4 h-100 shadow" style="min-height: 240px;">
                          <h5 class="fw-bold mb-3 blue-text">Лосось охлажденный</h5>
                          <p class="w-75 blue-text mb-2">Акционная цена</p>
                          <span class="fw-bold blue-text">1700 ₽ / кг</span>
                          <div class="badge bg-warning text-blue px-3 py-2 position-absolute bottom-0 start-0 mb-3 ms-3 blue-text">до 31.12.2023 г.</div>
                          <img src="img/under_slider/block2.png" alt="Рыба" class="position-absolute bottom-0 end-0 mb-3 me-3" style="height: 120px;">
                        </div>
                      </div>
                        <div class="col-12 col-md-6 col-lg-4 d-md-flex justify-content-md-center">
                          <div class="position-relative p-4 bg-light rounded-4 h-100 shadow w-100" style="min-height: 240px;">
                            <h5 class="fw-bold mb-3 blue-text">Доставка в день заказа</h5>
                            <p class="w-75 blue-text">Закажите до 11.00</p>
                            <img src="img/under_slider/block3.png" alt="Машина" class="position-absolute bottom-0 end-0 mb-3 me-3" style="height: 120px;">
                          </div>
                        </div>
                    </div>
                  </div>

                <div class="container my-5">
                  <div class="row mb-4">
                    <div class="col-md-3 text-muted small">Наш ассортимент</div>
                    <div class="col-md-9">
                      <h2 class="fw-bold fs-4 fs-md-2">
                        Компания предлагает более 500 наименований рыбной продукции и разнообразных товаров питания
                      </h2>
                    </div>
                  </div>

                  <!-- Desktop and Tablet Layout -->
                  <div class="row g-3">
                      <div class="row mt-4">
                          <?php
                          // --- 1. ЛОГИКА ПОДГОТОВКИ ДАННЫХ (в начало index.php) ---
                          require_once 'db.php';

                          $params = [];
                          $where = [];

                          // Поиск по названию
                          if (!empty($_GET['search'])) {
                              $where[] = "products.name LIKE ?";
                              $params[] = '%' . $_GET['search'] . '%';
                          }

                          // Фильтрация по категории (id_product_type)
                          if (!empty($_GET['category'])) {
                              $where[] = "products.type_id = ?";
                              $params[] = $_GET['category'];
                          }

                          $sql = "SELECT * FROM products";
                          if (!empty($where)) {
                              $sql .= " WHERE " . implode(" AND ", $where);
                          }

                          // Сортировка (учитываем, что price в БД — VARCHAR, преобразуем в число)
                          $sort = $_GET['sort'] ?? 'default';
                          switch ($sort) {
                              case 'price_asc':  $sql .= " ORDER BY CAST(price AS DECIMAL(10,2)) ASC"; break;
                              case 'price_desc': $sql .= " ORDER BY CAST(price AS DECIMAL(10,2)) DESC"; break;
                              default:           $sql .= " ORDER BY id_products DESC"; break;
                          }

                          $stmt = $pdo->prepare($sql);
                          $stmt->execute($params);
                          ?>

                          <div class="shop-controls mb-4">
                              <form action="index.php" method="GET" class="row g-3">
                                  <div class="col-md-4">
                                      <input type="text" name="search" class="form-control" placeholder="Поиск товара..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                  </div>
                                  <div class="col-md-3">
                                      <select name="category" class="form-select" onchange="this.form.submit()">
                                          <option value="">Все категории</option>
                                          <?php
                                          $types = $pdo->query("SELECT * FROM product_type")->fetchAll();
                                          foreach ($types as $t) {
                                              $sel = ($_GET['category'] ?? '') == $t['id_product_type'] ? 'selected' : '';
                                              echo "<option value='{$t['id_product_type']}' $sel>{$t['name']}</option>";
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-3">
                                      <select name="sort" class="form-select" onchange="this.form.submit()">
                                          <option value="default">Сортировка</option>
                                          <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Дешевле</option>
                                          <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Дороже</option>
                                      </select>
                                  </div>
                              </form>
                          </div>

                          <div class="row">
                              <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                  <div class="col-md-4">
                                      <div class="card"> <img src="img/products/<?= $row['img'] ?>" class="card-img-top">
                                          <div class="card-body">
                                              <h5><?= htmlspecialchars($row['name']) ?></h5>
                                              <p><?= $row['price'] ?> BYN</p>
                                              <button class="add-to-cart btn btn-primary" data-id="<?= $row['id_products'] ?>">В корзину</button>
                                          </div>
                                      </div>
                                  </div>
                              <?php endwhile; ?>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                <!-- ФОРМА ДЛЯ ЗАПОЛНЕНИЯ -->
              <div class="container-fluid form1">
                <div class="container fr">
                  <div class="row justify-content-center">
                    <div class="col-lg-10"> <!-- Занимает 10 из 12 колонок -->
                      <div class="form-title">Получите индивидуальное коммерческое предложение для вашего бизнеса</div>
                      <form id="businessForm" class="form-box row g-4 needs-validation" novalidate>
  <!-- Левая колонка -->
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">
                              <span class="step-number">1</span> Ваша ниша
                            </label>
                            <select class="form-select" required>
                              <option selected disabled value="">Выберите</option>
                              <option>Оптовик</option>
                              <option>Ресторан</option>
                              <option>Магазин</option>
                            </select>
                            <div class="invalid-feedback">
                              Пожалуйста, выберите вариант из выпадающего списка.
                            </div>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">
                              <span class="step-number">2</span> Способ получения
                            </label>
                            <select class="form-select" required>
                              <option selected disabled value="">Выберите</option>
                              <option>Доставка по МСК или МО</option>
                              <option>Самовывоз</option>
                            </select>
                            <div class="invalid-feedback">
                              Пожалуйста, выберите вариант из выпадающего списка.
                            </div>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">
                              <span class="step-number">3</span> Ваши объемы закупки
                            </label>
                            <select class="form-select" required>
                              <option selected disabled value="">Выберите</option>
                              <option>от 10 000 ₽ до 25 000 ₽</option>
                              <option>от 25 000 ₽ до 50 000 ₽</option>
                              <option>более 50 000 ₽</option>
                            </select>
                            <div class="invalid-feedback">
                              Пожалуйста, выберите вариант из выпадающего списка.
                            </div>
                          </div>
                        </div>

                        <!-- Правая колонка -->
                        <div class="col-lg-6">
                          <h5 class="mb-3">Контактные данные</h5>
                          <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Имя и фамилия" required />
                            <div class="invalid-feedback">
                              Введите имя и фамилию.
                            </div>
                          </div>
                          <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email" required />
                            <div class="invalid-feedback">
                              Введите корректный email.
                            </div>
                          </div>
                          <div class="mb-3">
                            <input type="tel" class="form-control" placeholder="Номер телефона" required pattern="^\+?\d{10,}$" />
                            <div class="invalid-feedback">
                              Введите корректный номер телефона.
                            </div>
                          </div>
                          <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree" checked required />
                            <label class="form-check-label" for="agree">
                              Подтверждаю своё согласие на обработку и хранение моих персональных данных
                            </label>
                          </div>
                          <button type="submit" class="my-yellow-btn fw-semibold glow-on-hover">Получить</button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>


                <div class="container my-5">
                  <div class="row align-items-start">
                    <!-- Левая часть: надпись "Отзывы" -->
                    <div class="col-md-4">
                      <small class="text-muted">Отзывы</small>
                    </div>

                    <!-- Правая часть: заголовок, подпись и блок отзыва -->
                    <div class="col-md-8">
                      <h2 class="blue-text fw-bold mb-2">Отзывы наших покупателей</h2>
                      <p class="mb-4 col-md-6 blue-text">Прочитайте реальные отзывы прямо на сайте или оставьте его на Яндекс.Картах</p>

                      <div class="review-card">
                        <div class="d-flex  justify-content-between flex-wrap">
                          <!-- Левая часть отзыва -->
                          <div class="mb-3">
                            
                            <div class="blue-text fw-semibold">Экор</div>
                            <div class="rating">4,7</div>
                            
                            <div class="text-warning mb-2">★★★★★</div>
                            <small class="blue-text">77 отзывов / 169 оценок</small><br>
                            <button class="yellow-btn mt-3 blue-text" data-bs-toggle="tooltip" title="Нам важно ваше мнение!">Оставить отзыв</button>
                          </div>

                          <!-- Правая часть отзыва -->
                          <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                              <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" width="40" class="rounded-circle me-2" alt="User">
                              <div>
                                <strong>Artem Chugarov</strong><br>
                                <small class="text-muted">17 июля</small>
                              </div>
                            </div>
                            <div>
                              <div class="text-warning mb-2">★★★★★</div>
                              <p class="text-muted mb-0" style="max-width: 450px;">
                                Продукция, поставляемая компанией ЭКОР, всегда соответствует высоким стандартам качества. Свежесть, вкус и безопасность — основные критерии при выборе продуктов для нашего меню, и компания ЭКОР полностью соответствует этим требованиям...
                              </p>
                              <a href="#" class="small text-primary mt-1 d-inline-block">Подробнее</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="container my-5">
                  <!-- Форма сотрудничества -->
                  <div class="row collab-section">
                    <div class="col-md-6 p-0">
                      <img src="img/form/img-2.png" alt="Продукт" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="col-md-6 collab-form">
                      <h3 class="blue-text fw-bold mb-4">Оставьте заявку<br>на сотрудничество</h3>
                        <form id="collabForm" action="send_collab.php" method="POST" novalidate>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Имя" required />
                                <div class="invalid-feedback">
                                    Пожалуйста, введите имя.
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control" placeholder="Номер телефона" required pattern="^\+?\d{10,}$" />
                                <div class="invalid-feedback">
                                    Введите корректный номер телефона.
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required />
                                <div class="invalid-feedback">
                                    Введите корректный email.
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="agree2" required />
                                <label class="form-check-label" for="agree2">
                                    Подтверждаю своё согласие на обработку и хранение моих персональных данных...
                                </label>
                                <div class="invalid-feedback">
                                    Необходимо подтвердить согласие.
                                </div>
                            </div>

                            <button type="submit" class="my-yellow-btn fw-semibold gradient-hover-btn">Отправить</button>
                        </form>
                    </div>
                  </div>
                </div>

                <!-- БЛОК С КАРТОЙ -->
                <section id="offices" class="py-5 bg-light">
                  <div class="container">
                    <h2 class="fw-bold blue-text mb-4">Контакты</h2>
                    <hr>

                    <div class="row align-items-start">
                      <!-- Левая колонка -->
                      <div class="col-lg-5">
                        <p class="fw-bold text-primary">Центральный офис</p>
                        <p class="mb-1">г. Москва, Открытое шоссе, 13, стр. 1</p>
                        <p class="mb-1">8 (800) 505-01-82, +7 (495) 637-82-28</p>
                        <p class="mb-1">Пн–Пт: 9:00–17:00</p>
                        <p class="mb-0">Сб–Вс: выходной</p>
                      </div>

                      <!-- Правая колонка: Карта -->
                      <div class="col-lg-7 mt-4 mt-lg-0">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A..." width="100%" height="300" frameborder="0" class="rounded shadow"></iframe>
                      </div>
                    </div>
                  </div>
                </section>
                <nav aria-label="Page navigation example" class="mt-4">
                  <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                      <a class="page-link">&laquo;</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item active">
                      <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#">&raquo;</a>
                    </li>
                  </ul>
                </nav>



                <footer class="header-desktop text-white py-5">
                  <div class="container">
                    <div class="row gy-4">

                      <!-- ЛОГО + ИНФО -->
                      <div class="col-lg-4 col-md-6">
                        <a href="/" class="d-inline-block mb-3  footer-icon-link" aria-label="Главная страница">
                          <img src="img/footer/logo.png" alt="Экор" class="img-fluid mb-2" style="max-width: 100px;">
                          <img src="img/footer/text.png" alt="Экор" class="img-fluid mb-2" style="max-width: 150px;">
                        </a>
                      
                        <p>Адрес: г. Москва, Открытое шоссе, 13, стр. 1</p>
                        <p>Email: <a href="mailto:info@ekorfish.ru" class="text-white footer-link">info@ekorfish.ru</a></p>
                        <p class="fw-bold">+7 (495) 637-82-28</p>
                        <div class="d-flex gap-3 mt-3">
                          <a href="#" class="footer-icon-link" aria-label="Telegram">
                            <img src="img/footer/tg.png" alt="Telegram" class="img-fluid" style="max-width: 40px;">
                          </a>
                          <a href="#" class="footer-icon-link" aria-label="WhatsApp">
                            <img src="img/footer/watsup.png" alt="WhatsApp" class="img-fluid" style="max-width: 40px;">
                          </a>
                        </div>
                      </div>

                      <!-- Колонка 1 -->
                      <div class="col-lg-2 col-md-6">
                        <p class="text-secondary">Покупателям</p>
                        <ul class="list-unstyled">
                          <li><a href="#" class="text-white footer-link">Прайс</a></li>
                          <li><a href="#" class="text-white footer-link">Доставка</a></li>
                          <li><a href="#" class="text-white footer-link">Чат-бот</a></li>
                          <li><a href="#" class="text-white footer-link">Производство</a></li>
                          <li><a href="#" class="text-white footer-link">Контакты</a></li>
                        </ul>
                      </div>

                      <!-- Колонка 2 -->
                      <div class="col-lg-3 col-md-6">
                        <p class="text-secondary">Каталог</p>
                        <ul class="list-unstyled">
                          <li><a href="#" class="text-white footer-link">Свежемороженая рыба</a></li>
                          <li><a href="#" class="text-white footer-link">Филе рыбы, стейки, фарш</a></li>
                          <li><a href="#" class="text-white footer-link">Морепродукты</a></li>
                          <li><a href="#" class="text-white footer-link">Фасованная рыба Экор</a></li>
                          <li><a href="#" class="text-white footer-link">Полуфабрикаты</a></li>
                        </ul>
                      </div>

                      <!-- Колонка 3 -->
                      <div class="col-lg-3 col-md-6">
                        <h5>&nbsp;</h5>
                        <ul class="list-unstyled">
                          <li><a href="#" class="text-white footer-link">Готовая продукция Экор</a></li>
                          <li><a href="#" class="text-white footer-link">Мясо, птица</a></li>
                          <li><a href="#" class="text-white footer-link">Замороженные продукты</a></li>
                          <li><a href="#" class="text-white footer-link">Консервы</a></li>
                          <li><a href="#" class="text-white footer-link">Продукты питания оптом</a></li>
                          <li><a href="#" class="text-white footer-link">Карта сайта</a></li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </footer>
        </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <ul class="nav nav-tabs w-100" id="authTab" role="tablist">
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <button class="nav-link active w-100 fw-bold" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-panel" type="button">Вход</button>
                        </li>
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <button class="nav-link w-100 fw-bold" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-panel" type="button">Регистрация</button>
                        </li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="tab-content" id="authTabContent">
                    <div class="tab-pane fade show active p-4" id="login-panel" role="tabpanel">
                        <form action="auth.php" method="POST">
                            <input type="text" name="login" class="form-control mb-3" placeholder="Логин" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Пароль" required>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Войти</button>
                        </form>
                    </div>
                    <div class="tab-pane fade p-4" id="register-panel" role="tabpanel">
                        <form action="register.php" method="POST">
                            <div class="row">
                                <div class="col-6"><input type="text" name="lastname" class="form-control mb-3" placeholder="Фамилия" required></div>
                                <div class="col-6"><input type="text" name="firstname" class="form-control mb-3" placeholder="Имя" required></div>
                            </div>
                            <input type="text" name="surname" class="form-control mb-3" placeholder="Отчество">
                            <input type="email" name="e_mail" class="form-control mb-3" placeholder="E-mail" required>
                            <input type="text" name="login" class="form-control mb-3" placeholder="Придумайте логин" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Пароль" required>
                            <button type="submit" class="btn btn-success w-100 fw-bold">Зарегистрироваться</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>













<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        // Этот код должен быть именно в .php файле, чтобы сервер обработал PHP
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        function simpleAddToCart(productId) {
            // Отправляем запрос на добавление
            fetch('add_to_cart.php?id=' + productId)
                .then(response => {
                    // Если PHP вернул редирект или успех
                    if (response.ok) {
                        // Показываем простое уведомление
                        alert('Товар добавлен! Количество можно изменить в корзине.');

                        // Если у вас есть счетчик на иконке корзины, можно обновить страницу
                        // location.reload();
                    }
                })
                .catch(error => console.error('Ошибка:', error));
        }
    </script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
  </body>
</html>
