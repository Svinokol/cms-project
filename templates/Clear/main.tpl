<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        {headers}
        <link href="{template}/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="{template}/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link href="{template}/carousel.css" rel="stylesheet">
        <title>{title}</title>
    </head>

  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-default navbar-static-top" role="navigation">

          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">{title}</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Описание</a></li>
                <li><a href="#about">Документация</a></li>
                <li><a href="#contact">Примеры</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Скачать <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img style="background-size : contain; background: url('{template}/img/3.jpg'); background-position: center;" >
          <div class="container">
            <div class="carousel-caption">
              <h1>Начните вместе с нами!</h1>
              <p>Всё очень просто, сделайте маленький шаг навстречу, это начало большой и крепкой дружбы.</p>
              <p><a class="btn btn-lg btn-primary" href="?go=registration" role="button">Зарегистрироваться!</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img style="background-size : contain; background: url('{template}/img/2.jpg'); background-position: center;" >
          <div class="container">
            <div class="carousel-caption">
              <h1>Вы разработчик?</h1>
              <p>Ознакомьтесь с нашим development center.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Узнать больше</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img style="background-size : contain; background: url('{template}/img/1.jpg'); background-position: center;" >
          <div class="container">
            <div class="carousel-caption">
              <h1>Откройте для себя магазин приложений!</h1>
              <p>Более миллиона приложений ждут вас.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Открыть магазин</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->

    <div class="container marketing">

        {content}

    </div>

       <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>
    <script src="{template}/bootstrap/js/bootstrap.js"></script>
  </body>
</html>
