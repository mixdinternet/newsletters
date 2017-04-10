<?php

namespace Mixdinternet\Newsletters\Http\Controllers;

use Mixdinternet\Newsletters\Newsletter;
use Illuminate\Http\Request;
use Caffeinated\Flash\Facades\Flash;
use Mixdinternet\Newsletters\Http\Requests\CreateEditNewslettersRequest;
use Mixdinternet\Admix\Http\Controllers\AdmixController;
use Carbon;
use Auth;

class NewslettersAdminController extends AdmixController
{
    public function index(Request $request)
    {
        session()->flash('backUrl', request()->fullUrl());

        $trash = ($request->segment(3) == 'trash') ? true : false;

        $query = Newsletter::sort();
        ($trash) ? $query->onlyTrashed() : '';

        $search = [];
        if(config('mnewsletters.fields.name') !== false) {
            $search['name'] = $request->input('name', '');
        }
        $search['email'] = $request->input('email', '');

        if(config('mnewsletters.fields.name') !== false) {
            ($search['name']) ? $query->where('name', 'LIKE', '%' . $search['name'] . '%') : '';
        }
        ($search['email']) ? $query->where('email', 'LIKE', '%' . $search['email'] . '%') : '';

        $newsletters = $query->paginate(50);

        $view['search'] = $search;
        $view['newsletters'] = $newsletters;
        $view['trash'] = $trash;

        return view('mixdinternet/newsletters::admin.index', $view);
    }

    public function destroy(Request $request)
    {
        if (Newsletter::destroy($request->input('id'))) {
            Flash::success('Item removido com sucesso.');
        } else {
            Flash::error('Falha na remoção.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.newsletters.index');
    }

    public function restore($id)
    {
        $newsletter = Newsletter::onlyTrashed()->find($id);

        if (!$newsletter) {
            abort(404);
        }

        if ($newsletter->restore()) {
            Flash::success('Item restaurado com sucesso.');
        } else {
            Flash::error('Falha na restauração.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.newsletters.trash');
    }

    public function download(Request $request)
    {
        $query = Newsletter::sort();

        $search = [];
        if(config('mnewsletters.fields.name') !== false) {
            $search['name'] = $request->input('name', '');
        }
        $search['email'] = $request->input('email', '');
        if(config('mnewsletters.fields.name') !== false) {
            ($search['name']) ? $query->where('name', 'LIKE', '%' . $search['name'] . '%') : '';
        }
        ($search['email']) ? $query->where('email', 'LIKE', '%' . $search['email'] . '%') : '';

        $newsletters = $query->paginate(50);
        $now = Carbon::now();
        $date = Carbon::parse($now)->format('dmY');

        $user_id = Auth::user()->id;

        $nameFile = "leads".$user_id.$date.".csv";

        $csv = '';
        if(config('mnewsletters.fields.name') !== false) {
            $csv .= "\"nome\";\"email\";\"data de cadastro\"\n";

            foreach ($newsletters as $row) {
                $csv .= "\"" . $row['name'] . "\";\"" . $row['email'] . "\";\"" . Carbon::parse($row['created_at'])->format('d/m/Y H:i') . "\"\n";
            }
        }

        if(config('mnewsletters.fields.name') == false){
            $csv .= "\"email\";\"data de cadastro\"\n";

            foreach ($newsletters as $row) {
                $csv .= "\"" . $row['email'] . "\";\"" . Carbon::parse($row['created_at'])->format('d/m/Y H:i') . "\"\n";
            }
        }
        $arquivo = $nameFile;
        // Configurações header para forçar o download
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
        header ("Content-type: application/x-msexcel; charset=utf-8");
        header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
        header ("Content-Description: PHP Generated Data" );

        echo $csv;


    }

}