<?php

namespace App\Http\Controllers\Admin;

use App\Classes\SiteMgtClass;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class SiteMgtController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:admin']);
        $this->siteMgtSettings = new SiteMgtClass;
    }

    public function siteSettings()
    {
        $data = [];
        $data['team_members'] =  $this->siteMgtSettings->fetchTeamMembers();
        $data['faqs'] =  $this->siteMgtSettings->fetchFaq();
        $data['reviews'] =  $this->siteMgtSettings->fetchReview();
        $data['privacy_policy'] =  $this->siteMgtSettings->fetchPrivacy();
        $data['term_text'] =  $this->siteMgtSettings->fetchTerm();
        return view('dashboard.settings.site.settings', $data);
    }
    public function storeTeamMemeber(Request $request)
    {
        $data = $request->only(['member_name', 'member_role', 'details']);
        $data['member_image'] = $request->hasFile('member_image') ? asset('storage/' . $request->file('member_image')->store('images')) : "";
        return  $this->siteMgtSettings->storeMember($data);
    }

    public function deleteTeamMember(Request $request)
    {
        return  $this->siteMgtSettings->deleteTeamMember($request->team_member);
    }

    public function storeFaq(Request $request)
    {
        $data = $request->only(['faq_question', 'faq_answer', 'faq_order']);
        // $data['member_image'] = asset($request->file('member_image')->store('images'));
        return  $this->siteMgtSettings->storeFaq($data);
    }

    public function deleteFaq(Request $request)
    {
        return  $this->siteMgtSettings->deleteFaq($request->faq);
    }

    public function storeReview(Request $request)
    {
        $data = $request->only(['review_text', 'review_user_name']);
        $data['review_user_image'] = asset('storaae/' . $request->file('review_user_image')->store('images'));
        return  $this->siteMgtSettings->storeReview($data);
    }

    public function deleteReview(Request $request)
    {
        return  $this->siteMgtSettings->deleteReview($request->review);
    }

    public function storePrivacy(Request $request)
    {
        $data = $request->only(['privacy_text']);
        return  $this->siteMgtSettings->storePrivacy($data);
    }
    public function storeTerms(Request $request)
    {
        $data = $request->only(['term_text']);
        return  $this->siteMgtSettings->storeTerms($data);
    }
}
