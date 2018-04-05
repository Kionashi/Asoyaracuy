@extends('templates.admin.master.index') 
@section('title', 'Pagos') 
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!-- Header -->
                <!-- Body -->
                <div class="box-body">
                    <table id="payment-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Tipo de pago</th>
                                <th>Banco</th>
                                <th>Estado</th>
                                <th>C&oacute;digo de confirmaci&oacute;n</th>
                                <th>Fecha de pago</th>
                                <th>Monto</th>
                                @if(\AdminAuthHelper::hasAnyPermissions('management/payments/detail'))
                                    <th class="text-center btn-group-{{\AdminAuthHelper::countPermissions('management/payments/detail')}}">Acci&oacute;n</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->id}}</td>
                                <td>{{$payment->user->house}}</td>
                                <td>{{\PaymentType::getFriendlyName($payment->type)}}</td>
                                <td>{{$payment->bank}}</td>
                                <td>{{\PaymentStatus::getFriendlyName($payment->status)}}</td>
                                <td>{{$payment->confirmationCode}}</td>
                                <td>{{$payment->date}}</td>
                                <td>{{$payment->amount}}</td>
                                @if(\AdminAuthHelper::hasAnyPermissions('management/payments/detail'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(\AdminAuthHelper::hasPermission('management/payments/detail'))
                                                <a href="{{route('management/payments/detail', $payment->id)}}" class="btn btn-sm btn-success" title="View"> 
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
        
          $("#payment-table").DataTable({
            "order": [[ 0, "desc" ]],
            "iDisplayLength":pageDefault,
            "lengthMenu": [pageSizes, pageLabels]
        });
    });
</script>
@include('templates.admin.master.data-tables-es')
@stop
