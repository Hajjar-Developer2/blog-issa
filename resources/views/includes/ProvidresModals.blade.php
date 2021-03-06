<!--AddService  Modal -->
<div id="AddService" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('lang.AddServiceModalTitle') }}</h4>
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


<!--Update Service  Modal -->
<div id="UpdateService" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Provider Modal</h4>
      </div>
      <div class="modal-body">
        <div class="sk-chase UpdateServiceSpinner">
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
        </div>
        <form method="post" action="{{ route('UpdateService') }}" class="form-horizontal UpdateServiceForm">

          <!-- Service Name Input -->
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Service Name" name="ServiceNameUI" class="form-control" required></div>
          </div>

          <!-- Service Thumbnail Input -->
          <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Service Thumbnail" name="ServiceThumbnailUI" class="form-control" required></div>
          </div>

          <!-- Service Price Input -->
          <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1"><input type="text" placeholder="Service Price" name="ServicePriceUI" class="form-control" required></div>
          </div>

          <!-- Service Category Input -->
          <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1">
                  <select name="ServiceCatUI"  class="CategoryInputSerUp form-control" required>
                  </select>
              </div>
          </div>

          <!-- Service Descreption Input -->
          <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1">
                  <textarea name="ServiceDescUI" placeholder="Service Descreption" rows="15" class="form-control" required></textarea>
              </div>
          </div>

          <!--- Service Upgrades List -->
          <div class=' UpdatesList'>
              <div class='UpdateSerAddBtn UpdateOne'>
               <span class='glyphicon glyphicon-plus' ></span>
               <p> Create New Update </p>
              </div>
                <div class="UpgradeFormCollapse collapse">
                  <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                      <input class='form-control' type='text' placeholder="Service Upgrade Title" name='ServiceUpTitleI' />
                    </div>
                    
                  </div>

                  <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                     <input class='form-control' type='text' placeholder="Service Upgrade Price" name='ServiceUpPriceI' />
                    </div>
                  </div>
                 
                 <div class="form-group">
                  <div class="col-sm-10 col-sm-offset-1">
                   <textarea class='form-control'  placeholder='Service Upgrade Descreption' name='ServiceUpDescI' rows='20'></textarea>
                  </div>
                 </div>

                 <div class="form-group">
                  <div class="col-sm-10 col-sm-offset-1">
                   <input type="button" value="Save" class='btn btn-success btn-block SaveUpgradeBtn' >
                  </div>
                 </div>
                </div>

                <div class="UpgradesListAj"></div>
          </div>

          <br>

       {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <input type="hidden" name="ServiceIdUI" >
        <input type="submit" value="Update" class="btn btn-primary">
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Update Service Modal -->





<!-- Start Delete Service Modal -->

<div id="DelService" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Service Modal</h4>
      </div>
      <div class="modal-body">
        
        
       <form action="{{ route('DeleteService') }}" method="post" class="form-horizontal" >
       
        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-1">
            <input type="text" name="ProviderPassI" class="form-control" placeholder="Provider Password">
          </div>
        </div>

        <input type="hidden" name="DelSerIdI">
        {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <input type="submit" value="Delete" class="btn btn-danger">
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<!-- End Delete Service Modal -->


<!-- File Upload Modal -->

<!-- Modal -->
<div id="FileUplaodModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <main>
          <section>
              <div id="dropzone dropzoneOrderUp">
                  <form  class="dropzone dz-clickable" id="dropzoneOrderUp" enctype="multipart/form-data" style="border: 2px #004fff dashed;background: gainsboro;">
                      {{-- <span class='center-block	glyphicon glyphicon-download-alt'></span> --}}
                      <div class="dz-message">Drop files here or click to upload.
                      </div>
                      <input type="hidden" name="OrderIdUplI" >
                  </form>
              </div>
          </section>
      </main>
        {{-- <form action="{{route('OrderUploadFile')}}" class="dropzone"id="my-awesome-dropzone">

          <input type="file" name="file" />

        </form> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- End File Upload Modal -->



<!-- Start Send Message Modal -->

<div id="SendMessage" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Message Modal</h4>
      </div>
      <div class="modal-body">
        <form action="{{route('OrderSendMessage')}}" method="post" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1">
              <input type="text" name="MessageTitleI" class="form-control" placeholder="Message Title Input" >
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1">
              <select name="MessageTargetI" class='form-control' >
                <option value="Customer">Customer :</option>
                <option value="Admins">Administrators</option>
              </select>
            </div>
          </div>

          <div class="form-group"> 
           <div class="col-sm-10 col-sm-offset-1">
            <select name="MessageSubjectI" class="form-control" >
              <option value="Customer Order">Customer Order</option>
              <option value="Technical problem">Technical problem</option>
              <option value="Additional information to order">Additional information to order</option>
            </select>
           </div>
          </div>

          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1">
              <textarea name="MessageBodyI" placeholder="Message Body Input" rows="10" class="form-control"></textarea>
              <input type="hidden" name="MessageCustomerIdI">
              <input type="hidden" name="MessageOrderIdI">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        {{ csrf_field() }}
        <input type="submit" value="Send" class="btn btn-success"> 
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- End Send Message Modal -->