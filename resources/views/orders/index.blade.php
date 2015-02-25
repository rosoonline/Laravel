@extends('app')
 
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">

    <h2>Orders</h2>
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
 
	<p>
		@if ( !$orders->count() )
			You have no orders
		@else
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
		@endif
	</p>

		</div>
	</div>
</div>
	
@endsection