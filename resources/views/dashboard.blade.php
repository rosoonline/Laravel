@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p>
				Welcome to the Dashboard
			</p>
			<p>
				{!! link_to_route('orders.import', 'Orders - Import') !!}
			</p>
			<p>
				{!! link_to_route('orders.index', 'Orders - View') !!}
			</p>
		</div>
	</div>
</div>
@endsection
