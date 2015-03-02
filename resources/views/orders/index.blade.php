@extends('app')
 
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">

    <h2>Orders</h2>
<<<<<<< HEAD
	
	<p>
		{!! Form::open(array('url' => 'orders', 'method' => 'get')) !!}
		<p>
			{!! Form::selectMonth('month', $month); !!}
			{!! Form::selectRange('year', 2010, 2025, $year); !!}
=======
<<<<<<< HEAD
	
	<p>
		{!! Form::open(array('url' => 'orders', 'method' => 'get')) !!}
=======
<<<<<<< HEAD
	
	<p>
		{!! Form::open(array('url' => '/orders')) !!}
>>>>>>> origin/master
		<p>
			{!! Form::selectMonth('month', $currentmonth); !!}
			{!! Form::selectRange('year', 2010, 2025, $currentyear); !!}
>>>>>>> origin/master
			{!! Form::submit('Set Date') !!}
		</p>
		{!! Form::close() !!}
	</p>

<<<<<<< HEAD
	<p>
		@if ( !$orders->count() )
			There are no orders for this date
		@else
=======
<<<<<<< HEAD
=======
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
	
	<p>
		{!! Form::open(array('url'=>'orders/import','files'=>true)) !!}

		  {!! Form::label('file','Upload file',array('id'=>'','class'=>'')) !!}
		  {!! Form::file('file','',array('id'=>'','class'=>'')) !!}
		  <br/>
		  <!-- submit buttons -->
		  {!! Form::submit('Save') !!}
		  
		  <!-- reset buttons -->
		  {!! Form::reset('Reset') !!}

		{!! Form::close() !!}
	</p>
>>>>>>> origin/master
>>>>>>> origin/master
 
>>>>>>> origin/master
>>>>>>> origin/master
	<p>
		@if ( !$orders->count() )
			You have no orders
		@else
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
			<ul>
				@foreach( $orders as $order )
					<li>
						{!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('orders.destroy', $order->slug))) !!}
							<a href="{{ route('orders.show', $order->slug) }}">{{ $order->name }}</a>
							(
								{!! link_to_route('orders.edit', 'Edit', array($order->slug), array('class' => 'btn btn-info')) !!},
								{!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
							)
						{!! Form::close() !!}
					</li>
				@endforeach
			</ul>
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
		@endif
	</p>

		</div>
	</div>
</div>
<<<<<<< HEAD

<script type="text/javascript">
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master

<!--script type="text/javascript">
>>>>>>> origin/master
//<![CDATA[
$(document).ready(function() {
    $('#table_orders').dataTable( {
	
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
<<<<<<< HEAD

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    $('#table_orders').dataTable( {
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
>>>>>>> origin/master
        },
		
		"oLanguage": {
		  "sSearch": "Filter"
		}
		
    } );
} );
//]]>
<<<<<<< HEAD
</script> 
=======
</script--> 
<<<<<<< HEAD
=======
=======
        }
    } );
} );
//]]>
</script> 
=======
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
	
@endsection