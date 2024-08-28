@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Token List')}}</title>
@endsection
@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{__('admin.Token List')}}</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
        <div class="breadcrumb-item">{{__('admin.Token List')}}</div>
      </div>
    </div>

  <div class="section-body">
    @if(!isset($token))
    <a href="{{ route('admin.tokens.create') }}" class="btn btn-primary">{{__('admin.Create Token')}}</a>
    @endif
    <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive table-invoice">
                <table class="table table-striped">
                  <thead>
                      <tr>
                          <th>{{__('admin.SN')}}</th>
                          <th>{{__('admin.token_name')}}</th>
                          <th>Token Conversion Rate ({{config('app.currency_code')}})</th>
                          <th>{{__('admin.Status')}}</th>
                          <th>Created at</th>
                          <th>{{__('admin.Action')}}</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if(isset($token))
                          <tr>
                              <td>{{ $token->id }}</td>
                              <td>{{ html_decode($token->token_name) }}</td>
                              <td>1 {{ config('app.currency_code') }} = {{ $token->conversion_rate }} Tokens</td>
                              <td>
                                  @if($token->status == 1)
                                  <a href="javascript:;" onclick="manageTokenStatus({{ $token->id }})">
                                      <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.Inactive')}}" data-onstyle="success" data-offstyle="danger">
                                  </a>
                                  @else
                                  <a href="javascript:;" onclick="manageTokenStatus({{ $token->id }})">
                                      <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.Inactive')}}" data-onstyle="success" data-offstyle="danger">
                                  </a>
                                  @endif
                              </td>
                              <td>{{ $token->created_at }}</td>
                              <td>
                                  <a href="{{ route('admin.tokens.edit',$token->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                  <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $token->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                              </td>
                          </tr>
                      @endif
                  </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
  </div>
  
  @if(!isset($service_charge))
  <a href="{{ route('admin.tokens.create_service_charges') }}" class="btn btn-primary">
      Add Service Charges
  </a>
  @else 
    <a href="{{ route('admin.edit_service_charges',$service_charge->id) }}" class="btn btn-primary">
        Edit Service Charges
    </a>
    @endif
  <div class="row mt-4">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive table-invoice">
            <table class="table table-striped">
              <thead>
                  <tr>
                      <th>{{__('admin.SN')}}</th>
                      <th> Service Charges (%)</th>
                      <th> Created at</th>
                  </tr>
              </thead>
              <tbody>
                  @if(isset($service_charge))
                      <tr>
                          <td>{{ $service_charge->id }}</td>
                          <td> {{ $service_charge->service_charge }} %</td>
                          <td>{{ $service_charge->created_at }}</td>
                      </tr>
                  @endif
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
</div>
  </div>


  </section>
</div>


<div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                  <div class="modal-body">
                      {{__('admin.You can not delete this seller. Because there are one or more products and shop account has been created in this seller.')}}
                  </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/token-delete/") }}'+"/"+id)
    }
    function manageTokenStatus(id){
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/token-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){


            }
        })
    }
</script>
@endsection