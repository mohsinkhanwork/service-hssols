@extends('admin.master_layout')
@section('title')
<title> Create Tokens </title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.create_token')}}</h1>
        </div>

        <form action="{{ route('admin.tokens.store') }}" method="POST" enctype="multipart/form-data" id="serviceForm">
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
                                        <label>{{__('admin.token_name')}} <span class="text-danger">*</span></label>
                                        <input id="name" type="text" class="form-control" name="token_name">
                                    </div>
                                    <div class="form-group col-12">
                                        <label> Token rate ({{config('app.currency_code')}}) 
                                          <span class="text-danger">*</span></label>
                                        <input id="conversation_rate" type="number" class="form-control" name="conversion_rate" step="0.01" 
                                        placeholder="Number of tokens per dollar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">{{__('admin.create_token')}}</button>
        </form>
    </section>
</div>
@endsection
