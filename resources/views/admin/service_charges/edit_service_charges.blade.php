@extends('admin.master_layout')
@section('title')
<title> Create Tokens </title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>
                edit Service Charges
            </h1>
        </div>

        <form action="{{ route('admin.update_service_charges', $service_charge->id) }}" method="POST" enctype="multipart/form-data" id="serviceForm">
            @csrf
            @method('PUT')
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
                                        <label> Service Charges <span class="text-danger">*</span></label> % of the service price
                                        <input id="service_charge" type="number" class="form-control" name="service_charge" step="0.01" 
                                        placeholder="Service Charges" value="{{ $service_charge->service_charge }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">
                Update Service Charges
            </button>
        </form>

        
    </section>
</div>
@endsection
