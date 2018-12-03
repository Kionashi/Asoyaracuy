@extends('templates.frontend.master.index')
@section('content')
	<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                <div class="margin text-right">
                    <a href="{{route('payments/add')}}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;&nbsp;Registrar nuevo pago</a>
                </div>
                <!-- Body -->
                <div class="box-body">
                    <table id="payment-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de pago</th>
                                <th>Banco</th>
                                <th>Estado</th>
                                <th>C&oacute;digo de confirmaci&oacute;n</th>
                                <th>Fecha de pago</th>
                                <th>Monto</th>
                                    <th class="text-center btn-group-1">Acci&oacute;n</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($payments))
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->id}}</td>
                                <td>@if($payment->type == 'CASH')
                                    Efectivo 
                                    @endif
                                    @if($payment->type == 'DEPOSIT')
                                    Deposito
                                    @endif
                                    @if($payment->type == 'TRANSFERENCE')
                                    Transferencia
                                    @endif
                                </td>
                                <td>{{$payment->bank}}</td>
                                <td>{{$payment->status}}</td>
                                <td>{{$payment->confirmationCode}}</td>
                                <td>{{$payment->date}}</td>
                                <td>{{$payment->amount}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                            <a href="{{route('payments/detail', $payment->id)}}" class="btn btn-sm btn-success" title="View"> 
                                                <i class="fa fa-file"></i>
                                            </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
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
        
          $("#payment-table").DataTable({
            "order": [[ 0, "desc" ]],
            "iDisplayLength":pageDefault,
            "lengthMenu": [pageSizes, pageLabels]
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop  
