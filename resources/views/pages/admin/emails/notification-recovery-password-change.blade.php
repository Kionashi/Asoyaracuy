@extends('templates.admin.email.index')

@section('content')

<!-- main section -->
		<tbody>
			<tr>
				<td style= "padding: 50px 80px; font-family: Arial, Helvetica, sans-serif; color: #000000;">
					<h2 style="font-style: italic">Hello {{$adminUser->first_name}}</h2>

					<p style="font-size: 12px; margin: 10px 0 50px 0;">
						We received a request to reset the password for your account. If you requested a reset, click <a href="{{ $url }}">here</a>. If you didn’t make this request, please ignore this email.	
					</p>
				</td>
			</tr>
		</tbody>
	<!-- end main section -->

@stop   