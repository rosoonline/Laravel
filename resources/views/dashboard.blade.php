@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p>
			Welcome to the Dashboard, use {!!HTML::link('/auth/logout','Logout',['class'=>'btn btn-link'])!!} to logout.
			</p>
		</div>
	</div>
</div>
@endsection
