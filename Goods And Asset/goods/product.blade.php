@extends('app')
@section('content')
<style type="text/css">
	@media print {
		.print{display: block !important;}
		.not-print{display: none !important;}
	}
</style>
    <div class="col-md-12"> 
    	<div class="widget stacked printPreviewNone">				 
			<div class="widget-header">
				<i class="icon-plus-sign"></i> 
				<h3>Product Report View </h3>
			</div> <!-- /widget-header -->
			<h2 style="display: none; color: green;" id="deleteMsg">Product Deleted Successfully</h2>
			<h2 style="display: none; color: green;" id="updatedMsg">Product updated Successfully</h2>
			<div class="widget-content form-horizontal form-wrp" id="wrp-bg">
				<span id="loader1"></span>
			</div> <!-- /widget-content -->		
		</div>

		<!-- ## Section Wise student payment ## -->
		<div class="widget stacked widget-table" id="showDiv">	
			<div class="printPreviewTitle">
				<h5 class="printTitle" style="color: green;">Product List Report</h5>
			</div>	

			<div class="widget-header printPreviewNone">
				<span class="icon-sort-by-attributes-alt"></span>
				<h3>Product List Report</h3>
			</div> <!-- .widget-header -->
			
			<div class="widget-content">
				<table class="table table-bordered" style="">				
					<thead>
						<tr>
							<th width="5%">SL</th>								
							<th width="10%">Category Name</th>									
							<th width="10%">Subcategory Name</th>									
							<th width="10%">Quantity</th>									
							<th width="15%">Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php $i=0; ?>
						@if(!empty($products))
							@foreach($products as $key=>$value)
							<tr id="deleteTr">
								<td>{{++$i}}</td>
								<td>
									<span>{{$value->category_name}}</span>
									<input type="text" name="category_name" id="category_name-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->category_name}}">
								</td>
								<td>
									<span>{{$value->goods_SubCat_name}}</span>
									<input type="text" name="goods_SubCat_name" id="goods_SubCat_name-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->goods_SubCat_name}}">
								</td>
								<td>
									<span>{{$value->quantity}}</span>
									<input type="text" name="quantity" id="quantity-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->quantity}}">

								</td>
								<td>
									<a class="btn btn-primary btn-xs edit-btn" href="javascript:;" data-id="{{$value->id}}"><i class="fa fa-edit"></i> Edit</a>
			                        <a class="btn btn-success btn-xs save-btn" href="javascript:;" style="display: none;" data-id="{{$value->id}}"><i class="fa fa-save"></i> Save</a>
			                        <a class="btn btn-warning btn-xs btn-reset" href="javascript:;" style="display: none;" data-id="{{$value->id}}"><i class="fa fa-refresh fa-spin"></i> Reset</a>
			                        <a class="btn btn-danger btn-xs delete_product" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i> Delete</a>
								</td>
							@endforeach
						@else
							Data Not Found
						@endif
						</tr>	
					</tbody>
				</table>
			</div> <!-- .widget-content -->
			
		</div> 
	</div>	
	
	<script type="text/javascript">
		//=====================Edit Section Start====================	
		$('.edit-btn').on('click',function(){
			var thisProf=$(this);
			var productId=thisProf.attr('data-id');
			thisProf.hide().next().show().next().show();
			// $('#category_name-'+productId).show().prev().hide();
			// $('#goods_SubCat_name-'+productId).show().prev().hide();
			$('#quantity-'+productId).show().prev().hide();

		})
	//=====================Edit Section End====================
	//=====================update section start================
		$('.save-btn').on('click',function(){
			var thisProf=$(this);
			var productId=thisProf.attr('data-id');
			var newQuntity=$('#quantity-'+productId).val();
			$.ajax({
	        type: "GET",
	        dataType:'json',
	        url:"{{URL::to('updateProduct')}}/"+productId,
	        data:{newQuntity:newQuntity},
	        beforeSend: function() {
	            return "error";
	            },
	        success: function(data) {
	        		if(data.status===true){		
		            	thisProf.hide().prev().show().next().next().hide();
		            	$('#quantity-'+productId).hide().prev().show().html(newQuntity);
		            	$('#updatedMsg').show(3000,function(){
		            		$(this).hide(3000)
		            	})
	        		}
	            
	            },
	        error: function(data) {
	               alert("somthing went wrong");
	            }
	        });

		});	

	//=====================update section end================	

	//=====================Reset Section Start====================	
		$('.btn-reset').on('click',function(){
			var thisProf=$(this);
			var productId=thisProf.attr('data-id');
			thisProf.hide().prev().hide().prev().show();
			$('#category_name-'+productId).hide().prev().show();
			$('#goods_SubCat_name-'+productId).hide().prev().show();
			$('#quantity-'+productId).hide().prev().show();
		});

	//=====================Reset Section End====================	

	//=====================DELETE Section Start====================	
		$('.delete_product').on('click',function(){
			if(confirm("are u sure?")){
				var thisProf=$(this);
				var productId=$(this).attr('data-id');
		$.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('deleteProduct')}}/",
        data:{productId:productId},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
            	if(data=1){
            		thisProf.parent().parent().hide(3000);
            		$('#deleteMsg').show(3000,function(){
            			$(this).hide(3000,function(){
            			})
            		});
            	}else{
            		alert("wrong");
            	}
            
            },
        error: function(data) {
               alert("somthing went wrong");
            }
        });
		}
		});
	//=====================DELETE Section End====================
	</script>
@endsection