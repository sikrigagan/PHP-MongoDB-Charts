<!doctype html>

<?php

    // including FusionCharts PHP wrapper
    require 'fusioncharts/fusioncharts.php';
    
    // including PHP Library for MongoDB
    require 'vendor\autoload.php';

    $dbconn = new MongoDB\Client;
    
    // validating DB connection
    if(!$dbconn) {
        exit("There was an error establishing database connection");
    }

?>

<html>
    <head>
        <title>Creating Charts using PHP and MongoDB</title>

        <!-- including FusionCharts core package JS files -->
        <script src="fusioncharts/fusioncharts.js"></script>
        <script src="fusioncharts/fusioncharts.theme.fint.js"></script>
    </head>

    <body>

        <?php

            // retrieving data from the database
            $db = $dbconn->myProject;
            $myObj = $db->chartData->find();

            //convert MongoCursor into an array
            $data=iterator_to_array($myObj);

            // sorting the data
            asort($data);

            if ($data) {
                
               $categoryArray=array();
           
               $dataseries1=array();
           
               $dataseries2=array();
                           
               foreach ($data as $dataset) {
                   array_push($categoryArray, array(
                       "label" => $dataset["month"]
                   ));
                   
                   array_push($dataseries1, array(
                       "value" => $dataset["petrol"]
                   ));
                   
                   array_push($dataseries2, array(
                       "value" => $dataset["diesel"]
                   ));
               }
           
           
               $arrData = array(
                   "chart" => array(
                           "caption"=> "Comparison of Petrol and Diesel price",
                           "xAxisname"=>"Month",
                           "yAxisname"=>"Price",
                           "numberPrefix"=>"$",
                           "paletteColors"=> "#876EA1, #72D7B2",
                           "useplotgradientcolor"=> "0",
                           "plotBorderAlpha"=> "0",
                           "bgColor"=> "#FFFFFFF",
                           "canvasBgColor"=> "#FFFFFF",
                           "showCanvasBorder"=> "0",
                           "showBorder"=> "0",
                           "divLineAlpha"=> "40",
                           "divLineColor"=> "#DCDCDC",
                           "alternateHGridColor"=> "#DCDCDC",
                           "alternateHGridAlpha"=> "15",
                           "showValues"=> "0",
                           "labelDisplay"=> "auto",
                           "baseFont"=> "Assistant",
                           "baseFontColor"=> "#000000",
                           "outCnvBaseFont"=> "Assistant",
                           "outCnvBaseFontColor"=> "#000000",
                           "baseFontSize"=> "13",
                           "outCnvBaseFontSize"=> "13",
                           "labelFontColor"=> "#000000",
                           "captionFontColor"=> "#153957",
                           "captionFontBold"=> "1",
                           "captionFontSize"=> "20",
                           "subCaptionFontColor"=> "#153957",
                           "subCaptionfontSize"=> "17",
                           "subCaptionFontBold"=> "0",
                           "captionPadding"=> "20",
                           "valueFontBold"=> "0",
                           "showAxisLines"=> "1",
                           "yAxisLineColor"=> "#DCDCDC",
                           "xAxisLineColor"=> "#DCDCDC",
                           "xAxisLineAlpha"=> "15",
                           "yAxisLineAlpha"=> "15",
                           "toolTipPadding"=> "7",
                           "toolTipBorderColor"=> "#DCDCDC",
                           "toolTipBorderThickness"=> "0",
                           "toolTipBorderRadius"=> "2",
                           "showShadow"=> "0",
                           "toolTipBgColor"=> "#153957",
                           "toolTipBgAlpha"=> "90",
                           "toolTipColor"=> "#FFFFFF",
                           "legendBorderAlpha"=> "0",
                           "legendShadow"=> "0",
                           "legendItemFontSize"=> "14"
                   )
               );
                       
               $arrData["categories"]=array(array("category"=>$categoryArray));
                       
               // creating dataset object
               $arrData["dataset"] = array(array("seriesName"=> "Petrol_price", "data"=>$dataseries1), array("seriesName"=> "Diesel_price",  "data"=>$dataseries2)); 
           
               $jsonEncodedData = json_encode($arrData);

               $msChart = new FusionCharts("msline", "demochart", "600", "400", "chart-container", "json", $jsonEncodedData);

               // calling render method to render the chart
               $msChart->render();
           }

        ?>
        
        <div id="chart-container">Fusion Charts will render here</div>

    </body>
</html>
