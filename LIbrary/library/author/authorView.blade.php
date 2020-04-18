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
            <h3>Author View </h3>
         </div> <!-- /widget-header -->
         <h2 style="display: none; color: green;" id="deleteMsg">Author Deleted Successfully</h2>
         <h2 style="display: none; color: green;" id="updatedMsg">Author updated Successfully</h2>
         <h2 style="display: none; color: green;" id="activeMsg">Author Active Successfully</h2>
         <h2 style="display: none; color: green;" id="inactiveMsg">Author Inactive Successfully</h2>
         <div class="widget-content form-horizontal form-wrp" id="wrp-bg">
            <span id="loader1"></span>
         </div> <!-- /widget-content -->     
      </div>
         <div class="widget-content">
            <table class="table table-bordered" id="myTable" style="">            
               <thead>
                  <tr>
                     <th width="5%">SL</th>                       
                     <th width="35%">Author Name</th>           
                     <th width="35%">Author Description</th>
                     <th width="10%">Status</th>
                     <th width="15%">Action</th>
                  </tr>
               </thead>
               <tbody id="tbody">
                  <?php $i=0; ?>
                  @if(!empty($datas))
                     @foreach($datas as $key=>$value)
                     <tr id="deleteTr">
                        <td>{{++$i}}</td>
                        <td>
                           <span>{{$value->author_name}}</span>
                           <input type="text" name="author_name" id="author_name-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->author_name}}">
                        </td>
                        <td>
                           <span>{{$value->author_description}}</span>
                           <input type="text" name="author_description" id="author_description-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->author_description}}">
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
                                 <a class="btn btn-danger btn-xs delete_author" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i> Delete</a>
                                 @if($value->status==0)
                                 <a class="btn btn-success btn-xs authorActive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Active</a>
                                 @endif
                                 @if($value->status!=0)
                                 <a class="btn btn-danger btn-xs authorInactive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Inactive</a>
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
         var authorId=thisProf.attr('data-id');
         thisProf.hide().next().show().next().show();
         $('#author_name-'+authorId).show().prev().hide();
         $('#author_description-'+authorId).show().prev().hide();

      })
   //=====================Edit Section End====================
   //=====================update section start================
      $('.save-btn').on('click',function(){
         var thisProf=$(this);
         var authorId=thisProf.attr('data-id');
         var author_name=$('#author_name-'+authorId).val();
         var author_description=$('#author_description-'+authorId).val();
         $.ajax({
           type: "GET",
           dataType:'json',
           url:"{{URL::to('authorUpdate')}}/"+authorId,
           data:{author_name:author_name,author_description:author_description},
           beforeSend: function() {
               return "error";
               },
           success: function(data) {
               if(data.status==true){   
                     thisProf.hide().prev().show().next().next().hide();
                     $('#author_name-'+authorId).hide().prev().show().html(author_name);
                     $('#author_description-'+authorId).hide().prev().show().html(author_description);
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
         var authorId=thisProf.attr('data-id');
         thisProf.hide().prev().hide().prev().show();
         $('#author_name-'+authorId).hide().prev().show();
         $('#author_description-'+authorId).hide().prev().show();
      });

   //=====================Reset Section End====================   

   //=====================DELETE Section Start====================   
      $('.delete_author').on('click',function(){
         if(confirm("are u sure?")){
            var thisProf=$(this);
            var authorId=$(this).attr('data-id');
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('deleteauthor')}}/",
        data:{authorId:authorId},
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
               }else{
                  alert("wrong");
               }
            
            },
        error: function(data) {
               $(".printPreviewNone").slideDown(3000,function(){
                    $(this).empty().append("<h4 style='color:white; background-color:red; padding:10px;'>Already Used!!</h4>").slideUp(3000);
                 })
            }
        });
      }
      });

$(".authorActive, .authorInactive").on('click',function(){
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