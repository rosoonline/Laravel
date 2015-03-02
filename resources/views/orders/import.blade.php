@extends('app')
 
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">

    <h2>Orders</h2>
	
	<p>
		{!! Form::open(array('url'=>'orders/upload','files'=>true)) !!}
			<p>
		  {!! Form::label('file','Upload file',array('id'=>'','class'=>'')) !!}
		  {!! Form::file('file','',array('id'=>'','class'=>'')) !!}
		  </p>
		  <p>
		  {!! Form::selectMonth('month'); !!}
		  {!! Form::selectRange('year', 2010, 2025); !!}
		  </p>
		  <br />
		  <p>
		  <!-- submit buttons -->
		  {!! Form::submit('Upload') !!}
		  
		  <!-- reset buttons -->
		  <!--{!! Form::reset('Reset') !!} -->
</p>
		{!! Form::close() !!}
	</p>

		</div>
	</div>
</div>
	
@endsection