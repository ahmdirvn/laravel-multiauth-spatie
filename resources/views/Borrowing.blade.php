@extends('layouts.app', ['active' => 'borrow'])
@section('header')
<div class="page-header page-header-default">
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Borrowing </a></li>
			<li class="active">Borrow</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="content">
	<div class="row">
		<div class=" panel panel-flat">
			<div class="panel-body">
				<div class="col-lg-10">
					<form action="" id="form-scan">
						@csrf
						<div class="row">
							<div class="col-lg-6">
								<label><b>Scan Barcode</b></label>
								<input type="text" name="barcode_id" id="barcode_id" class="form-control input-new" placeholder="#scan in here" required="">
							</div>
							<div class="col-lg-3">
								<label><b>Location</b></label>
								<select class="select-search form-control" id="loct">
									<option value="">-- Choose Location --</option>
									@foreach($dept as $dt)
										<option value="{{ $dt->value_name }}">{{$dt->dept_name}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-lg-3">
								<label><b>Borrower</b></label>
								<input type="text" name="txname" id="txname" class="form-control" readonly="" style="text-align: center; font-size: 20px;">
								<input type="text" name="txnik" id="txnik" class="hidden">
							</div>
							
						</div>					
					</form>
				</div>
				<div class="col-lg-2">

					<input type="text" name="_count" id="_count" class="form-control" value="0" readonly="" style="text-align: center; font-size: 28px; margin-top: 30px;">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class=" panel panel-flat">
			<div class="panel-body">
				<div class="table-responsive">
					<table class ="table table-basic table-condensed" id="table-list">
						<thead>
							<tr>
								<th>Barcode ID</th>
								<th>Doc. No.</th>
								<th>Season</th>
								<th>Style</th>
								<th>Article</th>
								<th>Size</th>
								<th>Status</th>
								<th>Expired Date</th>
								<th></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection



@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('#barcode_id').focus();

	$('.input-new').keypress(function(event){
		if (event.which==13) {
			event.preventDefault();

			var bargar = $('#barcode_id').val();
			// var status = $('input[name=radio_status]:checked').val();
			var loct = $('#loct').val();
			var nik = $('#txnik').val();

			if (bargar=="") {
				alert(422,"Barcode Garment required ! ! ! ");

				return false;
			}

			if (loct=="") {
				alert(422,"Location required ! ! ! ");

				return false;
			}

			if (nik=="") {
				setNik(bargar);
			}else{
				scanGarment(bargar,loct,nik);
			}
			
		}
	});

	
});

function scanGarment(bargar,loct,nik){
	$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
	    $.ajax({
	        type: 'post',
	        url : $('#form-scan').attr('action'),
	        data:{bargar:bargar,loct:loct,nik:nik},
	        beforeSend : function(){
	        	loading();
	        	$('#barcode_id').focus();
	        	$('#barcode_id').val('');
	        },
	        success: function(response) {
	        	$.unblockUI();
	        	$('#table-list > tbody').prepend(response);
	        	var counts = +$('#_count').val()+1;

	        	$('#_count').val(counts);

	        	
	        },
	        error: function(response) {
	        	$.unblockUI();
	           	alert(response.status,response.responseText);
	            
	        }
	    });
}

function setNik(nik){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'post',
        url : ,
        data:{nik:nik},
        beforeSend : function(){
        	loading();
        	$('#barcode_id').focus();
        	$('#barcode_id').val('');
        },
        success: function(response) {
        	$('#txname').val(response.name);
        	$('#txnik').val(response.nik);
        	$.unblockUI();        	
        },
        error: function(response) {
        	$.unblockUI();
           	alert(response.status,response.responseText);
            
        }
    });
}
</script>
@endsection