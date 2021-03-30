<?php

namespace Builders\Traits;

use Symfony\Component\HttpFoundation\Response;
use App\Services\ExceptionsService;

trait VGTTrait
{
	public $filterScope;

    protected function isMultyStatus()
    {
        return (defined("$this->modelInstance::MULTY_STATUS") && $this->modelInstance::MULTY_STATUS);
    }
	
	protected function setSorting($collection)
	{
		if (count($this->sorting)) {
			foreach ($this->sorting as $sorting) {
	            $sortBy = gettype($sorting) === 'string' ? json_decode($sorting) : $sorting;
            	$sortMethod = $sortBy->type === 'asc' ? 'sortBy' : 'sortByDesc';
            	$collection = $collection->$sortMethod($sortBy->field);
	        }
        }
		return $collection;
	}

	public function createResponse($errorData, $respData = null)
	{
		if (empty($errorData)) {
			if (empty($respData)) {
				return [
	            	'data' => [
	            		'success' => strval('Saved succesfull')
	            	],
	            	'response' => Response::HTTP_CREATED
	            ];
			} else {
				return [
	            	'data' => $respData,
	            	'response' => Response::HTTP_OK
	            ];
	        }
		} else {
			return [
            	'data' => [
            		'error' => $errorData
            	],
            	'response' => Response::HTTP_BAD_REQUEST
            ];
		}
	}

	public function parseRequest($encodedRequest)
    {
        if ($encodedRequest->filter) {
            $filters = gettype($encodedRequest->filter) === 'string' ? json_decode($encodedRequest->filter) : $encodedRequest->filter;
            if (gettype($filters) === 'object' && property_exists($filters, 'status')) {
                $this->filterScope = json_decode($filters->status);
                unset($encodedRequest->filter->status);
            }
        }
        return $encodedRequest;
    }

    private function setScopesToQuery($scopes, $query)
    {
        foreach ($scopes as $scope) {
            $scopeName = $scope['name'];
            $valueKey = 'value';
            if (array_key_exists($valueKey, $scope)) {
                $query = $query->$scopeName($scope[$valueKey]);
            } else {
                $query = $query->$scopeName();
            }
        }
        return $query;
    }

    /**
     * @param $paramData array form data
     * @param $fieldName string table fileld name
     * @return if not empty => $paramData[$fieldName] || exception
     */
    public function validateRequiredParam($paramData, $fieldName)
    {
        if (isset($paramData[$fieldName])) {
            return $paramData[$fieldName];   
        }
        $exceptionsService = new ExceptionsService("Данні для поля {$fieldName} - відсутні");
        $exceptionsService->JSONString();
    }
}