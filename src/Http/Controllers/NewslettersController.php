<?php

namespace Mixdinternet\Newsletters\Http\Controllers;

use Mixdinternet\Newsletters\Newsletter;
use Illuminate\Http\Request;
use Caffeinated\Flash\Facades\Flash;
use Mixdinternet\Newsletters\Services\NewslettersServices;
use Mixdinternet\Newsletters\Http\Requests\NewslettersRequest;
use App\Http\Controllers\Controller;
use Carbon;
use Auth;

class NewslettersController extends Controller
{
    protected $newslettersServices;

    public function __construct()
    {
        $this->newslettersServices = new NewslettersServices();
    }

    public function store(NewslettersRequest $request){
        $data = [
            'email' => $request->email
        ];
        if (config('mnewsletters.fields.name') !== false) {
            $data = [
                'name' => $request->name
            ];
        }
        $newsletter = $this->newslettersServices->createNewsletter($data);

        if($newsletter) {
            Flash::success('Dados enviados com sucesso.');
        }else{
            Flash::error('Falha no cadastro do email.');
        }

        return redirect()->back();
    }

}