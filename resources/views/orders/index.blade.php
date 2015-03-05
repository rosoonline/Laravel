@extends('app')
 
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">

    <h2>Orders - List view</h2>
	
	<p>
		{!! Form::open(array('url' => 'orders', 'method' => 'get')) !!}
		<p>
			{!! Form::selectMonth('month', $month); !!}
			{!! Form::selectRange('year', 2010, 2025, $year); !!}
			{!! Form::submit('Set Date') !!}
		</p>
		{!! Form::close() !!}
	</p>

	<p>
		@if ( !$orders->count() )
			There are no orders for this date
		@else
			<table id="table_orders" class="display">
				<thead>
					<tr>
						<th>Year-Month</th>
						<th>Customer</th>
						<th>Sales</th>
						<th>Product</th>
						<th>Revenue (&pound;)</th>
					</tr>
				</thead>
				
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th colspan="2"></th>
						<th></th>
					</tr>
				</tfoot>
				
				<tbody>
				@foreach( $orders as $order )
					<tr>
						<td>{{ $order->date }}</td>
						<td>{{ $order->customer_code }}</td>
						<td>{{ $order->sales }}</td>
						<td>{{ $order->product }}</td>
						<td>{{ $order->revenue }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif
	</p>

		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    $('#table_orders').dataTable( {
	
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
             // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Sales total over all pages
            totalSales = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Sales total over this page
            pageTotalSales = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer for sales column
            $( api.column( 2 ).footer() ).html(
                'Sales '+pageTotalSales +' ( '+ totalSales +' month total)'
            );
 
            // Revenue total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Revenue total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer for revenue column
            $( api.column( 4 ).footer() ).html(
                'Revenue &pound;'+pageTotal +' ( &pound;'+ total +' month total)'
            );
        },
		
		"oLanguage": {
		  "sSearch": "Filter"
		}
		
    } );
} );
//]]>
</script> 
	
@endsection