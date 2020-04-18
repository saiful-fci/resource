{!! Form::open(array('route' => 'savePublisher.post')) !!}
        <div class="form-group">
            <label for="InputName">Publisher Name</label>
            <div class="input-group">
                <input type="text" class="form-control" name="publisher_name" value="" id="publisher_name" placeholder="Enter publisher Name" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Publisher Mobile</label>
            <div class="input-group">
                <input type="text" class="form-control" name="publisher_mobile" value="" id="publisher_mobile" placeholder="Enter publisher Mobile" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Publisher Email</label>
            <div class="input-group">
                <input type="text" class="form-control" name="publisher_email" value="" id="publisher_email" placeholder="Enter publisher Email" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Publisher Address</label>
            <div class="input-group">
                <input type="text" class="form-control" name="publisher_address" value="" id="publisher_address" placeholder="Enter publisher Address" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
{!! Form::close() !!}
<script>
    $('.modal-title').html('Add Publisher');
    $('.modal-content').removeClass('modal-big');
    $('.modal-content').addClass('modal-small');
</script>

<br>
