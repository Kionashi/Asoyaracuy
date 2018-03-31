@extends('templates.admin.master.index') 
@section('title', 'Contacts') 
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                <!-- Body -->
                <div class="box-body">
                    <table id="contact-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo electrónico</th>
                                <th>Razón de contacto</th>
                                <th>Fecha</th>
                                @if(\AdminAuthHelper::hasAnyPermissions('management/contacts/detail'))
                                    <th class="text-center btn-group-{{\AdminAuthHelper::countPermissions('management/contacts/detail')}}">Accion</th>
                                @endif
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{$contact->id}}</td>
                                <td>{{$contact->firstName}}</td>
                                <td>{{$contact->lastName}}</td>
                                <td>{{$contact->email}}</td>
                                <td>{{$contact->contactReason->title}}</td>
                                <td>{{\AdminDateHelper::formatDate($contact->dateContact)}}</td>
                                @if(\AdminAuthHelper::hasAnyPermissions('management/contacts/detail'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(\AdminAuthHelper::hasPermission('management/contacts/detail'))
                                                <a href="{{route('management/contacts/detail', $contact->id)}}" class="btn btn-sm btn-success" title="View"> 
                                                    <i class="fa fa-file"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                    
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop 
@section('custom_script')
<script type="text/javascript">
    $(function () {

        var pageDefault = {{ $pageDefault }};
        var pageSizes = [];
        var pageLabels = [];

        @foreach($pageSizes as $pageSize)
            pageSizes.push(parseInt({{ $pageSize }}));
            pageLabels.push({{ $pageSize }});
        @endforeach
        
          $("#contact-table").DataTable({
            "order": [[ 0, "desc" ]],
            "iDisplayLength":pageDefault,
            "lengthMenu": [pageSizes, pageLabels]
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop
