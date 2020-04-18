{!! Form::open(array('route' => 'saveGoodsProduct.post')) !!}
        <div class="form-group">
            <label for="InputName">Goods and Accessories Entry Form</label>
            <div class="input-group">
                <select class="form-control" name="goods_cat" id="goods_cat">
                    <option value="" disabled selected>Select One</option>
                    @if(!empty($getGoodsCats))
                        @foreach($getGoodsCats as $getGoodsCat)
                        {
                            <option value="{{$getGoodsCat->id}}">{{$getGoodsCat->category_name}}</option>
                        }
                        @endforeach
                    @endif
                </select>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
            <br>
            <div class="input-group">
                <select class="form-control" name="goodssub_cat" id="goodssub_cat">        
                </select>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
            <!-- <div class="input-group">
                <input type="text" class="form-control" name="quantity" value="" id="quantity" placeholder="Enter Quantity" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div> -->
            <div class="input-group dynamic" style="width: 410px;">
            </div>
        </div>
        
        <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
{!! Form::close() !!}
<script>
    $('.modal-title').html('Add Your Product');
    $('.modal-content').removeClass('modal-big');
    $('.modal-content').addClass('modal-small');

    $('#goods_cat').on('change',function(){
        var goodsCatId=$(this).val();
        var goodsSubCat=$('#goodssub_cat');
        $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('getGoodsSubCat')}}/",
        data:{goodsCatId:goodsCatId},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
            if(data.status==true){
                // console.log(data);
                // return false;
                goodsSubCat.empty();
                goodsSubCat.append('<option value="" selected disabled>Please select</option>');
                $.each(data.data, function(index, value) {
                    goodsSubCat.append('<option value="'+value.id+'" id="subCatID-'+value.id+'">'+value.goods_SubCat_name+'</option>');
                });
            }else{
                
            }
        },
        error: function(data) {
                var data="Sub Category Not Found";
                goodsSubCat.empty();
                goodsSubCat.append('<option value="">'+data+'</option>');
                console.log(data.responseText);
            }
        });
        
    });
    $('#goodssub_cat').on('change',function(){
            var subCatID=$(this).val();
            var goodsCatId=$('#goods_cat').find(":selected").val();
            $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('checkDuplicate')}}/",
            data:{goodsCatId:goodsCatId,subCatID:subCatID},
            beforeSend: function() {
                return "error";
                },
            success: function(data) {

                $('#quantity-'+subCatID).val(data);                 
            },
            error: function(data) {
                    
                }
            });
            
            var subCatName = $('#goodssub_cat').find(":selected").text();
            var subCatVal = $('#goodssub_cat').find(":selected").val();
            var content='';
                content+='<br id="br-'+subCatVal+'">'+'<div class="input-group" id="dynamicDiv-'+subCatVal+'">'+
                '<input type="text" class="form-control" name="quantity['+subCatID+']" id="quantity-'+subCatVal+'" value="1" placeholder="Enter Quantity of '+subCatName+'" required>'+
                // '<input type="hidden" class="form-control" name="quantity[]" id="quantity-'+subCatID+'" required>'+
                '<span class="input-group-addon"><span class="glyphicon glyphicon-minus"></span></span>'
            '</div>'
      $('.dynamic').append(content);
      $(this).find(":selected").hide();
    });
     $(document).on('click', '.glyphicon-minus', function(){
           var quantityId= $(this).parent().prev().attr('id');
           var subCatIdFromRemove=quantityId.split("-")[1];
            $(this).parent().parent().remove();
            $('#subCatID-'+subCatIdFromRemove).show();        
            $('#br-'+subCatIdFromRemove).remove();        
            // $(this).parent().prev().attr('subCatID-'+subCatIdFromRemove).show();
            // var check=$(this).prev().prev().attr("id");
            // alert(check)
        });
</script>

<br>
