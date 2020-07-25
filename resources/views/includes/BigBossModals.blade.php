<!--AddCategory  Modal -->
<div id="AddCategory" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('lang.AddCategoryModalTitle') }}</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('SaveCategory') }}" class="form-horizontal">

            <!-- Category Name Input -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-1"><input type="text" placeholder="Category Name" name="CategoryNameI" class="form-control"></div>
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
<!-- End AddCategory Modal -->


<!--DelCategory  Modal -->
<div id="DelCategory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('lang.DeleteCategoryModalTitle') }}</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('DelCategory') }}" class="form-horizontal">

          <!-- BigBoss Pass Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="BigBoss Password" name="BigBossPassI" class="form-control" required></div>
          </div>
          <input type="hidden" name="CatId" required>
       {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <input type="submit" value="Delete Category" class="btn btn-danger">
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End DelCategory Modal -->




<!--UpdateCategory  Modal -->
<div id="UpdateCategory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('lang.UpdateCategoryModaltitle') }}</h4>
      </div>
      <div class="modal-body">

        <div class="sk-chase UpdateCategorySpinner">
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
        </div>

        <form method="post" action="{{ route('UpdateCategory') }}" class="form-horizontal UpdateCategoryForm">

          <!-- Category Name Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Category Name" name="CategoryNameUpdateI" class="form-control"></div>
          </div>
          <input type="hidden" name="UpdateCatId">
       {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <input type="submit" value="Update" class="btn btn-success">
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End UpdateCategory Modal -->


<!--AddProvider  Modal -->
<div id="AddProvider" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('lang.AddProviderModalTitle') }}</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('SaveProvider') }}" class="form-horizontal">

            <!-- Provider Name Input -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-1"><input type="text" placeholder="Provider Name" name="ProviderNameI" class="form-control"></div>
            </div>

            <!-- Provider Username Input -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-1"><input type="text" placeholder="Provider UserName" name="ProviderUserNameI" class="form-control"></div>
            </div>

            <!-- Provider Password Input -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-1"><input type="text" placeholder="Provider Password" name="ProviderPasswordI" class="form-control"></div>
            </div>

            <!-- Provider Icon Source Input -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-1"><input type="text" placeholder="Provider Icon Source" name="ProviderIconSrcI" class="form-control"></div>
            </div>

            <!-- Provider Descreption Input -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-1"><textarea name="ProviderDescI" class='form-control' cols="30" rows="10" placeholder="Provider Descreption"></textarea></div>
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
<!-- End AddProvider Modal -->


<!--UpdateProvider Modal -->
<div id="UpdateProvider" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('lang.UpdateProviderModalTitle') }}</h4>
      </div>
      <div class="modal-body">
        <div class="sk-chase UpdateProviderSpinner">
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
        </div>



        <form method="post" action="{{ route('UpdateProvider') }}" class="form-horizontal UpdateProviderForm">

          <!-- Provider Name Update Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Provider Name" name="ProviderNameUI" class="form-control"></div>
          </div>

          <!-- Provider Username Update Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Provider UserName" name="ProviderUserNameUI" class="form-control"></div>
          </div

          <!-- Provider Icon Source Update Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Provider Icon Source" name="ProviderIconSrcUI" class="form-control"></div>
          </div>

          <!-- Provider Descreption Update Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><textarea name="ProviderDescUI" class='form-control' cols="30" rows="10" placeholder="Provider Descreption"></textarea></div>
          </div>
          <input type="hidden" name="UpdateProviderId">
       {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <input type="submit" value="Update" class="btn btn-success">
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End UpdateProvider Modal -->


<!--DelProvider  Modal -->
<div id="DelProvider" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('lang.DeleteProviderModalTitle') }}</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('DelProvider') }}" class="form-horizontal">

          <!-- BigBoss Pass Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="BigBoss Password" name="BigBossPassI" class="form-control" required></div>
          </div>
          <input type="hidden" name="ProviderId" required>
       {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <input type="submit" value="Delete Category" class="btn btn-danger">
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End DelProvider Modal -->
  