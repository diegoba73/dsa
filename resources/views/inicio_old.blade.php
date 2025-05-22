<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>DSA</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="{{ asset('argon') }}/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">

  <!-- Custom fonts for this template -->
  <link href="{{ asset('argon') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="{{ asset('css/agency.min.css') }}" rel="stylesheet">

  <!-- Favicon -->
  <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">

</head>

<body id="page-top">
@csrf
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Dirección Salud Ambiental</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul style="background-color:#00d0ff" class="navbar-nav text-uppercase ml-auto rounded-lg">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#dpto">Departamentos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#doc">Documentos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contacto</a>
          </li>
          <li class="nav-item">
            @if (Route::has('login'))
                @auth
                <a class="nav-link js-scroll-trigger" href="{{ url('/lab/muestras/index') }}">Inicio</a>
                @else
                <a class="nav-link js-scroll-trigger" href="{{ route('login') }}">Ingreso a Sistema</a>
                @endauth
            @endif
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
        <div class="intro-lead-in">Bienvenido!</div>
        <div class="intro-heading text-uppercase">Dirección Provincial de Salud Ambiental</div>
        <h2>Ministerio de Salud - Provincia del Chubut</h2>
        <img src="{{ asset('argon') }}/img/brand/escudo2.png" class="navbar-brand-img" alt="Chubut">
      </div>
    </div>
  </header>

  <!-- Departamentos -->
  <section class="bg-light page-section" id="dpto">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Departamentos</h2>
          <h3 class="section-subheading text-muted">La Dirección está integrada por 4 Departamentos.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-flask fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Departamento Laboratorio</h4>
            <p class="text-muted">Jefe Germán Marino</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
            </ul>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="#portfolio">Servicios</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-success"></i>
            <i class="fas fa-tint fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Saneamiento Básico</h4>
            <p class="text-muted">Jefa Ing. Mariana Bellini</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
            </ul>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="#dsb">Servicios</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-info"></i>
            <i class="fas fa-utensils fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Departamento Bromatología</h4>
            <p class="text-muted">Jefe Diego Saban</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
            </ul>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="#db">Servicios</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-hard-hat fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Departamento Salud Ocupacional</h4>
            <p class="text-muted">Jefa Mariana Bellini</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
            </ul>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="#dso">Servicios</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Laboratorio -->
  <section class="bg-light page-section mt-0" id="portfolio">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Laboratorio</h2>
          <h3 class="section-subheading text-muted">El Laboratorio Provincial de la Dirección de Salud Ambiental está constituido por 5 áreas de ensayos, las cuales brindan un servicio de calidad analítica siguiendo los estándares mundiales de las Normas ISO. Éstas áreas son:</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal1">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/01-thumbnail.jpg" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Cromatografía</h4>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal2">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/02-thumbnail.jpg" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Química de Alimentos</h4>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal3">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/03-thumbnail.jpg" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Química de Aguas</h4>
          </div>
        </div>
        </div>
        <div class="row justify-content-around">
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" data-toggle="modal" href="#portfolioModal4">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-plus fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/portfolio/04-thumbnail.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Ensayos Biológicos</h4>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" data-toggle="modal" href="#portfolioModal5">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-plus fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/portfolio/05-thumbnail.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Microbiología</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- DSB -->
  <section class="page-section" id="dsb">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Saneamiento Básico</h2>
          <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-success"></i>
            <i class="fas fa-flask fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Monitoreo sanitario de Agua de Red</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-success"></i>
            <i class="fas fa-tint fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Monitoreo Agua Superficiales</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-success"></i>
            <i class="fas fa-utensils fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Control de Plagas</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-success"></i>
            <i class="fas fa-hard-hat fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Asesoramiento</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Bromatología -->
  <section class="page-section" id="db">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Bromatología</h2>
          <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-info"></i>
            <i class="fas fa-flask fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Trámites de Inscripción de Registros</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-info"></i>
            <i class="fas fa-tint fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Capacitaciones</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-info"></i>
            <i class="fas fa-utensils fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Intoxicaciones y Denuncias</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-info"></i>
            <i class="fas fa-hard-hat fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Datos Públicos</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- DSO -->
  <section class="page-section" id="dso">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Salud Ocupacional</h2>
          <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-flask fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Seguridad Laboral</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-tint fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Capacitaciones</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-utensils fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Datos Públicos</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-hard-hat fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Higiene Laboral</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Documentos -->
  <section class="page-section" id="doc">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Documentos</h2>
          <h3 class="section-subheading text-muted">En esta sección podrá encontrar Formularios, Manuales y toda documentación generada por la DPSA.</h3>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-book fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Manual Salud Ambiental</h4>
          <button style= "border: none;"><a href="archivos_dpsa/TCST.pdf" download>Descargar archivo</a></button>
        </div>
