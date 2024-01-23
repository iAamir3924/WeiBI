<?php
if(isset($_POST['string']))
{
	$string=$_POST['string'];
	
	$con = new mysqli("localhost", "weislabc_string", "string@123", "weislabc_string");
	if ($con->connect_error)
		die("<br><br><br><br><br>Connection failed: " . $con->connect_error);
	// echo "<br><br><br><br><br>";
	$result=$con->query("SELECT * FROM string WHERE node1='$string'") or die($con->error);
	
	$char = '[';
	$matchedchar = '[';
	$frequency = '[';
	while($row=$result->fetch_assoc())
	{
		$matchedchar=$row['node2'];
		$matchedcharfrequency=$row['score'];
		
		if($char != '[')
			$char .= ",";
		$char .= '{"label":"'.$matchedchar.'"}';
		
		// if($matchedchar != '[')
			// $matchedchar .= ",";
		// $matchedchar .= '{"value":"'.$matchedchar.'"}';
		
		if($frequency != '[')
			$frequency .= ",";
		$frequency .= '{"value":"'.$matchedcharfrequency.'"}';
	}
	$char .=']';
	$matchedchar .=']';
	$frequency .=']';
}
else
	$string="";
?>
<div class="w3-container" style="padding:128px 16px">
	<!--<h3 class="w3-center">SUBMIT</h3>-->
	<div class="w3-col s0 m0 l2">&nbsp;</div>
	<div class="w3-col s12 m12 l8 w3-card-4 w3-white">
		<div class="w3-container w3-blue">
			<h2>Systems Biology Workbench</h2>
		</div>
		<!--START MAIN TABLE-->
		<table align=center width="80%">			
			<tr>
				<td>
					<form class="w3-container" method=post value=<?php print $_SERVER["PHP_SELF"]; ?>>
						<p>
							<label>PKPD:</label>
							<input type="text" class="w3-input w3-border" name="string" value="<?php echo $string; ?>" >
						</p>
						<p>
							<input class="w3-button w3-black" type=submit value=Simulate>
						</p>
						
					</form>

					<hr>
				</td>
			</tr>
			<tr>
				<td>
				<?php
				echo "<div class='' id='string_linechart'></div>";
				//https://string-db.org/api/image/network?identifiers=$search
				// if($string)
				// {
					// $curl = curl_init(); 
					// curl_setopt($curl,CURLOPT_URL,"https://www.startutorial.com/articles/view/php-curl");
					// curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
					// curl_setopt($curl,CURLOPT_HEADER, false); 
					// $result=curl_exec($curl);
					// curl_close($curl);
					// echo $result;
				// }
				?>
				</td>
			</tr>
		</table>
	</div>
</div>

<!--Chart : Start-->
<script type="text/javascript" src="fusionchart/fusioncharts.js"></script>
<script type="text/javascript" src="fusionchart/themes/fusioncharts.theme.carbon.js"></script>
<script type="text/javascript" src="fusionchart/themes/fusioncharts.theme.fint.js"></script>
<script type="text/javascript" src="fusionchart/themes/fusioncharts.theme.ocean.js"></script>
<script type="text/javascript" src="fusionchart/themes/fusioncharts.theme.zune.js"></script>
<script type="text/javascript">
FusionCharts.ready(function(){
	var revenueChart2 = new FusionCharts({
		type: "mscombi2d",
		renderAt: "chartContainer",
		width: "100%",
		height: "400",
		dataFormat: "json",
		dataSource:{
			"chart": {
				"caption": "PKPD Simulation of <?php echo $string; ?>",
				//"subCaption": "<?php echo "$string"; ?>",
				"xAxisName": "Interactions (Genes/Proteins)",
				"yAxisName": "WeiDOCK Score",
				"lineThickness": "4",
				"paletteColors": "#0075c2",
				"baseFontColor": "#333333",
				"baseFont": "Helvetica Neue,Arial",
				"captionFontSize": "16",
				"subcaptionFontSize": "16",
				"subcaptionFontBold": "1",
				"showBorder": "1",
				"bgColor": "#ffffff",
				"showShadow": "1",
				"canvasBgColor": "#ffffff",
				"canvasBorderAlpha": "1",
				"divlineAlpha": "100",
				"divlineColor": "#999999",
				"divlineThickness": "1",
				"divLineDashed": "1",
				"divLineDashLen": "1",
				"showXAxisLine": "1",
				"xAxisLineThickness": "1",
				"xAxisLineColor": "#999999",
				"showAlternateHGridColor": "0"
			},
			"categories":
					[
						{
							"category": <?php echo $char; ?>
						}
					],
					"dataset": 
					[
						// {
							// "seriesname": "Matched Charector",
							
							// "data": <?php echo $matchedchar; ?>
						// },
						{
							"seriesname": "Interaction Score",
							"renderAs": "line",
							"showValues": "1",
							"data": <?php echo $frequency; ?>
						}
					]
		}
	});
	revenueChart2.render("string_linechart");
});
</script>
<!--Chart : End-->
