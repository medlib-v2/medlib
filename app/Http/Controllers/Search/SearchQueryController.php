<?php

namespace Medlib\Http\Controllers\Search;

use Medlib\Yaz\Facades\Yaz;
use Medlib\Yaz\Facades\Query;
use Medlib\Yaz\Record\YazRecords;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Medlib\MarcXML\Filter\FilterRecord;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Medlib\Http\Requests\SearchQuerySimpleRequest;
use Medlib\Http\Requests\SearchQueryDetailRequest;
use Medlib\Http\Requests\SearchQueryAdvancedRequest;
use Illuminate\Http\Response as IlluminateResponse;

class SearchQueryController extends Controller
{
    private $_results = [];

    /**
     * @param SearchQuerySimpleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doSimple(SearchQuerySimpleRequest $request)
    {
        if (Cache::has($request->get('query') . $request->get('qdb'))) {
            $this->_results = Cache::get($request->get('query') . $request->get('qdb'));
            $filter = FilterRecord::traverseStructure($this->_results);
        } else {
            /**
             * La requête utilisateur à parser
             */
            $query = Query::simple($request)->get();

            $record = Yaz::from($request->query('qdb'))
                ->where($query)
                ->orderBy('au ASC')
                ->all(YazRecords::TYPE_XML);

            if (!$record->fails() or $record->hasError() == 1005 or $record->hasError() == 213) {
                foreach ($record->getRecords() as $result) {
                    $this->_results[] = $result->toArray();
                }

                $filter = FilterRecord::traverseStructure($this->_results);

                Cache::put($request->get('query') . $request->get('qdb'), $this->_results, 10);
            } else {
                $this->_results = [
                    'error' => $record->hasError(),
                    'message' => $record->errorMessage()
                ];
                $filter = [];
                return $this->responseWithError([ 'results' => $this->_results,  'filter' => $filter], IlluminateResponse::HTTP_REQUEST_TIMEOUT);
            }

            $record->close();
        }

        return $this->responseWithSuccess([ 'results' => $this->_results,  'filter' => $filter], IlluminateResponse::HTTP_OK);
        /**
        if ($request->ajax()) {
            return response()->json([ 'results' => $this->_results,  'filter' => $filter], 200);
        } else {
            return View::make("search.results", [ 'results' => $this->_results,  'filter' => $filter]);
        }
        **/
    }

    /**
     * @param SearchQueryAdvancedRequest $request
     * @return mixed
     */
    public function doAdvanced(SearchQueryAdvancedRequest $request)
    {
        $parameters = $request->all();
        /**

        if (empty($parameters)) {
            $config = config('yaz.zebra');

            $datasource = [];

            foreach ($config as $name) {
                $datasource +=  [
                    $name['instance'] => [
                        'fullname' => $name['fullname'],
                        'syntax' => $name['format']
                    ]
                ];
            }

            return View::make("search.advanced-search", compact('datasource'));
        }
        **\/

        $rules = [
            'qdb' => 'required|not_in: ',
            'words.*.condition' => 'required',
            'words.*.title' => 'required',
            'words.*.query' => 'required|min:3'
        ];

        /**
         * Run the validation rules on the inputs from the form
         **\/
        $validator = Validator::make($parameters, $rules);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['require' => $validator->errors()], 422);
            } else {
                return Redirect::route('search.advanced')->withErrors($validator)->withInput();
            }
        }
        **/

        if (Cache::has(json_encode($parameters) . $parameters['qdb'])) {
            $this->_results = Cache::get(json_encode($parameters) . $parameters['qdb']);
            $filter = FilterRecord::traverseStructure($this->_results);
        } else {
            /**
             * La Requête utilisateur à parser
             */
            $query = Query::advanced($request)->get();

            $record = Yaz::from($parameters['qdb'])
                ->where($query)
                ->limit(1, 10240)
                ->orderBy('au ASC')
                ->all(YazRecords::TYPE_XML);

            if (!$record->fails() or $record->hasError() == 1005 or $record->hasError() == 213) {
                foreach ($record->getRecords() as $result) {
                    $this->_results[] = $result->toArray();
                }

                $filter = FilterRecord::traverseStructure($this->_results);

                Cache::put(json_encode($parameters) . $parameters['qdb'], $this->_results, 10);
            } else {
                $this->_results = [
                    'error' => $record->hasError(),
                    'message' => $record->errorMessage()
                ];
                $filter = [];
                return $this->responseWithError([ 'results' => $this->_results,  'filter' => $filter], IlluminateResponse::HTTP_REQUEST_TIMEOUT);
            }

            $record->close();
        }

        $this->responseWithSuccess([ 'results' => $this->_results,  'filter' => $filter], IlluminateResponse::HTTP_OK);
        /**
        if ($request->ajax()) {
            return response()->json([ 'results' => $this->_results,  'filter' => $filter], 200);
        } else {
            return View::make("search.results", [ 'results' => $this->_results,  'filter' => $filter]);
        }
        **/
    }

    /**
     * @param SearchQueryDetailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doDetail(SearchQueryDetailRequest $request)
    {
        $query = Query::simple($request)->get();

        $record = Yaz::from($request->query('qdb'))
            ->where($query)
            ->limit(1, 1)
            ->all(YazRecords::TYPE_XML);

        $record->close();

        if (!$record->fails() or $record->hasError() == 1005 or $record->hasError() == 213) {
            foreach ($record->getRecords() as $result) {
                $this->_results[] = $result->toArray();
            }
        } else {
            $this->_results = [
                'error' => $record->hasError(),
                'message' => $record->errorMessage()
            ];
            return $this->responseWithError(['results' => $this->_results], IlluminateResponse::HTTP_REQUEST_TIMEOUT);
        }

        $this->responseWithSuccess(['results' => $this->_results], IlluminateResponse::HTTP_OK);
        /**
        if ($request->ajax()) {
            return View::make("search.ajax.details", [ 'results' => $this->_results]);
        } else {
            return View::make("search.details", [ 'results' => $this->_results]);
        }
        **/
    }
}
