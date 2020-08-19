<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <a class="logo" href="index.php">
                    <img src="images/logo.png" alt="">
                </a>
                <form class="search-form d-block d-lg-none">
                    <input type="text" placeholder="Поиск">
                    <button type="button">
                        <img src="images/search.png" alt="">
                    </button>
                </form>
                <ul class="footer-menu">
                    <li><a href="#">Главная</a></li>
                    <li>
                        <a href="#">О компании</a>
                        <ul>
                            <li><a href="#">Кейсы</a></li>
                            <li><a href="html/job.php">Вакансии</a></li>
                            <li><a href="#">Отзывы</a></li>
                        </ul>
                    </li>
                    <li><a href="html/products.php">Продукты</a></li>
                    <li><a href="html/services.php">Услуги</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <ul class="social">
                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Модальное окно -->

<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p><b>Оставить заявку</b></p>
            </div>
            <div class="modal-body">
                <form>
                    <input type="text" placeholder="Введите Имя">
                    <input type="text" placeholder="+7 (" data-inputmask="'mask':'+7 (999) 999-9999'" data-mask>
                    <div class="checkbox">
                        <input type="checkbox" id="agree2"> <label class="gray" for="agree2">Я принимаю условия <a href="#" data-toggle="modal" data-target="#modal2">пользовательского соглашения</a></label>
                    </div>
                    <div class="text-center">
                        <button class="red-btn">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Скрипты -->

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="js/scripts.js"></script>