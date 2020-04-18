{!! Form::open(array('route' => 'saveAddGoodsCategory.post')) !!}
        <div class="form-group">
            <label for="InputName">Good Category Name</label>
            <div class="input-group">
                <input type="text" class="form-control" name="category_name" value="" id="category_name" placeholder="Enter Goods Category Name" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        
        <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
{!! Form::close() !!}
<script>
    $('.modal-title').html('Add Category Name');
    $('.modal-content').removeClass('modal-big');
    $('.modal-content').addClass('modal-small');
</script>

<br>
