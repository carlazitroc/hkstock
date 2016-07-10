<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hong Kong Stocks Sample Graph">
    <meta name="author" content="Maricarl Ortiz">
    <title>Hong Kong Stocks Historical Chart Loookup</title>
    <link href="source/css/bootstrap.min.css" rel="stylesheet">
    <link href="source/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="source/css/jumbotron-narrow.css" rel="stylesheet">
    <script src="source/js/ie-emulation-modes-warning.js"></script>
    <script type="text/javascript" src="source/js/canvasjs.min.js"></script>
    <script src="source/js/ie10-viewport-bug-workaround.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <?php
      if(isset($_POST['submit'])) { $dataset_code = $_POST['stock_num']; }

      //$url = 'https://www.quandl.com/api/v3/datasets/XHKG/'.$dataset_code.'.xml?api_key=NzzkduZp5xEeyoC6q-oR';
      $url = 'data/00700.xml';
      $xml = simplexml_load_file($url);

      $val = $xml->dataset->dataset[2];

      echo $val;

      // get company name and stock no
      $comp_name = $xml->dataset->name;
      $stock_no  = $xml->dataset->{'dataset-code'};
    ?>

    <script type="text/javascript">
      	window.onload = function () {        

        // dataPoints
        //var dataPoints1 = [];
        //var dataPoints2 = [];

        var chart = new CanvasJS.Chart("chartContainer",{
          zoomEnabled: true,
          zoomType: "xy",
          title: {
            text: '<?php echo $comp_name; ?>' //company name    
          },
          toolTip: {
            shared: true
          },
          legend: {
            verticalAlign: "top",
            horizontalAlign: "center",
            fontSize: 14,
            fontWeight: "bold",
            fontFamily: "calibri",
            fontColor: "dimGrey"
          },
          axisX: {
            labelAngle: -20
          },
          axisY:{
            prefix: '',
            includeZero: false
          }, 
          data: [{ 
            // dataSeries1
            type: "line",
            showInLegend: true,
            name: "Day High",
            dataPoints: [
                <?php
                  foreach($xml->dataset->data->datum as $item)
                  {
                    $data_date = $item->datum[0];
                    $dayHigh   = number_format((float)$item->datum[2], 2, '.', '');
                    $dayLow    = number_format((float)$item->datum[3], 2, '.', '');
                    $rsi       = number_format((float)$item->datum[4], 2, '.', ''); //rsi is the closing
                    $kd        = number_format((float)$item->datum[1], 2, '.', '');
                    //separate year, month and day
                    list($year, $month, $day) = explode('-', $data_date);

                    echo '{ 
                      x: new Date('.$year.', '.$month.', '.$day.'), 
                      y: '.$dayHigh.', mouseover: function(e) { 
                        $( "#kd" ).html( "<p>" + '.$kd.' + "</p>").toggle( "highlight" );
                        $( "#rsi" ).html( "<p>" + '.$rsi.' + "</p>").toggle( "highlight" );
                        $( "#dayHigh" ).html( "<p>" + '.$dayHigh.' + "</p>").toggle( "highlight" );
                        $( "#dayLow" ).html( "<p>" + '.$dayLow.' + "</p>").toggle( "highlight" ); 
                        }  
                      },'; 
                  }
                ?>
            ]
          },
          {       
            // dataSeries2
            type: "line",
            showInLegend: true,
            name: "Day Low" ,
            dataPoints: [
                <?php
                  foreach($xml->dataset->data->datum as $item)
                  {
                    $data_date = $item->datum[0];
                    $dayHigh   = number_format((float)$item->datum[2], 2, '.', '');
                    $dayLow    = number_format((float)$item->datum[3], 2, '.', '');
                    $rsi       = number_format((float)$item->datum[4], 2, '.', ''); //rsi is the closing
                    $kd        = number_format((float)$item->datum[1], 2, '.', '');
                    //separate year, month and day
                    list($year, $month, $day) = explode('-', $data_date);

                    echo '{ 
                      x: new Date('.$year.', '.$month.', '.$day.'), 
                      y: '.$dayLow.', mouseover: function(e) { 
                        $( "#kd" ).html( "<p>" + '.$kd.' + "</p>").toggle( "highlight" );
                        $( "#rsi" ).html( "<p>" + '.$rsi.' + "</p>").toggle( "highlight" );
                        $( "#dayHigh" ).html( "<p>" + '.$dayHigh.' + "</p>").toggle( "highlight" );
                        $( "#dayLow" ).html( "<p>" + '.$dayLow.' + "</p>").toggle( "highlight" ); 
                        }  
                      },'; 
                  }
                ?>
            ]
          },
          {       
            // dataSeries3
            type: "line",
            showInLegend: true,
            name: "Opening" ,
            dataPoints: [
                <?php
                  foreach($xml->dataset->data->datum as $item)
                  {
                    $data_date = $item->datum[0];
                    $dayHigh   = number_format((float)$item->datum[2], 2, '.', '');
                    $dayLow    = number_format((float)$item->datum[3], 2, '.', '');
                    $rsi       = number_format((float)$item->datum[4], 2, '.', ''); //rsi is the closing
                    $kd        = number_format((float)$item->datum[1], 2, '.', '');
                    //separate year, month and day
                    list($year, $month, $day) = explode('-', $data_date);

                    echo '{ 
                      x: new Date('.$year.', '.$month.', '.$day.'), 
                      y: '.$kd.', mouseover: function(e) { 
                        $( "#kd" ).html( "<p>" + '.$kd.' + "</p>").toggle( "highlight" );
                        $( "#rsi" ).html( "<p>" + '.$rsi.' + "</p>").toggle( "highlight" );
                        $( "#dayHigh" ).html( "<p>" + '.$dayHigh.' + "</p>").toggle( "highlight" );
                        $( "#dayLow" ).html( "<p>" + '.$dayLow.' + "</p>").toggle( "highlight" ); 
                        }  
                      },'; 
                  }
                ?>
            ]
          },
          {       
            // dataSeries4
            type: "line",
            showInLegend: true,
            name: "Closing" ,
            dataPoints: [
                <?php
                  foreach($xml->dataset->data->datum as $item)
                  {
                    $data_date = $item->datum[0];
                    $dayHigh   = number_format((float)$item->datum[2], 2, '.', '');
                    $dayLow    = number_format((float)$item->datum[3], 2, '.', '');
                    $rsi       = number_format((float)$item->datum[4], 2, '.', ''); //rsi is the closing
                    $kd        = number_format((float)$item->datum[1], 2, '.', '');
                    //separate year, month and day
                    list($year, $month, $day) = explode('-', $data_date);

                    echo '{ 
                      x: new Date('.$year.', '.$month.', '.$day.'), 
                      y: '.$rsi.', mouseover: function(e) { 
                        $( "#kd" ).html( "<p>" + '.$kd.' + "</p>").toggle( "highlight" );
                        $( "#rsi" ).html( "<p>" + '.$rsi.' + "</p>").toggle( "highlight" );
                        $( "#dayHigh" ).html( "<p>" + '.$dayHigh.' + "</p>").toggle( "highlight" );
                        $( "#dayLow" ).html( "<p>" + '.$dayLow.' + "</p>").toggle( "highlight" ); 
                        }  
                      },'; 
                  }
                ?>
            ]
          }],
              legend:{
                cursor:"pointer",
                itemclick : function(e) {
                  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                  }
                  else {
                    e.dataSeries.visible = true;
                  }
                  chart.render();
          
                }
              }
        });
        chart.render();

        // function onMouseover(e){
        //   $( "#dayHigh" ).html( '<p>' + e.dataPoint.y + '</p>').toggle( "highlight" );
        //   $( "#dayLow" ).html( '<p>' + e.dataPoint.y + '</p>').toggle( "highlight" );
        //   //alert(  e.dataSeries.type+ ", dataPoint { x:" + e.dataPoint.x + ", y: "+ e.dataPoint.y + " }" );
        // }
      }
    </script>
  </head>

  <body>

    <div class="container">
	    <div class="header clearfix">
	        <h3 class="text-center">Hong Kong Stocks Historical Chart Loookup</h3>
	    </div>

      <!--symbol lookup-->
      <section>
          <div>
            <h3>Stock Symbol Lookup</h3>
            <form action="index.php" method="post">
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 form-control-label">Company Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="compname" id="companyname" placeholder="Company Name" required/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" id="symlookup">Lookup</button>
                </div>
            </div>
            </form>
        </div>
      </section>
	      
      <!--graph-->
  		<section>
  		    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
  		</section>

		  <!--table indicator-->
	    <section>
	      	<h3 class="text-center">Indicator</h3>
	      	<table class="table table-bordered table-indicator">
    			  <thead>
    			    <tr>
    			      <th>#</th>
    			      <th>Values</th>
    			    </tr>
    			  </thead>
    			  <tbody>
              <tr>
                <td>Opening</td>
                <td><div id="kd"></div></td>
              </tr>
    			    <tr>
    			      <td>Closing</td>
    			      <td><div id="rsi"></div></td>
    			    </tr>
    			    <tr>
    			      <td>Day High</td>
    			      <td><div id="dayHigh"></div></td>
    			    </tr>
    			   	<tr>
    			      <td>Day Low</td>
    			      <td><div id="dayLow"></div></td>
    			    </tr>
    			  </tbody>
    			</table>
	    </section>

	    <footer class="footer">
	        <p class="text-center">&copy; Masguru 2016</p>
	    </footer>

    </div> <!-- /container -->


  </body>
</html>
