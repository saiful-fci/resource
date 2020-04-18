{!! Form::open(array('route' => 'authorSave')) !!}
        <div class="form-group">
            <label for="InputName">Author Name</label>
            <div class="input-group">
                <input type="text" class="form-control" name="author_name" value="" id="author_name" placeholder="Enter Author Name" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Author Description</label>
            <div class="input-group">
                <textarea class="form-control" rows="5" cols="50" placeholder="Write..." name="author_description" id="author_description"></textarea>
            </div>
        </div>
        <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
{!! Form::close() !!}
<script>
    $('.modal-title').html('Add author');
    $('.modal-content').removeClass('modal-big');
    $('.modal-content').addClass('modal-small');
</script>

<br>
