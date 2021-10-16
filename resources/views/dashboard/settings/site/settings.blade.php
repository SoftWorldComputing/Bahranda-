@extends('dashboard.layout')
@push('app_css')
<link rel="stylesheet" href="/vendors/quill/quill.snow.css">

@endpush
                          @section('content')
                          <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                
                              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.adminmgt.list') }}">Site Management</a></li>
                            </ol>
                           </nav>
                           <h4>Team Members Management</h4>

                          <div class="row">
                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Create new team member</h5>
                                    <form id="team_member" enctype="multipart/form-data" action="{{ route('admin.settings.site.team.store') }}">
                                            <div class="form-group">
                                                <label for="">Enter team member name</label>
                                                <input required type="text" name="member_name" class="form-control"  id="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Upload team member image</label>
                                                <input  type="file" name="member_image" class="form-control"  id="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Enter team member role</label>
                                                <input  required type="text" name="member_role" class="form-control"  id="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Enter team member details</label>
                                                <textarea class="form-control" name="details" id="" cols="30" rows="10">

                                                </textarea>
                                                </div>

                                            <div class="form-group">
                                                <button class="btn btn-success" id="team-member-button" type="submit">Create team member</button>
                                            </div>
                                          
                                        </form>

                                    </div>
                                  </div>
                            </div>
                              
                              <div class="col-md-7">
                                 <div class="card">
                                    <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>#</td>
                                                        <td>Name</td>
                                                        <td>Image</td>
                                                        <td>Role</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @forelse ($team_members as $team_member)
                                                    <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $team_member->member_name}}
                                                        </td>
                                                    <td>  @if(!empty($team_member->member_image)) <img src="{{ $team_member->member_image }}" width="150px" height="100px" alt=""> @else {{$team_member->details }}  @endif</td>
                                                    <td>{{ $team_member->member_role }}</td>
                                                    <td> <a  href="{{ route('admin.settings.site.team.delete',['team_member' => $team_member->id]) }}" class="btn btn-danger delete_team_member">delete</a></td>
                                                    </tr>  
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">No team member created</td>
                                                        </tr>
                                                    @endforelse
                                                 
                                                </tbody>
                                            </table>

                                    </div>
                                  </div>
                             </div>
                          </div>
                          <br>
                          <h4>Frequently asked question management</h4>
                          <div class="row">
                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Create new faq </h5>
                                    <form action="{{ route('admin.settings.site.faq.store') }}" id="faq">
                                            <div class="form-group">
                                                <label for="">Enter faq question</label>
                                                <input required type="text" name="faq_question" class="form-control"  id="">
                                            </div>
                                           

                                            <div class="form-group">
                                                <label for="">Enter faq answer</label>
                                                <textarea required type="text" name="faq_answer" class="form-control"  id="">
                                                </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Enter faq order</label>
                                                <input  required type="number" name="faq_order" class="form-control"  id="">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success" id="faq-button" type="submit">Create new faq</button>
                                            </div>
                                          
                                        </form>

                                    </div>
                                  </div>
                            </div>
                              
                              <div class="col-md-7">
                                 <div class="card">
                                    <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>#</td>
                                                        <td>Question</td>
                                                        <td>Answer</td>
                                                        <td>Order</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @forelse ($faqs as $faq)
                                                    <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $faq->faq_question}}
                                                        </td>
                                                    <td> {{ $faq->faq_answer }}</td>
                                                    <td>{{ $faq->faq_order  }}</td>
                                                    <td> <a  href="{{ route('admin.settings.site.faq.delete',['faq' => $faq->id]) }}" class="btn btn-danger delete_faq">delete</a></td>
                                                    </tr>  
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">No faq created</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                    </div>
                                  </div>
                             </div>
                          </div>
                          <br>
                           <h4> Review management</h4>
                          <div class="row">
                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Create new review </h5>
                                    <form  id="review" enctype="multipart/form-data" action="{{ route('admin.settings.site.review.store') }}">
                                            <div class="form-group">
                                                <label for="">Enter new review</label>
                                                <textarea  name="review_text" class="form-control"  id=""></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">User name</label>
                                                <input type="text" name="review_user_name" class="form-control"  id="">
                                            </div>


                                            <div class="form-group">
                                                <label for="">User image</label>
                                                <input type="file" type="image" name="review_user_image" class="form-control"  id="">
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-success" id="review-button" type="submit">Create new review</button>
                                            </div>
                                          
                                        </form>

                                    </div>
                                  </div>
                            </div>
                              
                              <div class="col-md-7">
                                 <div class="card">
                                    <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>#</td>
                                                        <td>Review</td>
                                                        <td>User image</td>
                                                        <td>User</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @forelse ($reviews as $review)
                                                    <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $review->review_text}}
                                                        </td>
                                                    <td> <img src="{{ $review->review_user_image }}" width="150px" height="100px" alt=""> </td>
                                                    <td>{{ $review->review_user_name }}</td>
                                                    <td> <a  href="{{ route('admin.settings.site.review.delete',['review' => $review->id]) }}" class="btn btn-danger delete_review">delete</a></td>
                                                    </tr>  
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">No review created</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                    </div>
                                  </div>
                             </div>
                          </div>
                          <br>

                          <h4>Privacy Policy</h4>
                          <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                  <div class="card-body">
                                    <h4 class="card-title">Update Privacy policy</h4>
                                    <form id="privacy_and_policy" action="{{ route('admin.settings.site.privacy.store') }}">
                                    <div id="quillExample1" class="quill-container">
                                        {!! htmlspecialchars_decode($privacy_policy,ENT_NOQUOTES)  !!}
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success" id="privacy_and_policy-button">Update policy</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                       
                        <br>
                        <h4>Terms and Conditions</h4>
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="card">
                                <div class="card-body">
                                  <h4 class="card-title">Terms and condition</h4>
                                <form id="term_and_condition" action="{{ route('admin.settings.site.terms.store') }}">
                                  <div id="quillExample2" class="quill-container">
                                    {!! htmlspecialchars_decode($term_text,ENT_NOQUOTES)  !!}
                                  </div>
                                  <br>
                                  <button type="submit" class="btn btn-success" id="term_and_condition-button">Update terms</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                      
                    
                          @endsection
                          @push('app_js')
                        
                          <script src="/vendors/quill/quill.min.js"></script>
                          <script src="/js/editorDemo.js"></script>
                          <script src="/js/bahranda.js"></script>
                          <script src="/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
                          @endpush
                          @push('app_css')
                          <link rel="stylesheet" href="/vendors/jquery-toast-plugin/jquery.toast.min.css">
                          @endpush

                        