<!--         <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-tint fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Formulario</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-utensils fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Documento 1</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div>
        <div class="col-md-3">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-hard-hat fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Documento 2</h4>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
        </div> -->
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section class="page-section" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
        <h1 class="section-subheading text-muted">Dirección Provincial de Salud Ambiental</h1>
          <h2 class="section-heading text-uppercase">Berwyn 226 - Trelew - Chubut</h2>
          <h2 class="section-heading text-uppercase">Tel/Fax: 0280 - 4421011/4427421</h2>
          <img src="{{ asset('argon') }}/img/brand/escudo3.png" class="navbar-brand-img" alt="Chubut">
          <div class="col-md-12">

          <ul class="list-inline social-buttons">
            <li class="list-inline-item">
              <a href="#">
                <i class="fas fa-envelope"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
          </ul>
        </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        &copy; {{ now()->year }} <a href="https://plandigital.com.ar" class="font-weight-bold ml-1" target="_blank">PlanDigital</a>
        </div>
      </div>
    </div>
  </footer>

 <!-- Modal Croma -->
 <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Cromatografía</h2>
                <p class="item-intro text-muted">Departamento Provincial de Laboratorio de la D.P.S.A.</p>
                <p>La cromatografía es esencial en el análisis de aguas y alimentos, permitiendo la detección precisa de contaminantes, nutrientes y aditivos. Garantiza la seguridad alimentaria, la calidad del agua y el cumplimiento de normativas, siendo crucial para la protección de la salud pública y la investigación alimentaria.</p>
                <table class="table table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Ensayo</th>
                      <th scope="col">Tipo Ensayo</th>
                      <th scope="col">Método</th>
                      <th scope="col">Procedimiento</th>
                      <th scope="col">Matriz</th>
                      <th scope="col">Costo</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($crom_ensayos as $crom_ensayo)
                      <tr>
                          <td>{{ $crom_ensayo->codigo}}</td>
                          <td>{{ $crom_ensayo->ensayo}}</td>
                          <td>{{ $crom_ensayo->tipo_ensayo}}</td>
                          <td>{{ $crom_ensayo->metodo}}</td>
                          <td>{{ $crom_ensayo->norma_procedimiento}}</td>
                          <td>{{ $crom_ensayo->matriz}}</td>
                          <td>{{ $crom_ensayo->costo}}</td>
                      </tr>
                  @endforeach
                  </tbody>
                </table>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                  Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal QcaAlim -->
  <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Química de Alimentos</h2>
                <p class="item-intro text-muted">Departamento Provincial de Laboratorio de la D.P.S.A.</p>
                <p>El análisis químico de alimentos desvela su composición, seguridad y calidad. Permite detectar contaminantes, evaluar nutrientes esenciales y garantizar cumplimiento de regulaciones sanitarias. Así, asegura alimentos seguros, nutritivos y de alta calidad, beneficiando la salud pública y la confianza del consumidor.</p>
                <table class="table table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Ensayo</th>
                      <th scope="col">Tipo Ensayo</th>
                      <th scope="col">Método</th>
                      <th scope="col">Procedimiento</th>
                      <th scope="col">Matriz</th>
                      <th scope="col">Costo</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($qal_ensayos as $qal_ensayo)
                      <tr>
                          <td>{{ $qal_ensayo->codigo}}</td>
                          <td>{{ $qal_ensayo->ensayo}}</td>
                          <td>{{ $qal_ensayo->tipo_ensayo}}</td>
                          <td>{{ $qal_ensayo->metodo}}</td>
                          <td>{{ $crom_ensayo->norma_procedimiento}}</td>
                          <td>{{ $qal_ensayo->matriz}}</td>
                          <td>{{ $qal_ensayo->costo}}</td>
                      </tr>
                  @endforeach
                  </tbody>
                </table>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                   Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal QcaAgua -->
  <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Química de Aguas</h2>
                <p class="item-intro text-muted">Departamento Provincial de Laboratorio de la D.P.S.A.</p>
                <p>El análisis de aguas, a través de la química, proporciona una evaluación precisa de la calidad del agua. Esto asegura la detección temprana de contaminantes, garantizando agua potable segura y la protección de ecosistemas acuáticos. Además, impulsa la gestión eficiente de recursos hídricos y promueve la salud pública.</p>
                <table class="table table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Ensayo</th>
                      <th scope="col">Tipo Ensayo</th>
                      <th scope="col">Método</th>
                      <th scope="col">Procedimiento</th>
                      <th scope="col">Matriz</th>
                      <th scope="col">Costo</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($qag_ensayos as $qag_ensayo)
                      <tr>
                          <td>{{ $qag_ensayo->codigo}}</td>
                          <td>{{ $qag_ensayo->ensayo}}</td>
                          <td>{{ $qag_ensayo->tipo_ensayo}}</td>
                          <td>{{ $qag_ensayo->metodo}}</td>
                          <td>{{ $crom_ensayo->norma_procedimiento}}</td>
                          <td>{{ $qag_ensayo->matriz}}</td>
                          <td>{{ $qag_ensayo->costo}}</td>
                      </tr>
                  @endforeach
                  </tbody>
                </table>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                  Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal EBiol -->
  <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Ensayos Biológicos</h2>
                <p class="item-intro text-muted">Departamento Provincial de Laboratorio de la D.P.S.A.</p>
                <p>El análisis de alimentos, mediante ensayos biológicos, como la detección de toxinas marinas y Trichinella spiralis, es crucial para garantizar la seguridad y calidad de los productos. Estos ensayos identifican riesgos potenciales, previenen intoxicaciones y aseguran alimentos saludables, contribuyendo a la protección de la salud pública y la confianza del consumidor.</p>
                <table class="table table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Ensayo</th>
                      <th scope="col">Tipo Ensayo</th>
                      <th scope="col">Método</th>
                      <th scope="col">Procedimiento</th>
                      <th scope="col">Matriz</th>
                      <th scope="col">Costo</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($eb_ensayos as $eb_ensayo)
                      <tr>
                          <td>{{ $eb_ensayo->codigo}}</td>
                          <td>{{ $eb_ensayo->ensayo}}</td>
                          <td>{{ $eb_ensayo->tipo_ensayo}}</td>
                          <td>{{ $eb_ensayo->metodo}}</td>
                          <td>{{ $crom_ensayo->norma_procedimiento}}</td>
                          <td>{{ $eb_ensayo->matriz}}</td>
                          <td>{{ $eb_ensayo->costo}}</td>
                      </tr>
                  @endforeach
                  </tbody>
                </table>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                  Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Micro -->
  <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Microbiología</h2>
                <p class="item-intro text-muted">Departamento Provincial de Laboratorio de la D.P.S.A.</p>
                <p>El análisis microbiológico de alimentos es esencial para garantizar la seguridad y calidad de los productos que consumimos. Detecta microorganismos patógenos, previene enfermedades transmitidas por alimentos y asegura el cumplimiento de estándares sanitarios, protegiendo la salud pública y respaldando la industria alimentaria en la producción de alimentos seguros y saludables.</p>
                <table class="table table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Ensayo</th>
                      <th scope="col">Tipo Ensayo</th>
                      <th scope="col">Método</th>
                      <th scope="col">Procedimiento</th>
                      <th scope="col">Matriz</th>
                      <th scope="col">Costo</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($micro_ensayos as $micro_ensayo)
                      <tr>
                          <td>{{ $micro_ensayo->codigo}}</td>
                          <td>{{ $micro_ensayo->ensayo}}</td>
                          <td>{{ $micro_ensayo->tipo_ensayo}}</td>
                          <td>{{ $micro_ensayo->metodo}}</td>
                          <td>{{ $crom_ensayo->norma_procedimiento}}</td>
                          <td>{{ $micro_ensayo->matriz}}</td>
                          <td>{{ $micro_ensayo->costo}}</td>
                      </tr>
                  @endforeach
                  </tbody>
                </table>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                  Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="{{ asset('argon') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="{{ asset('js/jqBootstrapValidation.js') }}" ></script>
  <script src="{{ asset('js/contact_me.js') }}" ></script>


  <!-- Custom scripts for this template -->
  <script src="{{ asset('js/agency.min.js') }}" ></script>

</body>

</html>
