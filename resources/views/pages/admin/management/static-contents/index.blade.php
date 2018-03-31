@extends('templates.admin.master.index') 
@section('title', 'Admin users') 
@section('content')
<!-- iCheck -->
{!! Html::style('admin/plugins/iCheck/minimal/red.css') !!}
<section class="content">
    @if (count($errors) > 0)
        <div class="col-xs-12">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b><i class="icon fa fa-ban"></i>¡Error! </b> {{ $errors->first('message') }}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                @if(AdminAuthHelper::hasPermission('management/static-contents/add'))
                <div class="margin text-right">
                    <a href="{{route('management/static-contents/add')}}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar nuevo indicador</a>
                </div>
                @endif
                
                <!-- Body -->
                <div class="box-body">
                    <table id="static-content-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sección</th>
                                <th class="text-center">Habilitado</th>
                                @if(AdminAuthHelper::hasAnyPermissions('management/static-contents/detail,management/static-contents/edit,management/static-contents/delete'))
                                    <th class="text-center btn-group-{{AdminAuthHelper::countPermissions('management/static-contents/detail,management/static-contents/edit,management/static-contents/delete')}}">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staticContents as $staticContent)
                            <tr>
                                <td>{{ $staticContent->id }}</td>
                                <td>{{ StaticContentSection::getFriendlyName($staticContent->section) }}</td>
                                <td class="text-center">{{ Form::checkbox('enabled', '', $staticContent->enabled, array('disabled', 'class' => 'minimal-red')) }}</td>
                                @if(AdminAuthHelper::hasAnyPermissions('management/static-contents/detail,management/static-contents/edit,management/static-contents/delete'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(AdminAuthHelper::hasPermission('management/static-contents/detail'))
                                                <a href="{{route('management/static-contents/detail', $staticContent->id)}}" class="btn btn-sm btn-success" title="Detalle">
                                                    <i class="fa fa-file"></i>
                                                </a>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/static-contents/edit'))
                                                <a href="{{route('management/static-contents/edit', $staticContent->id)}}" class="btn btn-sm btn-info" title="Editar">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/static-contents/delete'))
                                                <button type="button" title="Eliminar" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{$staticContent->id}}">
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
            var staticContentId = button.data('id')
            
            // Open modal
            var modal = $(this)
            
            // Create URL
            var url = "{{ route('management/static-contents/delete','') }}/" + staticContentId;
    
            // Set message to modal body
            modal.find('.modal-body').text('Estás seguro de que deseas eliminar el contenido estático #' + staticContentId + '?')
            
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
        
        dataTable = $("#static-content-table").DataTable({
            "lengthMenu": [pageSizes, pageLabels],
            "iDisplayLength":pageDefault,
        });

    });    
</script>
@include('templates.admin.master.data-tables-es')
@stop
