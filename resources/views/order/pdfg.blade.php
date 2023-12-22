@php
$baseurl=url();
// ini_set("memory_limit","850M");
// set_time_limit('600');
ini_set('max_execution_time', 500); //300 seconds = 5 minutes
ini_set('memory_limit', '3000M'); //This might be too large, but depends on the data set
// print_r($input);exit;
@endphp

										


<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=.5">
		<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> -->
		<title>Menopause Report</title>
		<!--<style>
			ul{
				padding:0;
			}
			div
			{
				/* padding:0;
				margin:0;	 */
			}
			table {
			/* border-collapse: collapse;
			border: 1px solid #cecfd5; */
			}
			table {
			width: 100%;
			}
			.gh
				{page-break-before:always;
				}
			table { 
				table-layout: fixed; }
			td { 
				width: 33%; }
			/* tr.border-bottom td{
				border-bottom: 1pt solid #807b7b;

			} */
		
			td,th:not(:first-child) {
				/* text-align: center; */
				/* border: 1px solid #cecfd5;				 */
  				/* padding: 2px 3px; */
  				/* padding: 10px 15px; */
			}	
			thead {
				background: #395870;
				/* color: #fff; */
				color: rgb(226, 222, 222);
			}	
			/* tbody tr:nth-child(even) { */
				/* background: #f0f0f2; */
				/* background: #f4f4f7; */
			/* } */
			.total_row{
				background-color: #dddde2;
				font-weight: 550;
			}
			.grand_total_row{
				background-color: rgb(196, 208, 235);
				font-weight: 800;
				font-size:20px;
			
			}
			body {
				/* height: 100%; width: 100%; overflow: hidden; margin:0px; background-color: rgb(82, 86, 89); */
				/* zoom:75%;  */
			}
			*{
				font-size: 20px;
			}
				
			@page {
				/* size: landscape; */
				/* margin: 50px; */
				margin-top: 3%;
			}
			/* @media {
				pre, blockquote {page-break-inside: avoid;}
			} */
		
			</style>-->


			
			<style>
				/* .pagenum:before {
					 content: counter(page);
				 } */
			 </style>
			  <style>
