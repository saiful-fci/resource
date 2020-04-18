@extends('app')
@section('content')
<style type="text/css">
   @media print {
      .print{display: block !important;}
      .not-print{display: none !important;}
   }
   #assign{
   	border-radius: 50%;
    display: none;
   }
   #review{
   	border-radius: 50%;
    display: none;
   }
   .count{
   	font-size: 25px;
   	color: red;
   	margin-left: 2px;
   }
   .clickme{
    font-size: 15px;
   }
   .added{
   	display: none;
   	background-color: green;
   	color: white;
   	padding: 5px;
   	border-radius: 50%;
   }
   .remove{
    display: none;
    background-color: red;
    color: white;
    padding: 5px;
    border-radius: 50%;
   }
   .label-success, .label-danger {
    padding: 4px;
  }
</style>
<div class="col-md-12"> 
  <div class="widget stacked printPreviewNone">             
     <div class="widget-header">
        <i class="icon-plus-sign"></i> 
        <h3>Book List </h3>
     </div> <!-- /widget-header -->
     <h2 style="display: none; color: green;" id="activeMsg">Book List Active Successfully</h2>
         <h2 style="display: none; color: green;" id="inactiveMsg">Book List Inactive Successfully</h2>
         <h2 style="display: none; color: green;" id="updatedMsg">Book List updated Successfully</h2>
     <div class="widget-content form-horizontal form-wrp" id="wrp-bg">
        <span>
          <button type="submit" class="pull-right btn btn-success btn-xs" id="assign"data-toggle="modal" href="#modal" onclick="loadModal('bookAssignForm')">Issue</button>
      </span>

        <span>
          <button type="submit" class="pull-left btn btn-info btn-xs" id="review"data-toggle="modal"  href="#modal" onclick="loadModal('choiceList')">Review</button>
          <strong class="count"><?php if(!empty(Session::get("book"))){$datas=Session::get("book");echo count($datas);} ?> 
          <?php if(!empty(Session::get("book")))
            echo "<span class='clickme'>Click Me</span>";
          ?>
          </strong>
          <strong class="added">Added</strong><strong class="remove">Remove</strong></span>
     </div> <!-- /widget-content -->     
  </div>
     <div class="widget-content">
        <table class="table table-bordered" id="myTable" style="">            
           <thead>
              <tr>
                 <th width="03%">SL</th>                       
                 <th width="15%">Book Name</th>           
                 <th width="10%">Book Title</th>
                 <th width="15%">Publisher Name</th>
                 <th width="14%">Author Name</th>
                 <th width="8%">QTY</th>
                 <th width="8%">price</th>
                 <th width="4%">Choice</th>
                 <th width="4%">Stock</th>
                 <th width="4%">status</th>
                 <th width="14%">Action</th>
              </tr>
           </thead>
           <tbody id="tbody">
              <?php $i=0; ?>
              @if(!empty($books))
                 @foreach($books as $key=>$value)
                 <tr id="deleteTr">
                    <td>{{++$i}}</td>
                    <td>
                       <span>{{$value->book_name}}</span>
                    </td>
                    <td>
                       <span>{{$value->book_title}}</span>
                    </td>
                    <td>
                       <span>{{$value->publisher_name}}</span>
                    </td>
                    <td>
                       <span>{{$value->author_name}}</span>
                    </td>
                    <td>
                       <span>{{$value->available_qty}}</span>
                       <input type="text" name="book_qty" id="book_qty-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->available_qty}}">
                    </td>
                    <td>
                       <span>{{$value->price}}</span>
                       <input type="text" name="book_price" id="book_price-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->price}}">
                    </td>
                    <td>
                       <span><input <?Php if($value->available_qty==0 || $value->status==0) echo "disabled"; ?> type="checkbox" name="checkbox" value="{{$value->id}}" id="checkbox"></span>
                    </td>
                    <td>
                      @if($value->available_qty>0)
                      <label class="label label-success stock" data-id="{{$value->id}}"><i class="icon_close_alt2"></i>Stock In</label>
                      @endif
                      @if($value->available_qty==0)
                      <label class="label label-danger out" data-id="{{$value->id}}"><i class="icon_close_alt2"></i>Stock out</label>
                      @endif
                    </td>
                    <td>
                      @if($value->status!=0)
                      <label class="label label-success">Active</label>
                      @endif
                      @if($value->status==0)
                      <label class="label label-danger">Inactive</label>
                      @endif
                    </td>
                    <td>
                       <a class="btn btn-primary btn-xs edit-btn" href="javascript:;" data-id="{{$value->id}}"><i class="fa fa-edit"></i> Edit</a>
                     <a class="btn btn-success btn-xs save-btn" href="javascript:;" style="display: none;" data-id="{{$value->id}}"><i class="fa fa-save"></i> Save</a>
                     <a class="btn btn-warning btn-xs btn-reset" href="javascript:;" style="display: none;" data-id="{{$value->id}}"><i class="fa fa-refresh fa-spin"></i> Reset</a>
                     <!-- <a class="btn btn-danger btn-xs delete_book" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i> Delete</a> -->
                     @if($value->status==0)
                     <a class="btn btn-success btn-xs b_listActive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Active</a>
                     @endif
                     @if($value->status!=0)
                     <a class="btn btn-danger btn-xs b_listInactive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Inactive</a>
                     @endif
                    </td>
                 @endforeach
              @endif
              </tr> 
           </tbody>
        </table>
     </div> <!-- .widget-content -->
  </div>  
   <script type="text/javascript">
		 $(document).ready( function () {
		   $('#myTable').DataTable();

	$("#myTable").on('click',"#checkbox",function(){
		$("#assign, #review").show(300);
		var bookId=$(this).val();
		var checkedStatus;
			if (this.checked) {
				checkedStatus = 1;
        $(".added").fadeIn(900,function(){
                $(this).fadeOut(900);
            })
			}if (!this.checked) {
				checkedStatus = 0;
        $(".remove").fadeIn(900,function(){
                $(this).fadeOut(900);
            })
			}
			$.ajax({
		        type: "GET",
		        dataType:'json',
		        url:"{{URL::to('bookIssueForm')}}/",
		        data:{"bookId":bookId,'checked_status' : checkedStatus},
		        beforeSend: function() {
		            return "error";
		            },
		        success: function(data) {
		          var count=data.length;
		          $(".count").html(count);
		            },
		        error: function(data) {
		               alert("somthing went wrong");
		            }
			});
	});
$(".b_listActive, .b_listInactive").on('click',function(){
      var id=$(this).attr("data-id");
      var cls=$(this).attr("class");
      // alert(cls);
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('activeInactive')}}/",
        data:{id:id,cls:cls},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
          // console.log(data);
          // return false;
               if(data==true){
                  $("#inactiveMsg").show(900,function(){
                    $(this).hide(900,function(){
                      location.reload();
                    });
                  });
                  
               }else{
                  $("#activeMsg").show(900,function(){
                    $(this).hide(900,function(){
                      location.reload();
                    });
                  });
               }
            
            },
        error: function(data) {
               alert("somthing went wrong");
            }
        });
  })
