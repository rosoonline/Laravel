@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p>Use the following links to login / register:
			{!!HTML::link('/auth/login','Login',['class'=>'btn btn-link'])!!}/{!!HTML::link('/auth/register','Register',['class'=>'btn btn-link'])!!}
			</p>
		</div>
	</div>
</div>
@endsection
