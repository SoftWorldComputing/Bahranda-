<?php

namespace App\Classes;

use App\Http\Resources\CommoditiesResource;
use App\Mail\ContactUsMail;
use App\Models\Commodity;
use App\Models\Faq;
use App\Models\PrivacyPolicy;
use App\Models\Review;
use App\Models\TeamMember;
use App\Models\Term;
use App\Response\BahrandaResponse;
use Exception;
use Illuminate\Support\Facades\Mail;
use Spatie\Newsletter\Newsletter;
use Spatie\Newsletter\NewsletterFacade;

class FrontEndClass
{
    use BahrandaResponse;
    public function __construct()
    {
        $this->teamMemberRepo = new TeamMember();
        $this->faqsRepo = new Faq();
        $this->reviewRepo = new Review();
        $this->privacyRepo = new PrivacyPolicy();
        $this->termRepo = new Term();
        $this->commoditiesRepo = new Commodity();
    }

    public function getAllTeamMembers()
    {

        return $this->fetch("Team memeber fetcehd succesfully",    $this->teamMemberRepo->get(), "team_members");
    }

    public function getAllFaqs()
    {
        return $this->fetch("Faqs fetched succesfully",    $this->faqsRepo->orderBy('faq_order', 'asc')->get(), "faqs");
    }


    public function getReviews()
    {
        return $this->fetch("Review fetched succesfully",    $this->reviewRepo->get(), "reviews");
    }

    public function getPrivacy()
    {
        return $this->fetch("Privacy fetched succesfully",    $this->privacyRepo->first(), "privacy");
    }

    public function getTerms()
    {
        return $this->fetch("Term fetched succesfully",    $this->termRepo->first(), "terms");
    }

    public function contactUs($data)
    {
        //send message
        try {

            Mail::to($data['email'])->send(new ContactUsMail($data['name'], $data['phone'], $data['email'], $data['message']));
        } catch (\Exception $e) {
        }
        return $this->created("Your message has been sent successfully to bahranda support team",    "true", "updated");
    }

    public function subscribeUser($data)
    {

        $name  = explode(" ", $data['name']);
        $first_name = $name[0];
        if (isset($name[1])) {
            $last_name = $name[1];
        } else {
            $last_name = " ";
        }

        try {

            NewsletterFacade::subscribe($data['email'], ['FNAME' => $first_name, 'LNAME' => $last_name]);
        } catch (Exception $e) {
        }


        return $this->created("You have successfully subscribe to our newsletter", "true", "subscribed");
    }

    public function getCommodities()
    {

        return $this->fetch("Commodities fetched succesfully", CommoditiesResource::collection($this->commoditiesRepo->inRandomOrder()->get()->take(10)), "commodities");
    }

    //


}
