<div class="modal fade" id="rproduct{!!$rproduct->id!!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Modify Product</h4>
                                          </div>
                                          {!!Form::model($rproduct,['route'=>['product.edit.recurring', $rproduct->id],'class'=>'form-horizontal','role'=>'form'])!!}
                                          {!!Form::hidden('id', $rproduct->id)!!}
                                          <div class="modal-body">
                                                <fieldset>
                                                  <div class="form-group {!!Form::error($errors, 'name')!!}">
                                                      <label for="inputEmail" class="col-lg-3 control-label">Name</label>
                                                      <div class="col-lg-8  ">
                                                        {!!Form::text('name',NULL,['class'=>'form-control disabled','placeholder'=>'product name','disabled'=>''])!!}
                                                          {!!$errors->first('name',"<span class='help-block'>:message</span>")!!}
                                                      </div>
                                                  </div>
                                                    <div class="form-group {!!Form::error($errors, 'price')!!}">
                                                      <label for="inputEmail" class="col-lg-3 control-label">Product Price</label>
                                                      <div class="col-lg-8">
                                                        {!!Form::text('price', NULL, ['class'=>'form-control','placeholder'=>"product price"])!!}
                                                        {!!$errors->first('price',"<span class='help-block'>:message</span>")!!}
                                                      </div>
                                                  </div>
                                                    @if( $rproduct->taxable)
                                                  <div class="form-group  {!!Form::error($errors, 'taxable')!!}">
                                                      <label for="tax_rate" class="col-lg-3 control-label">Tax Percent</label>
                                                      <div class="col-lg-8">
                                                        {!!Form::text('tax_rate', NULL, ['class'=>'form-control','placeholder'=>"tax percentage"])!!}
                                                        {!!$errors->first('tax_rate',"<span class='help-block'>:message</span>")!!}
                                                      </div>
                                                  </div>
                                                  @endif
                                                    <div class="form-group  {!!Form::error($errors, 'taxable')!!}">
                                                      <label for="expiry" class="col-lg-3 control-label">Expires On</label>
                                                      <div class="col-lg-8">
                                                        {!!Form::text('expiry', NULL, ['class'=>'form-control','placeholder'=>"product expiration date",'id'=>'expiry'])!!}
                                                        {!!$errors->first('expiry',"<span class='help-block'>:message</span>")!!}
                                                      </div>
                                                  </div>
                                                </fieldset>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                          </div>
                                          {!!Form::close()!!}
                                        </div>
                                      </div>
                                    </div>