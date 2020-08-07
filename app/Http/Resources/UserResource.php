<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    private  $default_img;

    public function toArray($request)
    {
     //   return parent::toArray($request);
        $this->default_img =  asset('images/user.jpg');

        return [
            'data' => $this->wrapData($this->collection),
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'next' => $this->nextPageUrl()?$this->nextPageUrl():"",
                'prev' => $this->previousPageUrl()?$this->previousPageUrl():"",
                'path' => url('/'),
            ],
        ];

    }

    function wrapData( $dataCollection )
    {
        if( count($dataCollection) )
        {
            foreach ( $dataCollection  as $data  )
            {
                $joinDate = Carbon::parse($data->join_date);
                $leaveDate = Carbon::parse($data->leave_date);

                $dataSet[]= [
                    'id'=>enc($data->id),
                    'name'=>$data->name,
                    'email'=>$data->email,
                    'join_date'=>getDateFormat($joinDate,0),
                    'leave_date'=>getDateFormat($leaveDate,0),
                    'job_status'=>$data->job_status,
                    'experience'=>$joinDate->diff($leaveDate)->format('%y Year %m Months'),
                    'user_image'=>$this->default_img, //$this->user_image?asset('uploaded/user_images/'.$this->user_image):$default_img,
                    'updated_at'=>getDateFormat($data->updated_at,0),
                ];
            }
            return $dataSet ;
        }
        return [];


    }

    /*public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'],$jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }*/



}
