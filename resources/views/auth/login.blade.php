@extends('auth.auth_layout')
@section('body')
<div class="row w-100">
  <div class="col-lg-4 mx-auto" id="auth-div">
    <div class="auth-form-dark text-left p-5" >
      <h2>Login</h2>
      <h4 class="font-weight-light">Bahranda Admin</h4>
      @include('flash::message')
    <form class="pt-5" method="POST" action="{{ route('admin.login') }}">
       @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email">
          <i class="mdi mdi-email"></i>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
          <i class="mdi mdi-eye"></i>
        </div>
        <div class="mt-5">
          <button class="btn btn-block btn-success btn-lg font-weight-medium" >Login</button>
        </div>
        <div class="mt-3 text-center">
        <a href="{{ route('admin.login.forget-password') }}" class="auth-link text-white">Forgot password?</a>
        </div>                 
      </form>
    </div>
  </div>
</div>
@endsection
