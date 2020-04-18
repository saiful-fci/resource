    <!-- <style type="text/css">
        .modal-body {
        position: relative;
        padding: 20px;
        /*margin-left: 103px !important;*/
        }
    </style> -->
    <div class="form-group">
        <label for="InputName">Good SubCategory View</label>
        <h4 style="display: none;" id="succesMsg" class="text-danger"></h4>
        <div class="input-group form-control">
            <table class="table table-striped">
                <tr>
                    <td>Sl</td>
                    <td>Category Name</td>
                    <td>Sub Category Name</td>
                    <td>Action</td>
                </tr>
                    <?php $i=0; ?>
                    @if($results)
                        @foreach($results as $value)
                        <tr>
                        <td>{{++$i}}</td>
                        <td>{{$value->category_name}}</td>
                        <td>{{$value->goods_SubCat_name}}</td>
                        <td><a class="btn btn-xs btn-danger del" id="cat-{{$value->id}}">Delete</a></td>
                        </tr>
                        @endforeach
                    @else
                    Data not Found
                    @endif
            </table>
        </div>
    </div>
<script>
    $('.modal-title').html('Sub Category View');
    $('.modal-content').removeClass('modal-big');
    $('.modal-content').addClass('modal-small');
     $('.del').on('click',function(){
        if(confirm('Are You Sure!!')){
          var subCatId=$(this).attr('id').split("-")[1];
        $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('subCategoryDelete')}}/",
            data:{subCatId:subCatId},
            success: function(data) {
                $('#succesMsg').show(0,function(){
                    $(this).text(data.message).hide(3000,function(){
                    $('#modal').hide(2000,function(){
                        location.reload(); 
                    });
                    });
                });                     
            },
            error: function(data) {
                console.log(data);
                $('#succesMsg').show().text(data.message); 
                }
            });
        }
        
    })
</script>