$(".edit-btn").on('click',function(){
    var thisProf=$(this);
    var id=thisProf.attr("data-id");
     thisProf.hide().next().show().next().show();
     $("#book_price-"+id).show().prev().hide();
     $("#book_qty-"+id).show().prev().hide();
});

$('.save-btn').on('click',function(){
     var thisProf=$(this);
     var bookId=thisProf.attr('data-id');
     var book_price=$('#book_price-'+bookId).val();
     var book_qty=$('#book_qty-'+bookId).val();
     $.ajax({
       type: "GET",
       dataType:'json',
       url:"{{URL::to('updateBookList')}}/",
       data:{bookId:bookId,book_price:book_price,book_qty:book_qty},
       beforeSend: function() {
           return "error";
           },
       success: function(data) {
           if(data.status==true){   
                 thisProf.hide().prev().show().next().next().hide();
                 $('#book_price-'+bookId).hide().prev().show().html(book_price);
                 $('#book_qty-'+bookId).hide().prev().show().html(book_qty);
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

$('.btn-reset').on('click',function(){id
     var thisProf=$(this);
     var id=thisProf.attr('data-id');
     thisProf.hide().prev().hide().prev().show();
     $('#book_price-'+id).hide().prev().show();
     $('#book_qty-'+id).hide().prev().show();
});

$(".count .clickme").on('click',function(){
    $("#assign, #review").show(300);
    $(".clickme").hide();
  })
});
   </script>
@endsection