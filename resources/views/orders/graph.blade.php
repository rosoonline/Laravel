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
		<?php $data_points = array(); $products = array(); ?>
		@if ( !$orders->count() )
			There are no orders for this date
		@else
			@foreach( $orders as $order )
				<?php 
					$products[$order->product][] = array('label' => $order->customer_code , 'y' => strval($order->total));
				?>
			@endforeach

			<?php 
				//$graphdata = json_encode($products, JSON_NUMERIC_CHECK);
			?>
		
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
        <?php
			if ($viewaxis=='pc_sales') {
				echo 'text: "Product - Customer sales",';
			}
			if ($viewaxis=='pc_revenue') {
				echo 'text: "Product - Customer revenue (\u00A3)",';
			}
			if ($viewaxis=='cp_sales') {
				echo 'text: "Customer - Product sales",';
			}
			if ($viewaxis=='cp_revenue') {
				echo 'text: "Customer - Product revenue (\u00A3)",';
			}
		?>
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
					echo '
					  {
						type: "stackedBar",
						name: "'.$customer['code'].'",
						showInLegend: false,
						dataPoints: [
					';
						
					foreach ($products as $productname=>$order) {
						$datapoint = 0;
						for ($k = 0; $k < count($order); $k++) {
							if ($customer['code']==$order[$k]['label']) {
								$datapoint = $order[$k]['y'];
							}
						}
						echo '{y:'.$datapoint.',label:"'.$productname.'"},';
					}
						
					echo '
						]
					  },
					';
				}
			}
		
			if ($viewaxis=='cp_sales' || $viewaxis=='cp_revenue') {
				foreach ($products as $productname=>$order) {
					echo '
					  {
						type: "stackedBar",
						name: "'.$productname.'",
						showInLegend: true,
						dataPoints: [
					';
					
					for ($i = 0; $i < count($customer_codes); $i++) {
						$datapoint = 0;
						for ($j = 0; $j < count($order); $j++) {
							if ($order[$j]['label']==$customer_codes[$i]->code) {
								$datapoint = $order[$j]['y'];
							}
						}
						echo '{y:'.$datapoint.',label:"'.$customer_codes[$i]->code.'"},';
					}
					
					echo '
						]
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
	
@endsection