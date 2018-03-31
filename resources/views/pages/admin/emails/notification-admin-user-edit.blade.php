@extends('templates.admin.email.index')

@section('content')

<!-- main section -->
<tbody>
    <tr>
        <td style= "padding: 50px 80px; font-family: Arial, Helvetica, sans-serif; color: #000000;">
            <h2 style="font-style: italic">Hola {{ $adminUser->firstName }}</h2>
            
            <p style="font-size: 12px; margin: 10px 0 50px 0;">
                Bienvenido
                <br/><br/>
                {{ $notificationMessage }}
                <br/><br/>
                Puedes iniciar sesión presionando el siguiente <a href="{{ $url }}">aquí</a>
            </p>
        </td>
    </tr>
</tbody>
        
<!-- end main section -->

@stop   