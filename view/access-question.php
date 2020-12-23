<?php 
define('PATRH',dirname(dirname(dirname(dirname(__FILE__)))).'/');
define('PHPWG_ROOT_PATH','./../../../');
include_once( PATRH.'include/common.inc.php' );
//include(PATRH.'include/section_init.inc.php');

$title = stripslashes(urldecode($_GET['title']));
$image = urldecode($_GET['image']);

?>

<html dir="ltr" lang="de"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="Piwigo (aka PWG), see piwigo.org">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Fotos der Familie HKS mit ihrer Lumix">
	<meta property="og:type" content="article" />
	<meta property="og:url" content="https://fotos.xovatec.de<?php echo $_SESSION['pwg_familyaccess_forward_url']; ?>" />
	<meta property="og:site_name" content="Fotos der Familie HKS" />
	<meta property="og:description" content="Fotos der Familie HKS mit ihrer Lumix" />
    <title><?php echo $title; ?> | Fotos der Familie HKS</title>
    
    <?php if ($image != null) {
        $url = 'https://'.$_SERVER['SERVER_NAME'].$image;
        ?>
    <meta property="og:image" content="<?php echo $url;?>" />
    <?php } ?>
    <link rel="shortcut icon" type="image/x-icon" href="/themes/default/icon/favicon.ico">
    <link rel="icon" sizes="192x192" href="/themes/bootstrap_darkroom/img/logo.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/themes/bootstrap_darkroom/img/logo.png">
    <link rel="start" title="Startseite" href="/">
    <link rel="search" title="Suchen" href="/search.php">

<link rel="stylesheet" type="text/css" href="/_data/combined/fe3eoq.css">

</head>

<body id="theIdentificationPage">
<div id="wrapper">
        <nav class="navbar navbar-expand-lg navbar-main bg-dark navbar-dark">
            <div class="container">
                <a class="navbar-brand mr-auto" href="/">Fotos der Familie HKS</a>
                <!-- <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-menubar" aria-controls="navbar-menubar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-menubar">-->
<!-- Start of menubar.tpl -->
 <!--<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">                                                                                                                                                   
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Entdecken</a>
        <div class="dropdown-menu dropdown-menu-right" role="menu">
      <div class="dropdown-header">
        <form class="navbar-form" role="search" action="qsearch.php" method="get" id="quicksearch" onsubmit="return this.q.value!='' &amp;&amp; this.q.value!=qsearch_prompt;">
            <div class="form-group">
                <input type="text" name="q" id="qsearchInput" class="form-control" placeholder="Schnellsuche">
            </div>
        </form>
      </div>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="tags.php" title="Alle verf�gbaren Schlagw�rter anzeigen">Schlagw�rter
          <span class="badge badge-secondary ml-2">0</span>      </a>
      <a class="dropdown-item" href="search.php" title="Suchen" rel="search">Suchen
                </a>
      <a class="dropdown-item" href="comments.php" title="Die neuesten Kommentare anzeigen">Kommentare
          <span class="badge badge-secondary ml-2">0</span>      </a>
      <a class="dropdown-item" href="about.php" title="�ber Piwigo">Info
                </a>
      <a class="dropdown-item" href="notification.php" title="RSS-Feed" rel="nofollow">RSS-Feed
                </a>

            <div class="dropdown-divider"></div>
		<a class="dropdown-item" href="index.php?/most_visited" title="Die meist angesehenen Fotos anzeigen">Am h�ufigsten angesehen</a>
		<a class="dropdown-item" href="index.php?/recent_pics" title="Die neuesten Fotos anzeigen">Neueste Fotos</a>
		<a class="dropdown-item" href="index.php?/recent_cats" title="K�rzlich aktualisierte Alben anzeigen">Neueste Alben</a>
		<a class="dropdown-item" href="random.php" title="Fotos im Zufallsmodus anzeigen" rel="nofollow">Zuf�llige Fotos</a>
		<a class="dropdown-item" href="index.php?/created-monthly-calendar" title="Jeden Tag mit Fotos anzeigen, gegliedert nach Monat" rel="nofollow">Kalender</a>

        </div>
    </li>
<li id="categoriesDropdownMenu" class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Alben</a>
    <div class="dropdown-menu dropdown-menu-right" role="menu">
        <a class="dropdown-item" data-level="0" href="index.php?/category/ausflug-dasa-dortmund-vom-04012020">
            Ausflug DASA Dortmund vom 04.01.2020
            <span class="badge badge-secondary ml-2" title="80 Fotos in diesem Album">80</span>
        </a>
        <div class="dropdown-divider"></div>
        <div class="dropdown-header">80 Fotos</div>
    </div>
</li>




</ul>
<!-- End of menubar.tpl -->

                </div>-->
            </div>
        </nav>

        <div class="jumbotron mb-0">
            <div class="container">
                <div id="theHeader"><h1>Fotos der Familie HKS</h1>

<p>Willkommen!</p></div>
            </div>
        </div>




<!-- End of header.tpl -->
<nav class="navbar navbar-contextual navbar-expand-lg navbar-light bg-light sticky-top mb-5">
    <div class="container">
        <div class="navbar-brand mr-auto"><a href="/">Startseite</a> / <a href="">Zugang zur Familiengalerie</a></div>
        <ul class="navbar-nav justify-content-end">
                     </ul>
    </div>
</nav>

<div class="container">
    
</div>



<div class="container">
	<?php
		//$url = $_SERVER['REQUEST_URI'];
		$url = 'http';
    	if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') {
    	    $url = 'https';
        }
        $url .= '://' . $_SERVER['HTTP_HOST'];
		if (array_key_exists('pwg_familyaccess_forward_url', $_SESSION) === true && $_SESSION['pwg_familyaccess_forward_url'] != '' ) {
			$url = $_SESSION['pwg_familyaccess_forward_url'];
		}
        
		?>
		
		
    <form action="<?php echo $url; ?>" method="post" name="login_form" class="form-horizontal">
        <div class="card">
            <h4 class="card-header">
                Zugangsprüfung
            </h4>
            <div class="card-body">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Beantworte uns eine Frage: In welcher Stadt wohnt Familie HKS?</label>
                    <div class="col-sm-4">
                        <input tabindex="1" class="form-control" type="text" name="city" id="city" placeholder="Stadt">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <!-- <input type="hidden" name="redirect" value="%2Fpicture.php%3F%2F1%2Fcategory%2Fausflug-dasa-dortmund-vom-04012020"> -->
                        <input tabindex="4" type="submit" name="login" value="Absenden" class="btn btn-primary btn-raised">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript"><!--
    document.getElementById('username').focus();
//--></script>
        <!-- Start of footer.tpl -->
        <div class="copyright container">
            <div class="text-center">
                
                Powered by	<a href="https://de.piwigo.org" class="Piwigo">Piwigo</a>


            </div>
        </div>
</div>




<script type="text/javascript" src="/_data/combined/1v83lw8.js"></script>
<script type="text/javascript">//<![CDATA[

$('#categoriesDropdownMenu').on('show.bs.dropdown', function() {$(this).find('a.dropdown-item').each(function() {var level = $(this).data('level');var padding = parseInt($(this).css('padding-left'));if (level > 0) {$(this).css('padding-left', (padding + 10 * level) + 'px')}});});
//]]></script>


</body></html>