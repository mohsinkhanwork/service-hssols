
@extends('admin.master_layout')
@section('title')
<title>{{__('admin.User Detail')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.User Detail')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.User Detail')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.customer-list') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.User List')}}</a>
            <div class="col-md-6">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>{{__('admin.Image')}}</td>
                                <td>
                                    @if ($customer->image)
                                    <img src="{{ asset($customer->image) }}" class="rounded-circle" alt="" width="80px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Name')}}</td>
                                <td>{{ html_decode($customer->name) }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Email')}}</td>
                                <td>{{ html_decode($customer->email) }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Phone')}}</td>
                                <td>{{ html_decode($customer->phone) }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Address')}}</td>
                                <td>{{ html_decode($customer->address) }}</td>
                            </tr>

                            <tr>
                                <td>{{__('admin.Status')}}</td>
                                <td>
                                    @if($customer->status == 1)
                                        <a href="javascript:;" onclick="manageCustomerStatus({{ $customer->id }})">
                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                        </a>
                                        @else
                                        <a href="javascript:;" onclick="manageCustomerStatus({{ $customer->id }})">
                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
          <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>{{ __('Token Balance') }}</h4>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-success">
                        <i class="fas fa-coins"></i> {{ $TotaltokenPurchase }} Tokens
                    </h2>
                    <p class="text-muted">{{ __('Total tokens earned or purchased') }}</p>
    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Tokens') }}</th>
                                <th>{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokenOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->tokens }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                    {{--  <a href="{{ route('admin.token-orders', $customer->id) }}" class="btn btn-info">
                        {{ __('View All Token Orders') }}
                    </a>  --}}
                </div>
            </div>
        </div>
        </section>
      </div>

<script>
    function manageCustomerStatus(id){
        var isDemo = "{{ env('APP_MODE') }}"
        if(isDemo == 'DEMO'){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/customer-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){


            }
        })
    }
</script>
@endsection
