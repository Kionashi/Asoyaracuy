@extends('templates.admin.master.index') 
@section('title', 'Encuestas') 
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Body -->
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
            </ul>
            {!! Form::model($poll, array('files' => true, 'id' => 'editPollForm', 'class' => 'panel-body form-horizontal')) !!}
                <div class="tab-content">
                    <div class="box-body">
                    	<div class="poll-result-title">
                    		{!! Form::label('title', $poll->title, array('class' => '')) !!}
                    	</div>
                        <div class="poll-result-container">
                    		<canvas id="poll-result-chart" style="display: <?=$hasBeenResponded?'block':'none'?>;"></canvas>
                    		<div class="poll-no-result" style="display: <?=$hasBeenResponded?'none':'block'?>;">No hay resultados para esta encuesta</div>
                    	</div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <a href="{{ route('management/polls') }}" class="btn btn-default">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop

@section('custom_script')
<!-- iCheck -->
{!! Html::script('admin/js/chart.min.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        let elements = <?=$elements?>;
        console.log(elements);
        
		// Get elements
		let backgroundColor = [];
		let data = [];
		let labels = [];
		for(let element of elements) {
			backgroundColor.push(element.color);
			data.push(element.user_has_poll_options.length);
			labels.push(element.title);
		}
		
		// Initialize chart
		var ctx = document.getElementById('poll-result-chart');
		if (ctx != null) {
			var chart = new Chart(ctx, {
		        type: 'doughnut',
		        options: {
					legend: {
			            display: true,
			            labels: {
							display: false,
						},
			            position: 'bottom',
			            
			        }
		        },
		        data: {
		            labels: labels,
		            datasets: [{
		                data: data,
		                backgroundColor: backgroundColor,
		                hoverBackgroundColor: backgroundColor
	            	}]
	            }
        	});
		}
    });
</script>
@stop