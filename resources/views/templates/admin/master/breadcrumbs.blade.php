@if (isset($breadcrumbs))
<!-- Breadcrumbs -->
<section class="content-header">
	<h1>
		{{isset($title)?$title:''}} <small>{{isset($subtitle)?$subtitle:''}}</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
		@foreach ($breadcrumbs as $i=>$breadcrumb)
			<li><a href="{{$breadcrumb->url}}"><i class="{{$breadcrumb->icon}}"></i>{{$breadcrumb->title}}</a></li>
		@endforeach
	</ol>
</section>
@endif
