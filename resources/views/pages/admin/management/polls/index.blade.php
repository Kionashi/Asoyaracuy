@extends('templates.admin.master.index') 
@section('title', 'Encuestas') 
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
                @if(AdminAuthHelper::hasPermission('management/polls/add'))
                <div class="margin text-right">
                    <a href="{{route('management/polls/add')}}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar nueva encuesta</a>
                </div>
                @endif

                <!-- Body -->
                <div class="box-body">
                    <table id="poll-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de fin</th>
                                <th>Habilitado</th>
                                @if(AdminAuthHelper::hasAnyPermissions('management/polls/detail,management/polls/edit,management/polls/delete'))
                                    <th class="text-center btn-group-{{AdminAuthHelper::countPermissions('management/polls/detail,management/polls/edit,management/polls/delete')}}">Acciones</th>
                                @endif
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($polls as $poll)
                            <tr>
                                <td>{{$poll->id}}</td>
                                <td>{{$poll->title}}</td>
                                <td>{{$poll->startDate}}</td>
                                <td>{{$poll->endDate}}</td>
                                <td class="text-center">{{ Form::checkbox('enabled', '', $poll->enabled, array('disabled', 'class' => 'minimal-red')) }}</td>
                                @if(AdminAuthHelper::hasAnyPermissions('management/polls/detail,management/polls/edit,management/polls/delete'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(AdminAuthHelper::hasPermission('management/polls/detail'))
                                                <a href="{{route('management/polls/detail', $poll->id)}}" class="btn btn-sm btn-success" title="Detalle">
                                                    <i class="fa fa-file"></i>
                                                </a>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/polls/edit'))
                                                <a href="{{route('management/polls/edit', $poll->id)}}" class="btn btn-sm btn-info" title="Editar">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/polls/delete'))
                                                <button type="button" title="Delete" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{$poll->id}}">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            @endif
                                            @if(AdminAuthHelper::hasPermission('management/polls/result'))
                                                <a href="{{route('management/polls/result', $poll->id)}}" class="btn bg-gray btn-sm" title="Resultados">
                                                    <i class="fa fa-pie-chart"></i>
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
                <a href="" id="confirmDeleteLink" class="btn btn-danger">Si</a>
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
        $('#deleteModal').on('show.bs.modal', function (poll) {
            // Button that triggered the modal
            var button = $(poll.relatedTarget);
            
            // Get poll id
            var pollId = button.data('id');
            
            // Open modal
            var modal = $(this);
            
            // Create URL
            var url = "{{ route('management/polls/delete','') }}/" + pollId;
    
            // Set message to modal body
            modal.find('.modal-body').text('¿Estás seguro de que deseas eliminar la encuesta #' + pollId + '?')
            
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
        
          $("#poll-table").DataTable({
            "iDisplayLength":pageDefault,
            "lengthMenu": [pageSizes, pageLabels]
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop
