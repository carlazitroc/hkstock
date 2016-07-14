<?php 

include('header.html');

?>
<div class="wrapper-body">
    <div class="container">

        <section class="search_form">
            <!--symbol lookup-->
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Stock Symbol Lookup</h3>
                    </div>
                        <div class="panel-body">
                        <h4>Search Hong Kong Company name to get company's stock code symbol.</h4>
                        <form action="index.php" method="post">
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-12 form-control-label">Company Name</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="compname" id="companyname" placeholder="Company Name" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                              <button type="submit" class="btn btn-primary" id="symlookup">Lookup</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--show search form for chart-->
            <div class="col-md-6">
                 <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Hong Kong Stocks Historical Chart Loookup</h3>
                    </div>
                    <div class="panel-body">
                        <h4>Use Quandl Stock Information result for symbol and company name to view the chart</h4>
                        <form id="chart_lookup" action="stocks.php" method="post">
                          <div class="form-group row">
                            <label for="symbol" class="col-sm-12 form-control-label">Stock Symbol</label>
                            <div class="col-sm-12">
                              <input type="text" name="stock_num" class="form-control" placeholder="Stock Symbol" required/>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary" id="search-id">Search</button>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php 

        if (isset($_POST["compname"]) && !empty($_POST["compname"])): 
            $compname = rawurlencode($_POST['compname']);
        ?>
        
        <!--get code for quandl-->
        <section>
            <?php
                $url = 'https://www.quandl.com/api/v3/datasets.xml?query='.$compname.'&database_code=XHKG';
                //$url = 'data/00700.xml';
                $xml = @simplexml_load_file($url);
                
                if($xml){

                print '<h4 class="text-center"><b>Quandl Stock Information</b></h4>
                <table class="table table-striped table-indicator sortable-theme-bootstrap" data-sortable>
                    <thead id="headertable" class="thead-inverse">
                        <tr>
                            <th class="col-sm-2">Symbol</th>
                            <th class="col-sm-10">Company Name</th>
                        </tr>
                    </thead>
                    <tbody id=results>';


                    // get company name and stock symbol
                    foreach( $xml->datasets->dataset as $xmlResult){
                        $name   = $xmlResult->name;
                        $symbol = $xmlResult->{'dataset-code'};

                        print '<tr>'; 
                        print '<td class="col-sm-2">'.$symbol.'</td>';
                        print '<td class="col-sm-10">'.$name.'</td>';
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
            <?php 
                $compname = rawurlencode($_POST['compname']);
                $jsondata = file_get_contents('http://autoc.finance.yahoo.com/autoc?&region=1&lang=en&query='.$compname.'');
                $data = json_decode($jsondata, true);
                $results = $data['ResultSet']['Result'];

                print '<h4 class="text-center"><b>Yahoo Finance Stock Information</b></h4>
                <table class="table table-striped table-indicator sortable-theme-bootstrap" data-sortable>
                    <thead id="headertable" class="thead-inverse">
                        <tr>
                            <th class="col-sm-2">Symbol</th>
                            <th class="col-sm-10">Company Name</th>
                        </tr>
                    </thead>
                    <tbody id=results>';
                
                foreach ($results as $result) {
                    $symbol = $result['symbol'];
                    $name   = $result['name'];
                    
                    print '<tr>'; 
                    print '<td class="col-sm-2">'.$symbol.'</td>';
                    print '<td class="col-sm-10">'.$name.'</td>';
                    print '</tr>';
                }

                print '</tbody>
                </table>';
            ?>
        </section>
        
        <?php endif;?>

    </div>

    <a id="back-to-top" href="#page-top" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-2 col-lg-offset-3 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>+852 2236 5696</p>
                </div>
                <div class="col-lg-2 text-center">
                    <i class="fa fa-fax fa-3x sr-contact"></i>
                    <p>+852 2236 5611</p>
                </div>
                <div class="col-lg-2 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:your-email@your-domain.com">admin@masguru.co</a></p>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 

include('footer.html'); 

?>
