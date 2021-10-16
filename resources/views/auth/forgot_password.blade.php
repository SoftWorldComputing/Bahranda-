@extends('auth.auth_layout')
@section('body')
<div class="row w-100">
  <div class="col-lg-4 mx-auto" id="auth-div">
    <div class="auth-form-dark text-left p-5" >
      <h2>Password Reset</h2>
      @include('flash::message')
      <h4 class="font-weight-light">Bahranda Admin</h4>
    <form class="pt-5" method="POST" action="{{ route('admin.login.send-password-reset') }}">
      @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Your Email">
          <i class="mdi mdi-email"></i>
        </div>
       
        <div class="mt-5">
          <button type="submit" class="btn btn-block btn-success btn-lg font-weight-medium" >Reset</button>
        </div>
        <div class="mt-3 text-center">
        <a href="{{  route('admin.login')}}" class="auth-link text-white">Login</a>
        </div>      
      </form>
    </div>
  </div>
</div>
@endsection
