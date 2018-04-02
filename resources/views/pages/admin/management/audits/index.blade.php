@extends('templates.admin.master.index') 
@section('title', 'Auditorias') 
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                <!-- Body -->
                <div class="box-body">
                    <table id="audit-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Acci&oacute;n</th>
                                <th>Ejecutor</th>
                                <th>Fecha</th>
                                @if(\AdminAuthHelper::hasAnyPermissions('audits/detail'))
                                    <th class="text-center btn-group-{{\AdminAuthHelper::countPermissions('audits/detail')}}">Accion</th>
                                @endif
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($audits as $audit)
                            <tr>
                                <td>{{$audit->id}}</td>
                                <td>{{$audit->action}}</td>
                                <td>{{$audit->adminUser->firstName}}</td>
                                <td>{{$audit->created_at}}</td>
                                @if(\AdminAuthHelper::hasAnyPermissions('audits/detail'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(\AdminAuthHelper::hasPermission('audits/detail'))
                                                <a href="{{route('audits/detail', $audit->id)}}" class="btn btn-sm btn-success" title="View"> 
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
        
          $("#audit-table").DataTable({
            "order": [[ 0, "desc" ]],
            "iDisplayLength":pageDefault,
            "lengthMenu": [pageSizes, pageLabels]
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop
