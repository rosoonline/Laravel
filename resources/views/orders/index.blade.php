@extends('app')
 
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">

    <h2>Orders</h2>
 
	<p>
		@if ( !$orders->count() )
			You have no orders
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
						<th colspan="4" style="text-align:right">Page total:</th>
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
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '&pound;'+pageTotal +' ( &pound;'+ total +' total)'
            );
        }
    } );
} );
//]]>
</script> 
	
@endsection