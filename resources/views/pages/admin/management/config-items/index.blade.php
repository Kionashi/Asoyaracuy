@extends('templates.admin.master.index') 
@section('title', 'Config items') 
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                <div class="margin text-right">
                </div>
                <!-- Body -->
                <div class="box-body">
                    <table id="config-item-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Clave</th>
                                <th>Valor</th>
                                @if(AdminAuthHelper::hasAnyPermissions('management/config-items/detail,management/config-items/edit'))
                                    <th class="text-center btn-group-{{AdminAuthHelper::countPermissions('management/config-items/detail,management/config-items/edit')}}">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($configItems as $i => $configItem)
                            <tr>
                                <td>{{$configItem->id}}</td>
                                <td>{{$configItem->key}}</td>
                                <td><div style="word-break:break-all;"> {{$configItem->value}} </div></td>
                                <td class="text-center" style="display:{{AdminAuthHelper::hasAnyPermissions('management/config-items/detail,management/config-items/edit')?'':'none'}}">
                                    <div class="btn-group">
                                        @if(AdminAuthHelper::hasPermission('management/config-items/detail'))
                                            <a href="{{route('management/config-items/detail', $configItem->id)}}" class="btn btn-sm btn-success" title="View">
                                                <i class="fa fa-file"></i>
                                            </a>
                                        @endif
                                        @if(AdminAuthHelper::hasPermission('management/config-items/edit'))
                                            <a href="{{route('management/config-items/edit', $configItem->id)}}" class="btn btn-sm btn-info" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
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

        var dataTable = $("#config-item-table").DataTable({
            "lengthMenu": [pageSizes, pageLabels],
            "iDisplayLength":pageDefault
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop