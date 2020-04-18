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
            <h3>Member View </h3>
         </div> <!-- /widget-header -->
         <h2 style="display: none; color: green;" id="deleteMsg">Member Deleted Successfully</h2>
         <h2 style="display: none; color: green;" id="updatedMsg">Member updated Successfully</h2>
         <h2 style="display: none; color: green;" id="activeMsg">Member Active Successfully</h2>
         <h2 style="display: none; color: green;" id="inactiveMsg">Publisher Inactive Successfully</h2>
         <div class="widget-content form-horizontal form-wrp" id="wrp-bg">
            <span id="loader1"></span>
         </div> <!-- /widget-content -->     
      </div>
         <div class="widget-content">
            <table class="table table-bordered" id="myTable" style="">            
               <thead>
                  <tr>
                     <th width="10%">SL</th>                       
                     <th width="30%">Member Name</th>           
                     <th width="20%">Member ID</th>
                     <th width="20%">Member Mobile</th>
                     <th width="10%">Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody id="tbody">
                  <?php $i=0; ?>
                  @if(!empty($datas))
                     @foreach($datas as $key=>$value)
                     <tr id="deleteTr">
                        <td>{{++$i}}</td>
                        <td>
                           <span>{{$value->student_name_english}}</span>
                        </td>
                        <td>
                           <span>{{$value->fk_custom_student_id}}</span>
                        </td>
                        <td>
                           <span>{{$value->present_phone_mobile}}</span>
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
                          <a class="btn btn-danger btn-xs delete_member" data-id="{{$value->memberId}}" href="javascript:;"><i class="icon_close_alt2"></i> Delete</a>
                           @if($value->status==0)
                           <a class="btn btn-success btn-xs memberInactive" data-id="{{$value->memberId}}" href="javascript:;"><i class="icon_close_alt2"></i>Active</a>
                           @endif
                           @if($value->status!=0)
                           <a class="btn btn-danger btn-xs memberActive" data-id="{{$value->memberId}}" href="javascript:;"><i class="icon_close_alt2"></i>Inactive</a>
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
   //=====================DELETE Section Start====================   
      $('.delete_member').on('click',function(){
         if(confirm("are u sure?")){
            var thisProf=$(this);
            var memberId=$(this).attr('data-id');
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('deleteMember')}}/",
        data:{memberId:memberId},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
               if(data.status==true){
                  thisProf.parent().parent().hide(3000);
                  $('#deleteMsg').show(3000,function(){
                     $(this).hide(3000,function(){
                     })
                  });
               }
               else{
                    $(".printPreviewNone").slideDown(3000,function(){
                    $(this).empty().append("<h4 style='color:white; background-color:red; padding:10px;'>Already Used!!</h4>").slideUp(3000);
                 })
               }
            
            },
        error: function(data) {
               alert("somthing went wrong");
            }
        });
      }
      });
  $(".memberActive, .memberInactive").on('click',function(){
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
} );
   //=====================DELETE Section End====================
   </script>
@endsection