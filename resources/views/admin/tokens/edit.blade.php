@extends('admin.master_layout')
@section('title')
<title>{{ __('admin.edit_token') }}</title>
@endsection
@section('admin-content')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ __('admin.edit_token') }}</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('admin.edit_token') }}</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
          <div class="card">
            <div class="card-header">
              <h4>{{ __('admin.edit_token') }}</h4>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('admin.tokens.update', $token->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="token_name">{{ __('admin.token_name') }}</label>
                  <input id="token_name" type="text" class="form-control @error('token_name') is-invalid @enderror" name="token_name" value="{{ old('token_name', $token->token_name) }}" required autofocus>

                  @error('token_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="conversion_rate"> Token rate ({{config('app.currency_code')}}) <span class="text-danger">*</span></label>
                  <input id="conversion_rate" type="number" placeholder="Number of tokens per dollar" class="form-control @error('conversion_rate') is-invalid @enderror" name="conversion_rate" value="{{ old('conversion_rate', $token->conversion_rate) }}" required>

                  @error('conversion_rate')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="status">{{ __('admin.Status') }}</label>
                  <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                    <option value="1" {{ $token->status == 1 ? 'selected' : '' }}>{{ __('admin.Active') }}</option>
                    <option value="0" {{ $token->status == 0 ? 'selected' : '' }}>{{ __('admin.Inactive') }}</option>
                  </select>

                  @error('status')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group mb-0 text-center">
                  <button type="submit" class="btn btn-primary">
                    {{ __('admin.update_token') }}
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

@endsection
