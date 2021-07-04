@extends('layouts.app')

@section('content')
<!-- Main content -->
@if (session('message_success'))
	<div class="container-fluid mt-1" id="session_message">
		<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('message_success') }}</div>
	</div>
@endif
<router-view ></router-view>
<!-- /.content -->
@endsection
