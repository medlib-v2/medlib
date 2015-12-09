<?php

namespace Medlib\Http\Controllers\Search;

use Yaz\YazRecords;
use Yaz\Facades\Yaz;
use Yaz\Facades\Query;
use Medlib\Http\Requests;
use Medlib\MarcXML\MarcXML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;

class SearchQueryController extends Controller
{

    private $_results = [];

    public function doSimple(Request $request)
    {
        $rules = [
            'query'    => 'required|min:3',
            'qdb' => 'required|not_in: '
        ];

        /** create custom validation messages */
        $messages = [
            'required' => 'The :attribute is really really important.',
        ];

        /** run the validation rules on the inputs from the form */
        $validator = Validator::make($request->all(), $rules, $messages);

        /** if the validator fails, redirect back to the form */
        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator)
                ->withInput();
        }


        // La requête utilisateur à parser
        $query = Query::simple($request)->get();

        $record = Yaz::from($request->query('qdb'))
            ->where($query)
            ->limit(0, 10)
            ->orderBy('au ASC')
            ->all(YazRecords::TYPE_XML);

        if(!$record->fails())
        {
            foreach($record->getRecords() as $result)
            {
                $parserResult = new QuiteSimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>'.$result);
                $parserResult->registerXPathNamespaces([ 'marc' => 'http://www.loc.gov/MARC21/slim' ]);

                $this->_results[] = MarcXML::parse($parserResult);
            }
            //dd($this->_results);
        }
        else {
            $this->_results = [
                'error' => $record->hasError(),
                'message' => $record->errorMessage()
            ];
        }

        return View::make("search.results", [ 'results' => $this->_results ]);
    }
}
