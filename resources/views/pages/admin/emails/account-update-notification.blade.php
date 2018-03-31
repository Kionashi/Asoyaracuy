@extends('templates.admin.email.index')

@section('content')

<!-- main section -->
		<tbody>
			<tr>
				<td style= "padding: 50px 80px; font-family: Arial, Helvetica, sans-serif; color: #000000;">
					<h2 style="font-style: italic">Hello {{ $adminUser->firstName }}</h2>
					
					<p style="font-size: 12px; margin: 10px 0 50px 0;">
						<br/>
						{{ $notificationMessage }}	
						<br/><br/>
						You can sign in to the following <a href="{{ $url }}">Link</a>
					</p>
				</td>
			</tr>
		</tbody>
<!-- end main section -->

@stop   