@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Create Service')}}</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>{{__('admin.Create Service')}}</h1>

      </div>

      <div class="section-body">
        <div class="row mt-sm-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> Today Conversion Rate </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12">
                            @if($conversion_rate == null)
                                <div class="alert alert-danger">
                                    <strong>Warning!</strong> Conversion rate is not set yet. Please set the conversion rate.
                                </div>
                            @else
                                <label>Token Conversion Rate ({{ config('app.currency_code') }}) <span class="text-danger">*</span></label>
                                <input id="conversation_rate" type="text" class="form-control" 
                                       value="1 {{ config('app.currency_code') }} = {{ $conversion_rate }} Tokens" readonly>
                                <small class="form-text text-muted">
                                    This means for every 1 {{ config('app.currency_code') }}, you will receive {{ $conversion_rate }} tokens.
                                </small>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

      <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data" id="serviceForm">
        @csrf
      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('admin.Basic Information')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>{{__('admin.Image')}} <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" name="image">
                        </div>

                        <div class="form-group col-12">
                            <label>{{__('admin.Provider')}} <span class="text-danger">*</span></label>
                            <select name="provider_id" id="" class="form-control select2">
                                <option value="">{{__('admin.Select Provider')}}</option>
                                @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}" 
                                    {{ $email == $provider->email ? 'selected' : '' }}>
                                    {{ $provider->email }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label>{{__('admin.Service Name')}} <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group col-12">
                            <label>{{__('admin.Slug')}} <span class="text-danger">*</span></label>
                            <input id="slug" type="text" class="form-control" name="slug">
                        </div>

                        <div class="form-group col-12">
                            <label>{{__('admin.Price')}} {{ $currency_icon->icon }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="price">
                        </div>

                        <div class="form-group col-12">
                            <label>{{__('admin.Category')}} <span class="text-danger">*</span></label>
                            <select name="category_id" id="" class="form-control select2">
                                <option value="">{{__('admin.Select')}}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label>{{__('admin.Details')}} <span class="text-danger">*</span></label>
                            <textarea name="details" id="" class="summernote" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('admin.Package Features')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="package_feature_box">
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>{{__('admin.Service')}}</label>
                                    <input type="text" class="form-control" name="package_features[]" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" type="button" id="addNewPackageFeature" class="btn btn-success btn_mt_33"><i class="fa fa-plus" aria-hidden="true"></i> {{__('admin.Add New')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('admin.What you will provide ?')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="provide_item_box">
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>{{__('admin.Title')}}</label>
                                    <input type="text" class="form-control" name="what_you_will_provides[]" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" type="button" id="addNewProvideItem" class="btn btn-success btn_mt_33"><i class="fa fa-plus" aria-hidden="true"></i> {{__('admin.Add New')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('admin.Benifits of the Package')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="benifit_box">
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>{{__('admin.Title')}}</label>
                                    <input type="text" class="form-control" name="benifits[]" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="addNewBenifitItem" class="btn btn-success btn_mt_33"><i class="fa fa-plus" aria-hidden="true"></i> {{__('admin.Add New')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('admin.Additional service')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="additional_box">
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Image')}}</label>
                                    <input type="file" class="form-control" name="additional_feature_images[]">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Service')}}</label>
                                    <input type="text" class="form-control" name="additional_services[]" autocomplete="off">
                                </div>

                                <div class="form-group col-md-2">
                                    <label>{{__('admin.Quantity')}}</label>
                                    <input type="text" class="form-control" name="additional_quantities[]" autocomplete="off">
                                </div>

                                <div class="form-group col-md-2">
                                    <label>{{__('admin.Price')}}</label>
                                    <input type="text" class="form-control" name="additional_prices[]" autocomplete="off">
                                </div>

                                <div class="col-md-2">
                                    <button type="button" id="addNewAdditionalService" class="btn btn-success btn_mt_33"><i class="fa fa-plus" aria-hidden="true"></i> {{__('admin.Add New')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('admin.Seo Information')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>{{__('admin.Seo Title')}}</label>
                            <input type="text" class="form-control" name="seo_title" autocomplete="off">
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('admin.Seo Description')}}</label>
                            <textarea name="seo_description" class="form-control text-area-5" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('admin.Status')}}</label>
                            <select name="status" id="" class="form-control">
                                <option value="0">{{__('admin.Active')}}</option>
                                <option value="1">{{__('admin.Inactive')}}</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">{{__('admin.Save New Service')}}</button>
                </div>


            </div>
          </div>
        </div>
      </div>

    </form>

    </section>
  </div>

 <script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#name").on("focusout",function(e){
                $("#slug").val(convertToSlug($(this).val()));
            })
            // start package feature section
            $("#addNewPackageFeature").on("click", function(){
                let package_feature = `
                    <div class="col-12 pacakge_feature_row">
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label>{{__('admin.Service')}}</label>
                                <input type="text" class="form-control" name="package_features[]" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn_mt_33 delete_package_feature"><i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
                            </div>
                        </div>
                    </div>`;
                $("#package_feature_box").append(package_feature)
            });

            $(document).on('click', '.delete_package_feature', function () {
                $(this).closest('.pacakge_feature_row').remove();
            });

            // end package feature

            // start provide item
            $("#addNewProvideItem").on("click", function(){
                let provide_item = `
                    <div class="col-12 provide_item_row">
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label>{{__('admin.Title')}}</label>
                                <input type="text" class="form-control" name="what_you_will_provides[]" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn_mt_33 delete_provide_item"><i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
                            </div>
                        </div>
                    </div>`;
                    $("#provide_item_box").append(provide_item)
            })

            $(document).on('click', '.delete_provide_item', function () {
                $(this).closest('.provide_item_row').remove();
            });
            // end provide item

            // start benifit item
            $("#addNewBenifitItem").on("click", function(){
                let provide_item = `
                    <div class="col-12 benitfit_item_row">
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>{{__('admin.Title')}}</label>
                                    <input type="text" class="form-control" name="benifits[]" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" type="button" class="btn btn-danger btn_mt_33 delete_benifit_item"><i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
                                </div>
                            </div>
                    </div>`;
                $("#benifit_box").append(provide_item)
            })

            $(document).on('click', '.delete_benifit_item', function () {
                $(this).closest('.benitfit_item_row').remove();
            });
            // end benifit

            $("#addNewAdditionalService").on("click", function(){
                let additional_service = `
                    <div class="col-12 additional_item_box">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>{{__('admin.Image')}}</label>
                                <input type="file" class="form-control" name="additional_feature_images[]">
                            </div>

                            <div class="form-group col-md-3">
                                <label>{{__('admin.Service')}}</label>
                                <input type="text" class="form-control" name="additional_services[]" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <label>{{__('admin.Quantity')}}</label>
                                <input type="text" class="form-control" name="additional_quantities[]" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <label>{{__('admin.Price')}}</label>
                                <input type="text" class="form-control" name="additional_prices[]" autocomplete="off">
                            </div>

                            <div class="col-md-2">
                                <button type="button" type="button" class="btn btn-danger btn_mt_33 delete_additional_service"><i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
                            </div>
                        </div>
                    </div>
                `;
                $("#additional_box").append(additional_service)
            })

            $(document).on('click', '.delete_additional_service', function () {
                $(this).closest('.additional_item_box').remove();
            });

        })
    })(jQuery);

    function convertToSlug(Text)
    {
        return Text
                .toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-');
    }
</script>

@endsection
