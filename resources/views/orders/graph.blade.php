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
	
	<p><div id="chartContainer" style="height: 600px; width: 100%;"></div></p>
	
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
		<?php echo $canvasData; ?>
      ]

    });

    chart.render();

});
//]]>
</script> 
@endsection