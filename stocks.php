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
    <script src="source/js/bootstrap.js"></script>
</head>
<body>
    <script>
    <?php 
    if (isset($_POST["stock_num"]) && !empty($_POST["stock_num"])){
        $stock_num = $_POST["stock_num"];
    }else{
        $stock_num = '';

    } 
    ?>

    // $(window).load(function() {
    //     var stock_num_from_index = '<?php echo $stock_num ?>';
    //     if(typeof(stock_num_from_index) != "undefined" && stock_num_from_index !== null) {
    //          var stock_num_index = stock_num_from_index;
    //     }
    // });

    $(document).ready(function(){
        var stock_num_from_index = '<?php echo $stock_num ?>';

        var vstock_num;
        $("#search-btn").click(function () 
        {
            vstock_num = $("#stock_num").val();
            stock_num_from_index = '';
            
            $.post("data.php",
                {stock_num: vstock_num,
                 stock_num_index: stock_num_from_index},
                function(response) 
                {
                    // Check the output of json
                    try{
                       var obj = $.parseJSON(response);
                    }catch(err){
                       $('#errorModal').modal('show');
                    }
                    
                    //child data
                    var result = obj.dataset.data.datum;
                    var name = obj.dataset.name;

                    var dataPoints1 = [];
                    var dataPoints2 = [];
                    var dataPoints3 = [];
                    var dataPoints4 = [];

                    var chart = new CanvasJS.Chart("chartContainer",{
                      zoomEnabled: true,
                      zoomType: "xy",
                      title: {
                        text: name //company name    
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
                      }, 
                      data: [{ 
                        // dataSeries1 dayHigh
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Day High",
                        dataPoints: dataPoints1
                      },{ 
                        // dataSeries2 dayLow
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Day Low",
                        dataPoints: dataPoints2
                      },{ 
                        // dataSeries1 dayHigh
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Opening",
                        dataPoints: dataPoints3
                      },{ 
                        // dataSeries1 dayHigh
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Closing",
                        dataPoints: dataPoints4
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

                    //loop to grandchild data
                    $.each(result, function(key,value) {
                      var date = (value.datum[0]);
                           
                      var date_split = date.split('-');
                      var year = date_split[0];
                      var month = date_split[1];
                      var day = date_split[2];

                      var open = parseFloat((value.datum[1]));
                      var high = parseFloat((value.datum[2]));
                      var low  = parseFloat((value.datum[3]));
                      var close= parseFloat((value.datum[4]));

                      var date_f = new Date(year,month,day);
                      var open_f = parseFloat(open.toFixed(2));
                      var high_f = parseFloat(high.toFixed(2));
                      var low_f = parseFloat(low.toFixed(2));
                      var close_f = parseFloat(close.toFixed(2));
                      
                      // pushing the new values
                      dataPoints1.push({
                        x: date_f,
                        y: high_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                        }  
                      });
                      //pushing the new values
                      dataPoints2.push({
                        x: date_f,
                        y: low_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                          }  
                      });
                      dataPoints3.push({
                        x: date_f,
                        y: open_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                        }  
                      });
                      dataPoints4.push({
                        x: date_f,
                        y: close_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                        }  
                      });

                    });
                    chart.render();

                });



        });
            //if from index
            $.post("data.php",
                {stock_num: vstock_num,
                 stock_num_index: stock_num_from_index},
                function(response) 
                {
                    // Check the output of json
                    try{
                       var obj = $.parseJSON(response);
                    }catch(err){
                       $('#errorModal').modal('show');
                    }
                    
                    //child data
                    var result = obj.dataset.data.datum;
                    var name = obj.dataset.name;

                    var dataPoints1 = [];
                    var dataPoints2 = [];
                    var dataPoints3 = [];
                    var dataPoints4 = [];

                    var chart = new CanvasJS.Chart("chartContainer",{
                      zoomEnabled: true,
                      zoomType: "xy",
                      title: {
                        text: name //company name    
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
                      }, 
                      data: [{ 
                        // dataSeries1 dayHigh
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Day High",
                        dataPoints: dataPoints1
                      },{ 
                        // dataSeries2 dayLow
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Day Low",
                        dataPoints: dataPoints2
                      },{ 
                        // dataSeries1 dayHigh
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Opening",
                        dataPoints: dataPoints3
                      },{ 
                        // dataSeries1 dayHigh
                        type: "line",
                        xValueType: "dateTime",
                        showInLegend: true,
                        name: "Closing",
                        dataPoints: dataPoints4
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

                    //loop to grandchild data
                    $.each(result, function(key,value) {
                      var date = (value.datum[0]);
                           
                      var date_split = date.split('-');
                      var year = date_split[0];
                      var month = date_split[1];
                      var day = date_split[2];

                      var open = parseFloat((value.datum[1]));
                      var high = parseFloat((value.datum[2]));
                      var low  = parseFloat((value.datum[3]));
                      var close= parseFloat((value.datum[4]));

                      var date_f = new Date(year,month,day);
                      var open_f = parseFloat(open.toFixed(2));
                      var high_f = parseFloat(high.toFixed(2));
                      var low_f = parseFloat(low.toFixed(2));
                      var close_f = parseFloat(close.toFixed(2));
                      
                      // pushing the new values
                      dataPoints1.push({
                        x: date_f,
                        y: high_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                        }  
                      });
                      //pushing the new values
                      dataPoints2.push({
                        x: date_f,
                        y: low_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                          }  
                      });
                      dataPoints3.push({
                        x: date_f,
                        y: open_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                        }  
                      });
                      dataPoints4.push({
                        x: date_f,
                        y: close_f,
                        mouseover: function(e) { 
                          $( "#kd" ).html( "<p>" + open_f + "</p>").toggle( "highlight" );
                          $( "#rsi" ).html( "<p>" + close_f + "</p>").toggle( "highlight" );
                          $( "#dayHigh" ).html( "<p>" + high_f + "</p>").toggle( "highlight" );
                          $( "#dayLow" ).html( "<p>" + low_f + "</p>").toggle( "highlight" ); 
                        }  
                      });

                    });
                    chart.render();

                });
    });
    </script>
    <div class="container">
	    <div class="header clearfix">
	        <h3 class="text-center">Hong Kong Stocks Historical Chart Loookup</h3>
	    </div>

      <!--show search form for chart-->
      <section>
        <div>
          <h3>Hong Kong Stocks Historical Chart Loookup</h3>
          <h4>Use Quandl Stock Information result for symbol and company name to view the chart</h4>
            <form id="chart_lookup" action="#" method="post">
            <div class="form-group row">
                <label for="stocksymbol" class="col-sm-2 form-control-label">Stock Symbol</label>
                <div class="col-sm-10">
                  <input name="stock_num" type="text"   class="form-control" id="stock_num" placeholder="Stock Symbol" required/>    
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                  <input name="search" type="button" class="btn btn-primary" id="search-btn" value="Search"/>
                </div>
              </div>
          </form>
        </div>
      </section>

      <section>
          <div id="symbolContainer"></div>
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
      
        <!--dialog for error-->
      <div id="errorModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Data does not exist.</h4>
            </div>
            <div class="modal-body">
              <p>Please search other symbol to search.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

	    <footer class="footer">
	        <p class="text-center">&copy; Masguru 2016</p>
	    </footer>

    </div> <!-- /container -->


  </body>
</html>
