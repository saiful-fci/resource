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
            <h3>Publisher View </h3>
         </div> <!-- /widget-header -->
         <h2 style="display: none; color: green;" id="deleteMsg">Publisher Deleted Successfully</h2>
         <h2 style="display: none; color: green;" id="updatedMsg">Publisher updated Successfully</h2>
         <h2 style="display: none; color: green;" id="activeMsg">Publisher Active Successfully</h2>
         <h2 style="display: none; color: green;" id="inactiveMsg">Publisher Inactive Successfully</h2>
         <div class="widget-content form-horizontal form-wrp" id="wrp-bg">
         </div> <!-- /widget-content -->     
      </div>
         <div class="widget-content">
            <table class="table table-bordered" id="myTable" style="">            
               <thead>
                  <tr>
                     <th width="05%">SL</th>                       
                     <th width="22%">Publisher Name</th>           
                     <th width="13%">Publisher Mobile</th>
                     <th width="10%">Publisher Email</th>
                     <th width="28%">Publisher Address</th>
                     <th width="5%">Status</th>
                     <th width="17%">Action</th>
                  </tr>
               </thead>
               <tbody id="tbody">
                  <?php $i=0; ?>
                  @if(!empty($datas))
                     @foreach($datas as $key=>$value)
                     <tr id="deleteTr">
                        <td>{{++$i}}</td>
                        <td>
                           <span>{{$value->publisher_name}}</span>
                           <input type="text" name="publisher_name" id="publisher_name-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->publisher_name}}">
                        </td>
                        <td>
                           <span>{{$value->publisher_mobile}}</span>
                           <input type="text" name="publisher_mobile" id="publisher_mobile-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->publisher_mobile}}">
                        </td>
                        <td>
                           <span>{{$value->publisher_email}}</span>
                           <input type="text" name="publisher_email" id="publisher_email-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->publisher_email}}">
                        </td>
                        <td>
                           <span>{{$value->publisher_address}}</span>
                           <input type="text" name="publisher_address" id="publisher_address-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->publisher_address}}">
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
                                 <a class="btn btn-danger btn-xs delete_publisher" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i> Delete</a>
                                 @if($value->status==0)
                                 <a class="btn btn-success btn-xs inactive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Active</a>
                                 @endif
                                 @if($value->status!=0)
                                 <a class="btn btn-danger btn-xs active" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Inactive</a>
                                 @endif
                        </td>
                     @endforeach
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
         var publisherId=thisProf.attr('data-id');
         thisProf.hide().next().show().next().show();
         $('#publisher_name-'+publisherId).show().prev().hide();
         $('#publisher_mobile-'+publisherId).show().prev().hide();
         $('#publisher_email-'+publisherId).show().prev().hide();
         $('#publisher_address-'+publisherId).show().prev().hide();

      })
   //=====================Edit Section End====================
   //=====================update section start================
      $('.save-btn').on('click',function(){
         var thisProf=$(this);
         var publisherId=thisProf.attr('data-id');
         var publisher_name=$('#publisher_name-'+publisherId).val();
         var publisher_email=$('#publisher_email-'+publisherId).val();
         var publisher_mobile=$('#publisher_mobile-'+publisherId).val();
         var publisher_address=$('#publisher_address-'+publisherId).val();
         $.ajax({
           type: "GET",
           dataType:'json',
           url:"{{URL::to('updatePublisher')}}/"+publisherId,
           data:{publisher_name:publisher_name,publisher_email:publisher_email,publisher_mobile:publisher_mobile,publisher_address:publisher_address},
           beforeSend: function() {
               return "error";
               },
           success: function(data) {
               if(data==true){   
                     thisProf.hide().prev().show().next().next().hide();
                     $('#publisher_name-'+publisherId).hide().prev().show().html(publisher_name);
                     $('#publisher_mobile-'+publisherId).hide().prev().show().html(publisher_mobile);
                     $('#publisher_email-'+publisherId).hide().prev().show().html(publisher_email);
                     $('#publisher_address-'+publisherId).hide().prev().show().html(publisher_address);
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
         var publisherId=thisProf.attr('data-id');
         thisProf.hide().prev().hide().prev().show();
         $('#publisher_name-'+publisherId).hide().prev().show();
         $('#publisher_mobile-'+publisherId).hide().prev().show();
         $('#publisher_email-'+publisherId).hide().prev().show();
         $('#publisher_address-'+publisherId).hide().prev().show();
      });

   //=====================Reset Section End====================   

   //=====================DELETE Section Start====================   
      $('.delete_publisher').on('click',function(){
         if(confirm("are u sure?")){
            var thisProf=$(this);
            var publisherId=$(this).attr('data-id');
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('deletePublisher')}}/",
        data:{publisherId:publisherId},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
               if(data==true){
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
               $(".printPreviewNone").slideDown(900,function(){
                  $(this).empty().append("<h4 style='color:white; background-color:red; padding:10px;'>Already Used!!</h4>").slideUp(3000);
               })
            }
        });
      }
      });
  $(".active,.inactive").on('click',function(){
      var id=$(this).attr("data-id");
      var cls=$(this).attr("class");
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('activeInactive')}}/",
        data:{id:id,cls:cls},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
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
 
 $(document).ready( function () {
    $('#myTable').DataTable();
});
   //=====================DELETE Section End====================
   </script>
@endsection