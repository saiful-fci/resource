{!! Form::open(array('route' => 'saveAddGoodsSubCategory.post')) !!}
        <div class="form-group">
            <label for="InputName">Goods Sub Category Name</label>
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
            <br/>
            <div class="input-group mainDiv">
                <input type="text" class="form-control" name="subcategory_name[]" id="subcategory_name" placeholder="Enter Goods Sub Category Name" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-plus add-more"></span></span>
            </div>
            <br>
            <!-- <div class="input-group hide">
                <div class="input-group">
                    <br>
                 <input type="text" class="form-control" name="subcategory_name[]" value="" id="subcategory_name" placeholder="Enter Goods Sub Category Name" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-minus"></span></span>
                </div>
            </div> -->
            <div class="input-group dynamic" style="width: 410px;">
            </div>
        </div>
        
        <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
{!! Form::close() !!}
<script>
    $('.modal-title').html('Add Goods Sub Category Name');
    $('.modal-content').removeClass('modal-big');
    $('.modal-content').addClass('modal-small');

     $(document).on('click', '.add-more', function(){
        // var html=$(".hide").html();
        // $('.mainDiv').after(html);
        var content='';
                content+='<div class="input-group">'+
                 '<input type="text" class="form-control" name="subcategory_name[]" value="" id="subcategory_name" placeholder="Enter Goods Sub Category Name" required>'+
                  '<span class="input-group-addon"><span class="glyphicon glyphicon-minus"></span></span>'+
                '</div>'+'<br>'
      $('.dynamic').append(content); 

    });

     $(document).on('click', '.glyphicon-minus', function(){
            $(this).parent().parent().remove();
        });
</script>

<br>
