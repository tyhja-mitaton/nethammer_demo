<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php include 'head.php'; ?>
        <title>Страница продукта</title>
    </head>

    <body>
        <div class="product-page">
            <?php include 'header.php'; ?>
            
            <div class="container">
                <h1 class="page-title">Продукты</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="html/index.php">Главная</a></li>
                        <li class="breadcrumb-item"><a href="html/products.php">Продукты</a></li>
                        <li class="breadcrumb-item active">Страница продукта</li>
                    </ol>
                </nav>
            </div>
            
            <div class="content">
                <div class="container">
                    <div class="product-top">
                        <h2 class="subtitle">Система управления планами развития муниципальных образований и регионов</h2>
                        <div class="text">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</div>
                        <img class="main-img" data-fancybox="gallery" src="images/screen.jpg" alt="">
                    </div>
                    
                    <div class="product-slider">
                        <?php for($i = 0; $i < 12; $i++) { ?>
                        <a class="img" href="images/screen.jpg">
                            <img data-fancybox="gallery" src="images/screen.jpg" alt="">
                        </a>
                        <?php } ?>
                    </div>
                    
                    <button class="btn btn-blue-o" type="button">
                        Оставить заявку <i>→</i>
                    </button>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>