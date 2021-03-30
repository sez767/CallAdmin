<?php

namespace Builders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Builders\Traits\VGTTrait;

class VGTBuilder {

	use VGTTrait;

	protected $page = null;
	protected $count = null;
	protected $sorting = [];
	protected $filter = [];
	protected $modelInstance = null;
	protected $relations = [];
	const DEFAULT_STATUS = 0;
    protected $ambiguousFields = ['name', 'created_at', 'updated_at'];

	public function __construct($modelInstance, $relations = [], $requestData = null)
	{
		$this->modelInstance = $modelInstance;
		$this->relations = $relations;
		if ($requestData) {
			$this->page = $requestData->page;
			$this->count = $requestData->count;
			$this->sorting = $requestData->sorting ? $requestData->sorting : [];
			$this->filter = isset($requestData->filter) ? $requestData->filter : [];
		}
	}

	public function get($scopes = [], $has = null)
	{
		$query = $this->modelInstance::with($this->relations);

		if ($has) {
			$query = $query->has($has);
		}

		if (!empty($scopes)) {
			$query = $this->setScopesToQuery($scopes, $query);
		}
        
        $query = $this->setFilter($query);
        
        $agreements = $query->get();
		
		$agreements = $this->setSorting($agreements);

        $this->compareCounters($agreements->count());
        
        return $this->createResponse(null, [
    		'rows' => $agreements->forPage($this->page, $this->count)->values(),
			'count' => $agreements->count()
    	]);
	}

	private function setFilter($query)
	{
		if ($this->filter) {
            $filters = gettype($this->filter) === 'string' ? json_decode($this->filter) : $this->filter;
            foreach ($filters as $key => $filter) {
                $exploded = [];
                preg_match("/(^.*)\.(.*?)$/", $key, $exploded);
                if (count($exploded) === 3) {
                    $query->whereHas($exploded[1], function($q) use ($filter, $exploded) {
                        if ($exploded[1] !== 'acc_corporate_entity' && $exploded[2] === 'title') {
                            $q->byInquire($filter);
                        } else {
                        	$q = $this->filterDecorator($q, $exploded[2], $filter);
                        }
                    });
                } else {
                	$query = $this->filterDecorator($query, $key, $filter);
                }
            }
        }
        return $query;
	}

	private function filterDecorator($query, $field, $search) {
        if ($field === 'name') {
            $query->where($field, 'like', "%{$search}%" ); 
        } else if ($field === 'comments'){
            $query->whereHas('comments', function($q) use ($search) {
                $q->where('body', 'LIKE', "%{$search}%");
            });
        
        } else if ($field === 'status') {
            if ($search !== '') {
                if ($search === 'null') {
                    $query->whereNull($field);
                } else {
                    $statusValue = $this->isMultyStatus() ? $search : boolval($search);
                    $query->where($field, $statusValue);
                }
            }
        } else if (gettype($search) === 'integer') {
    		$query->where($field, $search);
    	} else if ($field === 'title') {
            $query->byInquire($search);
        } else if (in_array($field, $this->ambiguousFields)) {
            $query->byAmbiguousField([
                'field' => $field,
                'query' => $search
            ]);
        } 
        else {
            $query->where($field, 'like', "%{$search}%" );
        }
        return $query;
	}

	public function cancel($id)
	{
		$agreement = $this->modelInstance::findOrFail($id);
        if ($agreement->canBeCanceled()) {
            $agreement->cancel_date = Carbon::today()->toDateTimeString();
            if ($agreement->close_date === $this->modelInstance::ZERO_DATE) {
                $agreement->close_date = $agreement->cancel_date;
            }
            $agreement->cancel_user = Auth::user()->id;
            $agreement->status = $this->modelInstance::CANCELED;
            $errors = $agreement->validate(true);
            if (empty($errors)) {
                $agreement->save();
                return $this->createResponse(null, compact('agreement'));
            } else {
                return $this->createResponse($errors);
            }
        } else {
            return $this->createResponse(__('messages.813'));
        }
	}

	public function changeStatus($companyId, $id, $field)
    {
        $collection = $this->modelInstance::byCompany($companyId)->get();
        foreach ($collection as $item) {
            if ($item->id === (int)$id) {
                $item->$field = self::DEFAULT_STATUS;
            } else {
                $item->$field = (int)false;
            }
            $item->save();
        }
        return $this->createResponse(null, ['default' => self::DEFAULT_STATUS]);
    }

    /**
     * resets pages if request count is bigger then data count
     * @param int $dataAmount amount of collection items
     */
    private function compareCounters($dataAmount)
    {
        if ($this->count >= $dataAmount) {
            $this->page = 1;
        }
    }
}