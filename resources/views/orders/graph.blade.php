@extends('app')
 
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">

    <h2>Orders - Graph view</h2>
	
	<p>
		{!! Form::open(array('url' => 'orders/graph', 'method' => 'get')) !!}
		<p>
			{!! Form::selectMonth('month', $month); !!}
			{!! Form::selectRange('year', 2010, 2025, $year); !!}
			{!! Form::select('viewaxis', array(
											'pc_sales' => 'Product vs customer sales', 
											'cp_sales' => 'Customer vs product sales',
											'pc_revenue' => 'Product vs customer revenue',
											'cp_revenue' => 'Customer vs product revenue',
										), $viewaxis); !!}
			{!! Form::submit('Submit') !!}
		</p>
		{!! Form::close() !!}
	</p>
	
	<p>
		<?php $products = array(); ?>
		@if ( !$orders->count() )
			There are no orders for this date
		@else
			@foreach( $orders as $order )
				<?php 
					$products[$order->product][] = array('label' => $order->customer_code , 'y' => strval($order->total));
				?>
			@endforeach
		
			<div id="chartContainer" style="height: 600px; width: 100%;">
		@endif
	</p>

		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {

    var chart = new CanvasJS.Chart("chartContainer",
    {
	  zoomEnabled: true,
      panEnabled: true,
	  exportEnabled: true,
	  
      title:{
		text: '{{ $chartTitle }}',
      },
      toolTip: {
        shared: true
      },
      axisX: {
		labelFontSize: 20,
		interval: 1,
      },
      data:[
		<?php
		
			if ($viewaxis=='pc_sales' || $viewaxis=='pc_revenue') {
				foreach ($customer_codes as $customer_code=>$customer) { // typically $key=>$value
					$data_points = array();
					echo '
					  {
						type: "stackedBar",
						name: "'.$customer['code'].'",
						showInLegend: false,
						dataPoints: 
					';
						
					foreach ($products as $productname=>$order) {
						$datapoint = 0;
						for ($k = 0; $k < count($order); $k++) {
							if ($customer['code']==$order[$k]['label']) {
								$datapoint = $order[$k]['y'];
							}
						}
						$point = array("label" => $productname, "y" => $datapoint);
						array_push($data_points, $point);
					}
					
					echo json_encode($data_points, JSON_NUMERIC_CHECK);
						
					echo '
					  },
					';
				}
			}
		
			if ($viewaxis=='cp_sales' || $viewaxis=='cp_revenue') {
				foreach ($products as $productname=>$order) {
					$data_points = array();
					echo '
					  {
						type: "stackedBar",
						name: "'.$productname.'",
						showInLegend: true,
						dataPoints: 
					';
					
					for ($i = 0; $i < count($customer_codes); $i++) {
						$datapoint = 0;
						for ($j = 0; $j < count($order); $j++) {
							if ($order[$j]['label']==$customer_codes[$i]->code) {
								$datapoint = $order[$j]['y'];
							}
						}
						$point = array("label" => $customer_codes[$i]->code, "y" => $datapoint);
						array_push($data_points, $point);
					}

					echo json_encode($data_points, JSON_NUMERIC_CHECK);
					
					echo '
					  },
					';
				}
			}
		?>
      ]

    });

    chart.render();

});
//]]>
</script> 
	<?php //echo json_encode($data_points, JSON_NUMERIC_CHECK); ?>
@endsection