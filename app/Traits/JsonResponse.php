<?php
namespace App\Traits;

trait JsonResponse {
	public function customResponse( $data, $status, $message, $errors, $statusCode ) {
		return [
			'data' => $data,
			'status' => $status,
			'message' => $message,
			'errors' => $errors,
			'statusCode' => $statusCode,
		];
	}
	public function success( $data, $statusCode = 200, $status = 'success', $message = 'success', $errors = [], $pagination = false ) {
		$response = $this->customResponse( $data, $status, $message, $errors, $statusCode );
		if ( $pagination ) {
			$response['meta'] = [
				'hasMorePages' => $data->resource->hasMorePages(),
				'total' => $data->resource->total(),
				'lastPage' => $data->resource->lastPage(),
				'perPage' => $data->resource->perPage(),
				'currentPage' => $data->resource->currentPage(),
				'path' => $data->resource->path(),
			];
		}
		return response()->json( $response, $statusCode );
	}
	public function failure( $message = 'failure', $errors = [], $statusCode = 404, $data = [], $status = 'failure' ) {
		return response()
			->json( $this->customResponse( $data, $status, $message, $errors, $statusCode ) );
	}
}
