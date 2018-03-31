@extends('templates.admin.master.index') 
@section('title', 'Admin users') 
@section('content')
<!-- Select2 -->
{!! Html::style('admin/css/select2.min.css') !!}
<!-- iCheck -->
{!! Html::style('admin/plugins/iCheck/minimal/red.css') !!}
<section class="content">
    @if (count($errors) > 0)
        <div class="col-xs-12">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b><i class="icon fa fa-ban"></i>Error! </b> {{ $errors->first('message') }}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                @if(AdminAuthHelper::hasPermission('management/admin-users/add'))
                <div class="margin text-right">
                    <a href="{{route('management/admin-users/add')}}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar nuevo administrador</a>
                </div>
                @endif
                
                <!-- Body -->
                <div class="box-body">
                    <table id="admin-user-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo electrónico</th>
                                <th class="text-center">Habilitado</th>
                                @if(AdminAuthHelper::hasAnyPermissions('management/admin-users/detail,management/admin-users/edit,management/admin-users/delete'))
                                    <th class="text-center btn-group-{{AdminAuthHelper::countPermissions('management/admin-users/detail,management/admin-users/edit,management/admin-users/delete')}}">Acciones</th>
                                @endif    
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adminUsers as $adminUser)
                            <tr>
                                <td>{{ $adminUser->id }}</td>
                                <td>{{ $adminUser->firstName }}</td>
                                <td>{{ $adminUser->lastName }}</td>
                                <td>{{ $adminUser->email }}</td>
                                <td class="text-center">{{ Form::checkbox('enabled', '', $adminUser->enabled, array('disabled', 'class' => 'minimal-red')) }}</td>
                                @if(AdminAuthHelper::hasAnyPermissions('management/admin-users/detail,management/admin-users/edit,management/admin-users/delete'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(AdminAuthHelper::hasPermission('management/admin-users/detail'))
                                                <a href="{{route('management/admin-users/detail', $adminUser->id)}}" class="btn btn-sm btn-success" title="View">
                                                    <i class="fa fa-file"></i>
                                                </a>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/admin-users/edit'))
                                                <a href="{{route('management/admin-users/edit', $adminUser->id)}}" class="btn btn-sm btn-info" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/admin-users/delete'))
                                                <button type="button" title="Delete" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{$adminUser->id}}" {{($adminUser->id != session()->get('admin.auth.admin-user.id'))?'':'disabled'}}>
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
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
    
    <!-- Modal -->
    <div class="modal modal fade" id="deleteModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <a href="" id="confirmDeleteLink" class="btn btn-danger"> Si</a>
              </div>
            </div>
        </div>
    </div>
</section>
@stop 

@section('custom_script')
<!-- Select2 -->
{!! Html::script('admin/js/select2.full.min.js') !!}
<!-- iCheck -->
{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}
<script type="text/javascript">
    // Styles to checkbox
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    
     $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = $(event.relatedTarget) 
            
            // Get the carousel item id
            var adminUserId = button.data('id')
            
            // Open modal
            var modal = $(this)
            
            // Create URL
            var url = "{{ route('management/admin-users/delete','') }}/" + adminUserId;
    
            // Set message to modal body
            modal.find('.modal-body').text('Estás seguro de que deseas eliminar al administrador #' + adminUserId + '?')
            
            // Set URL to modal href
            $("#confirmDeleteLink").attr('href', url);
        })

        // Styles to type filter
        $("#typeFilter").select2({
            minimumResultsForSearch: Infinity
        });

        // Datatable configuration
        var pageDefault = {{ $pageDefault }};
        var pageSizes = [];
        var pageLabels = [];
    
        @foreach($pageSizes as $pageSize)
            pageSizes.push(parseInt({{ $pageSize }}));
            pageLabels.push({{ $pageSize }});
        @endforeach
        
        dataTable = $("#admin-user-table").DataTable({
            "lengthMenu": [pageSizes, pageLabels],
            "iDisplayLength":pageDefault,
        });

    });    
</script>
@include('templates.admin.master.data-tables-es')
@stop
