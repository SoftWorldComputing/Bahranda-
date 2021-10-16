@extends('auth.auth_layout')
@section('body')
<div class="row w-100">
  <div class="col-lg-4 mx-auto" id="auth-div">
    <div class="auth-form-dark text-left p-5" >
      <h2>Password Reset</h2>
      <h4 class="font-weight-light">Bahranda Admin</h4>
      @include('flash::message')
      @if($status == "success")
      <form class="pt-5" method="POST" action="{{ route('admin.password.reset.store',['email' => $email]) }}">
        @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Enter new Password</label>
          <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="Enter New Password">
          <i class="mdi mdi-eye"></i>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Confirm New Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation" placeholder="Confirm New Password">
          <i class="mdi mdi-eye"></i>
        </div>
        <div class="mt-5">
          <button type="submit" class="btn btn-block btn-success btn-lg font-weight-medium" >Reset</button>
        </div>
        <div class="mt-3 text-center">
          <a href="{{ route('admin.login') }}" class="auth-link text-white">Login?</a>
        </div>                 
      </form>
      @endif
     
        <div class="mt-3 text-center">
            <a href="{{ route('admin.login') }}" class="auth-link text-white">login</a>
        </div>    
      

 
    </div>
  </div>
</div>
@endsection
