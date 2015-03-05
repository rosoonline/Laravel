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
			{!! Form::submit('Set Date') !!}
		</p>
		{!! Form::close() !!}
	</p>
	
	<p>
		<?php $data_points = array(); $products = array(); ?>
		@if ( !$orders->count() )
			There are no orders for this date
		@else
			@foreach( $orders as $order )
				<?php $products[$order->product][] = array('label' => $order->customer_code , 'y' => strval($order->totalSales)); ?>
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
      title:{
        text: "Product Sales",
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
			foreach ($products as $productname=>$order) { // typically $key=>$value
				echo '
				  {
					type: "stackedBar",
					name: "'.$productname.'",
					showInLegend: "true",
					dataPoints: [
				';
				
				for ($i = 0; $i < count($customer_codes); $i++) {
					$datapoint = 0;
					for ($j = 0; $j < count($order); $j++) {
						if ($order[$j]['label']==$customer_codes[$i]->code) {
							$datapoint = $order[$j]['y'];
						}
					}
					echo '{y: '.$datapoint.', label: "'.$customer_codes[$i]->code.'" },';
					
				}
				
				echo '
					]
				  },
				';
			}
		?>
      ]

    });

    chart.render();

});
//]]>
</script> 
	
@endsection