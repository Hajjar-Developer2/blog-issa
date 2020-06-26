<!--AddService  Modal -->
<div id="AddService" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Service Modal</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('SaveService') }}" class="form-horizontal">

            <!-- Service Name Input -->
            <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Service Name" name="ServiceNameI" class="form-control" required></div>
            </div>

            <!-- Service Thumbnail Input -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Service Thumbnail" name="ServiceThumbnailI" class="form-control" required></div>
            </div>

            <!-- Service Price Input -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Service Price" name="ServicePriceI" class="form-control" required></div>
            </div>

            <!-- Service Category Input -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">
                    <select name="ServiceCatI"  class="CategoryInput form-control" required>
                    </select>
                </div>
            </div>

            <!-- Service Descreption Input -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">
                    <textarea name="ServiceDescI" placeholder="Service Descreption" rows="15" class="form-control" required></textarea>
                </div>
            </div>

         {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <input type="submit" value="Save" class="btn btn-primary">
        </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  
    </div>
  </div>
<!-- End AddService Modal -->