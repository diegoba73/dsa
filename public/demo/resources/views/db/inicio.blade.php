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
  <link href="{{ asset('css/broma.min.css') }}" rel="stylesheet">

  <!-- Favicon -->
  <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Departamento Provincial de Bromatología</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul style="background-color:#00d0ff" class="navbar-nav text-uppercase ml-auto rounded-lg">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contactos</a>
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
        <div class="intro-heading text-uppercase">Departamento Provincial de Bromatología</div>
        <h2>Ministerio de Salud - Provincia del Chubut</h2>
        <img src="{{ asset('argon') }}/img/brand/escudo2.png" class="navbar-brand-img" alt="Chubut">
      </div>
    </div>
  </header>

  <!-- Bromatología -->
  <section class="bg-light page-section" id="dpto">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Documentos</h2>
          <h3 class="section-subheading text-muted">Archivos del Departamento.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-gavel fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Resolución SIFEGA</h4>
            <p class="text-muted">Documento sobre la Resolución que establece al SiFeGA como sistema de Gestión para Inscripción de Establecimientos y Productos</p>

            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/resolucion_sifega.pdf" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-id-card-alt fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Alta Usuario</h4>
            <p class="text-muted">Documento sobre cómo dar de Alta un Usuario para gestionar trámites dentro de SiFeGA</p>

            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/alta_usuario.pdf" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-book fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Directrices Autorización de Establecimientos</h4>
            <p class="text-muted">Directrices para la Autorización Sanitaria de Establecimientos, donde se establecen todos los principios y leyes para la autorización de los mismos.</p>

            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/directrices_aut_est.pdf" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-file-signature fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Inscripción Establecimiento y Productos (ACOTADO - SiFeGA)</h4>
            <p class="text-muted">Documento sobre instructivo para la inscripción de Establecimiento por SiFeGA.</p>

            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/inscripcion_sifega.pdf" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-file-signature fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Inscripción Productos (SiFeGA)</h4>
            <p class="text-muted">Instructivo para la inscripción de Productos por SiFeGA</p>

            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/instructivo_sifega.pdf" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-file-invoice fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Información Nutricional</h4>
            <p class="text-muted">Instructivo para la elaboración de la Información Nutricional obligatoria de los Productos Alimenticios, para su inscripción.</p>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/info_nutricional.pdf" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-search fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Consulta RNE Nacionales</h4>
            <p class="text-muted">Enlace a Sitio Web de Consulta sobre los Establecimientos Inscriptos a nivel Nacional</p>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="http://inal.sifega.anmat.gov.ar/consultadeRegistro/" target="_blank">Enlace</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-search fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Consulta RNPA Nacionales</h4>
            <p class="text-muted">Enlace a Sitio Web de Consulta sobre los Productos Alimenticios Inscriptos a nivel Nacional</p>
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="http://inal.sifega.anmat.gov.ar/consultadealimentos/" target="_blank">Enlace</a>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
          <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-search fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Categoría de Productos Alimenticios</h4>
            
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/categoria_productos.xlsx" target="_blank">Enlace</a>
            </div>
          </div>
          </div>
          <div class="col-sm-3">
          <div class="team-member">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-search fa-stack-1x fa-inverse"></i>
          </span>
            <h4>Presentación para Registros de Establecimientos y Productos Alimenticios</h4>
            
            <div class="list-group pt-2">
            <a class="btn btn-primary btn-sm js-scroll-trigger" href="archivos_broma/capacitacion_registros_empresas.pdf" target="_blank">Enlace</a>
            </div>
          </div>
          </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section class="page-section" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
        <h4 class="section-subheading text-muted">DEPARTAMENTO PROVINCIAL DE BROMATOLOGIA NIVEL CENTRAL</h4>
          <h5 class="section-heading text-uppercase">DIRECCIÓN: BERWIN 226, TRELEW</h5>
          <h5 class="section-heading text-uppercase">TELÉFONO: 0280 4427421 / 4421011</h5>
          <h5 class="section-heading text-uppercase">MAIL: BROMATOLOGIACHUBUT@GMAIL.COM</h5>
          <hr style="border-color:white;">
          <h4 class="section-subheading text-muted">DEPARTAMENTO DE BROMATOLOGÍA AREA PROGRAMATICA NORTE</h4>
          <h5 class="section-heading text-uppercase">DIRECCIÓN: AV. ROCA 743, PUERTO MADRYN</h5>
          <h5 class="section-heading text-uppercase">TELÉFONO: 0280 4470203</h5>
          <h5 class="section-heading text-uppercase">MAIL: SALUDAMBIENTALPM@GMAIL.COM</h5>
          <hr style="border-color:white;">
          <h4 class="section-subheading text-muted">DEPARTAMENTO ZONAL DE SALUD AMBIENTAL COMODORO RIVADAVIA</h4>
          <h5 class="section-heading text-uppercase">DIRECCIÓN: JESUS GARRÉ Y RUTA 3 (KM4), COMODORO RIVADAVIA</h5>
          <h5 class="section-heading text-uppercase">TELÉFONO: 0297 4559438</h5>
          <h5 class="section-heading text-uppercase">MAIL: SALUDAMBIENTAL_CR@YAHOO.COM.AR</h5>
          <hr style="border-color:white;">
          <h4 class="section-subheading text-muted">DEPARTAMENTO ZONAL DE SALUD AMBIENTAL ESQUEL</h4>
          <h5 class="section-heading text-uppercase">DIRECCIÓN: AV. FONTANA 1107, ESQUEL</h5>
          <h5 class="section-heading text-uppercase">TELEFONO: 02945 451428</h5>
          <h5 class="section-heading text-uppercase">EMAIL: SALUDAMBIENTALESQUEL@GMAIL.COM</h5>
          <hr style="border-color:white;">
          <h4 class="section-subheading text-muted">DELEGACION DEPARTAMENTO ZONAL DE SALUD AMBIENTAL EL HOYO</h4>
          <h5 class="section-heading text-uppercase">DIRECCIÓN: PASAJE CORBATA S/N - BARRIO ARRAYANES, EL HOYO</h5>
          <h5 class="section-heading text-uppercase">TELEFONO: 02944 471212</h5>
          <h5 class="section-heading text-uppercase">EMAIL: SALUDAMBIENTALELHOYO@GMAIL.COM</h5>
          <img src="{{ asset('argon') }}/img/brand/escudo3.png" class="navbar-brand-img" alt="Chubut">
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


</html>
