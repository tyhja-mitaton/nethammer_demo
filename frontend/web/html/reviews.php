<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php include 'head.php'; ?>
        <title>Отзывы</title>
    </head>

    <body>
       
        <?php include 'header.php'; ?>

        <div class="reviews-page">
            
            <div class="container">
                <h1 class="page-title">Отзывы</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="html/index.php">Главная</a></li>
                        <li class="breadcrumb-item active">Отзывы</li>
                    </ol>
                </nav>
            </div>
            
            <div class="container">
                <button class="btn btn-blue-o" type="button" data-toggle="modal" data-target="#modal">Оставить отзыв</button>
            </div>
            
            <div class="container-fluid">
                <div class="reviews-slider">
                    <?php for($i = 0; $i < 6; $i++) { ?>
                    <div class="item">
                        <div class="d-flex align-items-center">
                            <img src="images/review.png" alt="">
                            <div class="name">
                                Имя или организация
                                <div>15.05.2005</div>
                            </div>
                        </div>
                        <div class="text">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <?php include 'contact-us.php'; ?>
            
        </div>

        <?php include 'footer.php'; ?>
            
    </body>
</html>