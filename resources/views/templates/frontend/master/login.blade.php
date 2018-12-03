<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Asoyaracuy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Organizacion vecinal de la calle Yaracuy" />
	<meta name="keywords" content="organizacion, cuotas, yaracuy, asoyaracuy, vecinos, condominios" />
	<meta name="author" content="Cyberia Labtech" />

  <!-- Disable tap highlight on IE -->
  <meta name="msapplication-tap-highlight" content="no">
 
	<!-- FONT AWESOME -->
	{!!Html::style('/frontend/css/fontawesome.min.css')!!}

	<!-- NEW TEMPLATE -->
	{!!Html::style('/frontend/css/main.css')!!}

<body style="padding-top: 0px !important;">

@yield('content')

<footer>
    <div class="section-container footer-container">
        <div class="container">
            <div class="row">
                    <div class="col-md-4">
                        <h4>About us</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet consectetur dolor</p>
                    </div>

                    <div class="col-md-4">
                        <h4>Do you like ? Share this !</h4>
                        <p>
                            <a href="https://facebook.com/" class="social-round-icon white-round-icon fa-icon" title="">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                          </a>
                          <a href="https://twitter.com/" class="social-round-icon white-round-icon fa-icon" title="">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                          </a>
                          <a href="https://www.linkedin.com/" class="social-round-icon white-round-icon fa-icon" title="">
                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                          </a>
                        </p>
                        <p><small>© Untitled | Website created with <a href="http://www.mashup-template.com/" class="link-like-text" title="Create website with free html template">Mashup Template</a>/<a href="http://www.unsplash.com/" class="link-like-text" title="Beautiful Free Images">Unsplash</a></small></p>    
                    </div>

                    <div class="col-md-4">
                        <h4>Subscribe to newsletter</h4>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control footer-input-text">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-newsletter ">OK</button>
                                </div>
                            </div>
                        </div>


                    </div>
            </div>
        </div>
    </div>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function (event) {
    navActivePage();
  });
</script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID 

<script>
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date(); a = s.createElement(o),
      m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
  ga('create', 'UA-XXXXX-X', 'auto');
  ga('send', 'pageview');
</script>

-->

{!!Html::script('/frontend/js/main.js')!!}

</html>
