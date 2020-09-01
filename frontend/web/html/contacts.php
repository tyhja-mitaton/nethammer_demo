<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php include 'head.php'; ?>
        <title>Контакты</title>
    </head>

    <body>
       
        <?php include 'header.php'; ?>

        <div class="contact-page">
            
            <div class="container">
                <h1 class="page-title">Контакты</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="html/index.php">Главная</a></li>
                        <li class="breadcrumb-item active">Контакты</li>
                    </ol>
                </nav>
                
                <div class="row">
                    <div class="col-lg-5 pl-5 order-lg-1">
                        <div class="label">
                            <i class="fas fa-map-marker-alt"></i> Адрес:
                        </div>
                        <p>ул. Максима Горького, 155 Офис 105</p>
                        <div class="label">
                            <i class="fas fa-phone-alt"></i> Телефон:
                        </div>
                        <p><a href="tel:88003001805">8 800 300 1805</a></p>
                        <div class="label">
                            <img src="" alt=""> Соц сети:
                        </div>
                        <ul class="social">
                            <li><a href="#"><i class="fab fa-vk"></i></a></li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="map">
                            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A36ec7ffcc5d138de79fb44884189e254b0a7d3f1faffdbbe005792daff7a3743&amp;width=100%25&amp;height=360&amp;lang=ru_RU&amp;scroll=false"></script>
                        </div>
                    </div>
                </div>
            </div>           
            
            <?php include 'contact-us.php'; ?>
            
        </div>
        
        <?php include 'footer.php'; ?>
            
    </body>
</html>