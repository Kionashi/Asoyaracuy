@extends('templates.admin.master.index') 
@section('title', 'Users') 
@section('content')
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

                <!-- Body -->
                <div class="box-body">
                    <table id="user-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Monto</th>
                                <th>Quinta</th>
                                @if(AdminAuthHelper::hasAnyPermissions('management/special-fees/edit,management/special-fees/delete'))
                                    <th class="text-center btn-group-{{AdminAuthHelper::countPermissions('management/special-fees/delete')}}">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($specialFees as $specialFee)
                            <tr>
                                <td>{{$specialFee->id}}</td>
                                <td>{{$specialFee->amount}}</td>
                                <td>{{$specialFee->user->house}}</td>
                                @if(AdminAuthHelper::hasAnyPermissions('management/special-fees/delete'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(AdminAuthHelper::hasPermission('management/special-fees/delete'))
                                                <button type="button" title="Delete" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{$specialFee->id}}">
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
            var button = $(event.relatedTarget);
            
            // Get user id
            var specialFeeId = button.data('id');
            
            // Open modal
            var modal = $(this);
            
            // Create URL
            var url = "{{ route('management/special-fees/delete','') }}/" + specialFeeId;
    
            // Set message to modal body
            modal.find('.modal-body').text('¿Estás seguro de que deseas eliminar la cuota especial #' + specialFeeId + '?')
            
            // Set URL to modal href
            $("#confirmDeleteLink").attr('href', url);
        });

        var pageDefault = {{ $pageDefault }};
        var pageSizes = [];
        var pageLabels = [];

        @foreach($pageSizes as $pageSize)
            pageSizes.push(parseInt({{ $pageSize }}));
            pageLabels.push({{ $pageSize }});
        @endforeach
        
          $("#user-table").DataTable({
            "order": [[ 1, "asc" ], [ 2, "asc" ], [ 3, "asc" ]],
            "iDisplayLength":pageDefault,
            "lengthMenu": [pageSizes, pageLabels]
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop
