<?php
namespace App\Classes;

use App\Models\Faq;
use App\Models\PrivacyPolicy;
use App\Models\Review;
use App\Models\TeamMember;
use App\Models\Term;

class SiteMgtClass
{
    public function __construct()
    {
        $this->teamMemberRepo = new TeamMember();
        $this->faqRepo = new Faq();
        $this->reviewRepo = new Review();
        $this->privacyRepo = new PrivacyPolicy();
        $this->termRepo = new Term();
    }

    public function storeMember($data)
    {
       $created =  $this->teamMemberRepo->create($data);
       if($created)
       {
           return ["status" => "success","message" => "Team member created successfully"];
       }
       return ["status" => "error","message" => "Unable to create team member"];
    }

    public function fetchTeamMembers()
    {
        return $this->teamMemberRepo->get();
    }

    public function deleteTeamMember($team_member)
    {
      $delete  = $this->teamMemberRepo->where('id',$team_member)->delete();
      return ["status" => "success","message" => "Team member deleted successfully"];

    }

    public function storeFaq($data)
    {
       $created =  $this->faqRepo->create($data);
       if($created)
       {
           return ["status" => "success","message" => "Faq  created successfully"];
       }
       return ["status" => "error","message" => "Unable to create Faq "];
    }

    public function fetchFaq()
    {
        return $this->faqRepo->orderBy('faq_order','asc')->get();
    }

    public function deleteFaq($faq)
    {
      $delete  = $this->faqRepo->where('id',$faq)->delete();
      return ["status" => "success","message" => "faq  deleted successfully"];

    }

    public function storeReview($data)
    {
       $created =  $this->reviewRepo->create($data);
       if($created)
       {
           return ["status" => "success","message" => "Review created successfully"];
       }
       return ["status" => "error","message" => "Unable to create Review "];
    }

    public function fetchReview()
    {
        return $this->reviewRepo->get();
    }

    public function deleteReview($review)
    {
      $delete  = $this->reviewRepo->where('id',$review)->delete();
      return ["status" => "success","message" => "Review deleted successfully"];

    }
    
    public function storePrivacy($data)
    {
        if(!$this->privacyRepo->first())
        {
            $this->privacyRepo->create($data);
        }else{
           $updated =  $this->privacyRepo->where('id',$this->privacyRepo->first()->id)->update($data);

        }
        return ["status" => "success","message" => "Privacy policy updated successfully"];

        
        return ["status" => "error","message" => "Unable to update privacy policy"];

    }

    public function fetchPrivacy()
    {
        return $this->privacyRepo->first()->privacy_text ?? "No text entered";
    }

    public function storeTerms($data)
    {
        if(!$this->termRepo->first())
        {
            $this->termRepo->create($data);
        }else{
          $this->termRepo->where('id',$this->termRepo->first()->id)->update($data);
       
        }
       
             return ["status" => "success","message" => "Terms and condition updated successfully"];

    }

    public function fetchTerm()
    {
        return $this->termRepo->first()->term_text ?? "No text entered";
    }

    
}