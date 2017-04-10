<?php

namespace Mixdinternet\Newsletters\Services;

use App\Exceptions\AdmixException;
use Mixdinternet\Newsletters\Newsletter;
use Auth;
use Carbon;

class NewslettersServices
{
    public function __construct()
    {

    }

    public function createNewsletter($data)
    {
        $newsletter = new Newsletter();
        if (config('mnewsletters.fields.name') !== false) {
            $newsletter->name = $data['name'];
        }
        $newsletter->email = $data['email'];
        return $newsletter->save();
    }

    public function listNewsletter($data)
    {
        $newsletter = Newsletter::where('email', $data['email']);
        if (config('mnewsletters.fields.name') !== false) {
            $newsletter->where('name',$data['name']);
        }
        $result = $newsletter->first();
        return $result;
    }

    public function listNewsletterId($data)
    {
        $newsletter = Newsletter::where('email',$data['email']);
        if (config('mnewsletters.fields.name') !== false) {
            $newsletter->where('name',$data['name']);
        }
        $result = $newsletter->whereNull('deleted_at')->get();
        return $result;
    }

}