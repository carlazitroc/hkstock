<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hong Kong Stocks Sample Graph">
    <meta name="author" content="Maricarl Ortiz">
    <title>Hong Kong Stocks Exam</title>
    <link href="source/css/bootstrap.min.css" rel="stylesheet">
    <link href="source/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="source/css/jumbotron-narrow.css" rel="stylesheet">
    <script src="source/js/ie-emulation-modes-warning.js"></script>
    <script type="text/javascript" src="source/js/canvasjs.min.js"></script>
    <script src="source/js/ie10-viewport-bug-workaround.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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

		
		<?php 

		if (isset($_POST["compname"]) && !empty($_POST["compname"])): 
			$compname = rawurlencode($_POST['compname']);
		?>

		<!--show search form for chart-->
	    <section>
		    <div>
		    	<h3>Hong Kong Stocks Historical Chart Loookup</h3>
		    	<h4>Use Quandl Stock Information result for symbol and company name to view the chart</h4>
		      	<form id="chart_lookup" action="stocks.php" method="post">
				  <div class="form-group row">
	  			    <label for="symbol" class="col-sm-2 form-control-label">Stock Symbol</label>
	  			    <div class="col-sm-10">
	  			      <input type="text" name="stock_num" class="form-control" placeholder="Stock Symbol" required/>
	  			    </div>
	  			  </div>
	  			  <div class="form-group row">
	  			    <div class="col-sm-offset-2 col-sm-10">
	  			      <input name="submit" type="submit" class="btn btn-primary"/>
	  			    </div>
	  			  </div>
				</form>
			</div>
		</section>
		
		<!--get code for quandl-->
		<section>

					<?php
					    $url = 'https://www.quandl.com/api/v3/datasets.xml?query='.$compname.'&database_code=XHKG';
					    //$url = 'data/00700.xml';
					    $xml = @simplexml_load_file($url);
					    
					    if($xml){

					    print '<h4 class="text-center">Quandl Stock Information</h4>
				 		<table class="table table-bordered table-indicator">
			    			<thead id="headertable">
			    				<tr>
			    					<th>Symbol</th>
			    					<th>Company Name</th>
			    				</tr>
			    			</thead>
			    			<tbody id=results>';


						    // get company name and stock symbol
							foreach( $xml->datasets->dataset as $xmlResult){
								$name 	= $xmlResult->name;
								$symbol = $xmlResult->{'dataset-code'};

								print '<tr>'; 
							    print '<td>'.$symbol.'</td>';
							    print '<td>'.$name.'</td>';
							    print '</tr>';
							}
						print"</tbody>
    					</table>";

					  	}else{
					  		
					  	}
				 	?>

		</section>

		<!--result from yahoo finance-->
		<section>
			<h4 class="text-center">Yahoo Finance Stock Information</h4>
				<table class="table table-bordered table-indicator">
	    			<thead id="headertable">
	    				<tr>
	    					<th>Symbol</th>
	    					<th>Company Name</th>
	    				</tr>
	    			</thead>
	    			<tbody id=results>
						<?php 
							$compname = rawurlencode($_POST['compname']);
							$jsondata = file_get_contents('http://autoc.finance.yahoo.com/autoc?&region=1&lang=en&query='.$compname.'');
							$data = json_decode($jsondata, true);
							$results = $data['ResultSet']['Result'];
							
							foreach ($results as $result) {
							    $symbol = $result['symbol'];
							    $name 	= $result['name'];
							    
							    print '<tr>'; 
							    print '<td>'.$symbol.'</td>';
							    print '<td>'.$name.'</td>';
							    print '</tr>';
							}
						?>
	    			</tbody>
	    		</table>
		</section>

		<?php endif;?>


	    <footer class="footer">
	        <p class="text-center">&copy; Masguru 2016</p>
	    </footer>

    </div> <!-- /container -->


  </body>
</html>
