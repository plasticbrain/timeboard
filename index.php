<?php require_once('config.php'); ?>
<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Timeboard</title>
		
		<?php 
    require_once('lib/carabiner/carabiner.php');
    $carabiner = new Carabiner();
    
    //------------------------------------------------------------------------
    // Select the Stylesheets to load
    //------------------------------------------------------------------------

		$css_files = array(

			//--- Bootstrap --- 
			array('bootstrap.css'),

      array('normalize.css'),

      //--- Google Web Fonts
      // Ubuntu Condensed
      array('//fonts.googleapis.com/css?family=Ubuntu+Condensed'),

			
			//--- load style.css last!
			array("style.css"),

		);

		// Pass the CSS files to Carabiner
		$carabiner->css($css_files);

		// Render the CSS files
		$carabiner->display('css');
		?>

    <script src="assets/js/modernizr-2.6.2.min.js"></script>
	</head>
	
	<body<?php echo isset($body) ? " $body" : ''; ?>>

    <div class="container-fluid">

    <?php
    //------------------------------------------------------------------------------
    // Load the XML clocks file
    //------------------------------------------------------------------------------
    if( !file_exists('clocks.xml') ): ?>

      <div class="row-fluid">
        <div class="span12">
          <p class="error large">clocks.xml file does not exist!</p>
        </div>
      </div>

    <?php else: ?>
  
    <?php
    $xml = @simplexml_load_file('clocks.xml');
    if( !$xml ): 
    ?>

      <div class="row-fluid">
        <div class="span12">
          <p class="error large">clocks.xml does not contain valid XML!</p>
        </div>
      </div>

    <?php else: ?>

        <?php
        $clocks = @$xml->clocks;
        if( empty($clocks) ):
        ?>

          <div class="row-fluid">
            <div class="span12">
              <p class="error large">You have not defined any clocks in your clocks.xml file!</p>
            </div>
          </div>

        <?php else: ?>

          <div class="row-fluid odd">

            <?php $i = 0; $row = 1; $clock_js = array(); foreach($clocks->clock as $clock): ?>

              <?php
              // Start a new row?
              if( $i > 1 && $i%3 == 0 ):
              ++$row;
              ?>
                
              </div>
              <!-- /row-fluid -->

              <div class="row-fluid <?php echo $row%2 == 0 ? 'even' : 'odd'; ?>">

              <?php endif; ?>
              
              <div class="module span4">
                <div class="module-body">
                  <div id="clock<?php echo $i+1; ?>" class="clock digital">
                    <span class="hour">00</span>
                    <span class="separator"><span>:</span></span>
                    <span class="min">00</span>
                    <span class="separator seconds"><span>:</span></span>
                    <span class="sec">00</span>
                    <span class="meridiem"></span>
                  </div>
                  <h4><?php echo isset($clock->location) ? strip_tags($clock->location) : 'Location not Defined'; ?></h4>
                </div>
              </div>
              <!-- /module -->
              
              <?php $clock_js[$i+1] = array( 
                'timezone' => $clock->timezone, 
                'show_seconds' => $clock->showseconds,
                'show_meridiem' => $clock->showmeridiem 
              ); ?>

            <?php ++$i; endforeach; ?>

          </div>
          <!-- /row-fluid -->

        <?php endif; ?>


    <?php endif; ?>
    <?php endif; ?>



    </div><!--/.fluid-container-->          
    

    
    <? // Set the "HOME" variable for our ajax requests, etc.  ?>

    <script type="text/javascript">
    var home = "<?php echo HOME; ?>";
    </script>
    
    <?php
    //------------------------------------------------------------------------------
    // Load jQuery and jQueryUI from Google's CDN
    //------------------------------------------------------------------------------
    // Note the we utilize "protocol-less" URLs to load these scripts. In other
    // words, DO NOT add "http" or "https" to the following URLs! 
    //------------------------------------------------------------------------------
    ?>

    
    <?php 
    //------------------------------------------------------------------------------
    // Select the javascript files we want to load
    //------------------------------------------------------------------------------
    $js_files = array(
        array('//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.js'),
        array('jquery.clock.js'),
    );

    // Pass the JS files to Carabiner
    $carabiner->js($js_files);

    // Render the JS files
    $carabiner->display('js');
    ?>

    <script type="text/javascript">
    $(function() {

  
      <?php if(!empty($clock_js) ): ?>
        <?php foreach($clock_js as $num => $config): ?>

          <?php
          // Calculate the offset in timezones
          $offset = 0;
          $tz = new DateTimeZone($config['timezone']);
          $now = new DateTime("now", $tz);
          $offset = $tz->getOffset($now)/3600;
          ?>

          $('#clock<?php echo $num; ?>').clock({
            offset: "<?php echo $offset; ?>", 
            type: 'digital', 
            showSeconds: <?php echo $config['show_seconds']; ?>,
            showMeridiem: <?php echo $config['show_meridiem']; ?>
          });

        <?php endforeach; ?>

      <?php endif; ?>


      var clockDelimiter = $('span.separator > span');
      var clockTimer = setInterval(function() {
        clockDelimiter.stop(true, true).fadeToggle(1000);
      }, 1000);


    });
  
    </script>


  </body>
</html>