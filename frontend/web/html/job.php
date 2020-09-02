<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php include 'head.php'; ?>
        <title>Вакансии</title>
    </head>

    <body>
           
        <?php include 'header.php'; ?>
            
        <div class="job-page">
            
            <div class="container">
                <h1 class="page-title">Вакансии</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Главная</a></li>
                        <li class="breadcrumb-item active">Вакансии</li>
                    </ol>
                </nav>
            </div>
            
            <section class="job-list">
                <div class="container">
                    <div class="accordion" id="vacancies">
                        <div class="vacancy">
                            <h2 class="job-title" data-toggle="collapse" data-target="#vacancy<?= $i ?>">
                                Frontend-разработчик <span>45 000 руб</span>
                            </h2>
                            <div id="vacancy<?= $i ?>" class="collapse show" data-parent="#vacancies">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                        <?php for($i = 0; $i < 3; $i++) { ?>
                        <div class="vacancy">
                            <h2 class="job-title" data-toggle="collapse" data-target="#vacancy<?= $i ?>">
                                Вакансия <?= $i ?> <span>45 000 руб</span>
                            </h2>
                            <div id="vacancy<?= $i ?>" class="collapse" data-parent="#vacancies">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            
            <?php include 'contact-us.php'; ?>  
               
        </div>       

        <?php include 'footer.php'; ?>
        
    </body>
</html>