@font-face {
  font-family: Montserrat;
  src: url({{ base64_encode(file_get_contents(public_path('/assets/fonts/Montserrat-SemiBold.ttf'))) }});
  font-weight: bold;
}
    body {
        font-family: '';
        padding: 4rem;
        padding: 10px;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
    }
	img{
		margin: 0;
		padding: 0;
	}
    .report-wrapper {
        max-width: 600px;
        width: 100%;
        margin: 0 auto;
    }
    .name {
        letter-spacing: 1px;
        font-weight: 800;
        font-style: bold;
        font-size: 32px;
        color: #F95563;
		line-height: 50px;
		margin: 0;
		padding: 0;
    }
	.d-flex{
		display: flex;
	}
    p {
        padding: 0.15rem;
        padding: 3px;
        padding-left: 0;
        margin: 8px 0;
        color: #000;
    }

    .subtitle {
        font-size: 13px;
        margin-top: 30px;
        margin-bottom: 20px;
        margin-bottom: 0;
        color: #F95563;
        padding: 0;
    }

    .subheading {
        color: #d89aa0;
        font-weight: 600;
        margin-top: 2rem;
        margin-top: 30px;
    }
    .main-details {
        color: #F95563;
        padding-bottom: 20px;
    }
    .top-left {
        max-width: 65%;
    }
    .top-right {
        max-width: 35%;
    }
    .top-right svg {
        max-width: 100%;
    }
    .main-details-footer {
        padding-top: 25px;
    }
    .main-details-footer li {
        color: #000000;
    }

    ul {
        padding: 0;
        margin: 0;
    }
    li {
        padding: 0;
        margin: 0 0 2px 3px;
		list-style: circle inside;
        display: flex;
        color: #000000;
    }
    li::before {
        content: '';
        width: 2px;
        height: 2px;
        border: 1px solid #555555;
        border-radius: 100%;
        margin: 6px 10px 0 0;
    }

    .heading {
        display: inline-block;
        font-weight: 800;
        font-size: 24px;
        line-height: 30px;
        margin: 0 0 15px;
        color: #000000;
    }

    .subheading-details {
        color: #ea7e89;
        font-weight: 600;
        font-size: 16px;
        margin-top: 0.5rem;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .details-li {
        margin-bottom: 20px;
    }
    .padding-top {
        padding-top: 30px;
    }
	.circle_icon {
      font-family: "DejaVu Sans Mono", monospace;
       font-size: 20px;
      font-weight: 400;
      color: black;
      display: inline;
    }
</style>
			 


	</head>
<body>
	



	
	
	<body>
      <table class="main-details" border="0">
          <tr style="margin:0px;">
              <td scope="row">
			  <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/ad.png'))) }}" height="60px;" width="60px" style="margin:0px;">

              </td>
          </tr>
          <tr>
              <td>
                  <table style="margin:0px;">
                      <tr style="margin:0px;">
                          <td style="margin:0px;">
                              <h1 class="name">{{$input->first_name}}</h1>
                              <p>Age: {{$input->age }}  years</p>
                              <p>Weight: {{$input->weight}} </p>
                              <p>Smoking: {{ $input->smoking }}</p>
                              <p>Drinking: {{ $input->drinking }}</p>
                              <p>Exercise:  {{ $input->exercise  }}</p>
                              <p class="subtitle">Checklist completed: {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime($input->pdf_generated_date))) !!}</p>
                          </td>
                      </tr>
                      <tr class="main-details-footer">
                          <td>
                              <h3 class="subheading-details">Remember to mention:</h3>
                              <ul>
                                  <li><h3 class="circle_icon">&#x2218;</h3> Pre-existing health conditions you have</li>
                                  <li><h3 class="circle_icon">&#x2218;</h3> Prescriptions you currently take</li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </td>
             <td>
			
			 
			 <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/nb.png'))) }}" margin-left="50px;" margin="0px;" padding="0;" height="350px;" width="100%">

			
			</td>
          </tr>
	</table>

		  <!-- <div style="page-break-before:always">&nbsp;</div> -->
      <table style=" table-layout: fixed; width: 100%;">
          <tr>
              <td valign="top" class="padding-top" width="50%">
                  <h2 class="heading"><b>MY SYMPTOMS</b></h2>
                  <h3 class="subheading-details">Vasomotor:</h3>
                  <ul class="details-li">
                      <li><h3 class="circle_icon">&#x2218;</h3> Hot flashes - {{ $input->hot_flashes }}</li>
                      <li><h3 class="circle_icon">&#x2218;</h3> Night sweats - {{ $input->night_sweats }}</li>
                      <li><h3 class="circle_icon">&#x2218;</h3> Cold flashes - {{ $input->cold_flashes }}</li>
                  </ul>
                  <h3 class="subheading-details">Psychological:</h3>
                  <ul class="details-li">
				  <?php
										$cv=explode(',',$input->physchological);
										foreach ($cv as $physchological){
										?>	
										<li><h3 class="circle_icon">&#x2218;</h3> {{$physchological}}</li>
							
									<?php }
											?>
                  </ul>
                  <h3 class="subheading-details">Physical:</h3>
                  <ul class="details-li">
				  <?php
										$cvv=explode(',',$input->physical);
										foreach ($cvv as $physical){
										?>	
										<li><h3 class="circle_icon">&#x2218;</h3> {{$physical}}</li>
							
									<?php }
											?>
                  </ul>
				
              </td>
			
              <td valign="top" class="padding-top" width="50%">
                  <h2 class="heading"><b>MY CYCLES</b></h2>
                  <ul class="details-li">
				  <li><h3 class="circle_icon">&#x2218;</h3> Last period - {!! htmlspecialchars_decode(date('F Y', strtotime($input->last_period))) !!}</li>
											<li><h3 class="circle_icon">&#x2218;</h3> Cycle lengths have changed -{{ $input->cycle_changed }}</li>
											<li><h3 class="circle_icon">&#x2218;</h3> Heavier Bleeding{{ $input->heavier_bleeding }}</li>
                  </ul>
                  <h2 class="heading"><b>MY MANAGEMENT</b></h2>
                  <ul class="details-li">
				  <li><h3 class="circle_icon">&#x2218;</h3> <?php
											if($input->my_management=='Yes')
											{
												echo "Have had a menopause diagnosis";
											}
											else if($input->my_management=='No')
											{
												echo "Never had menopause diagnosis";
											}
											else
											{

											}?>
											</li>
                  </ul>
                  <!-- <hr style="height:10pt; visibility:hidden;" /> -->
                  <p class="subheading-details">HRT Routine:</p>
                  <ul class="details-li">
				  <li><h3 class="circle_icon">&#x2218;</h3> {{ $input->hrt_routine }}</li>
                  </ul>
              </td>
          </tr>
      </table>
     
</body>
</html>
