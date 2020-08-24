<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php include 'head.php'; ?>
        <title>Кейсы</title>
    </head>

    <body>
       
        <?php include 'header.php'; ?>

        <div class="cases-page">
            
            <div class="container">
                <h1 class="page-title">Кейсы</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="html/index.php">Главная</a></li>
                        <li class="breadcrumb-item active">Кейсы</li>
                    </ol>
                </nav>
            </div>
            
            <div class="cases-filter-box">
                <div class="container">
                    <div class="cases-filter">
                        <input type="checkbox" id="ch1" hidden checked>
                        <label for="ch1">Design</label>
                        <input type="checkbox" id="ch2" hidden>
                        <label for="ch2">Photography</label>
                        <input type="checkbox" id="ch3" hidden>
                        <label for="ch3">Digital Arts</label>
                    </div>
                </div>
            </div>
               
            <div class="cases-list">
                <div class="case">
                    <div class="container">
                        <p class="title">Название проекта</p>
                    </div>
                    <div class="case-slider">
                        <?php for($i = 0; $i < 6; $i++) { ?>
                        <div class="item">
                            <img src="images/case.png" alt="">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="case-text">
                        <p><b>О проекте</b></p>
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                    </div>
                </div>

                <div class="case">
                    <div class="container">
                        <p class="title">Название проекта</p>
                    </div>
                    <div class="case-slider">
                        <?php for($i = 0; $i < 6; $i++) { ?>
                        <div class="item">
                            <img src="images/case.png" alt="">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="case-text">
                        <p><b>О проекте</b></p>
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>