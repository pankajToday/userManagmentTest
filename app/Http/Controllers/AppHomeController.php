<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppHomeController extends Controller
{


    /**
     * @param Request $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Carbon\Exceptions\InvalidFormatException
     * pagination removed due to Front-end limitation. we have to change DataTable of Front-end.
     */
    public function index(Request $req )
    {
        $paginationData =[];
        $users =  User::orderBy("id","desc")->get();

        if( count($users) )
        {
           /* $paginationData =[
                'total' => $users->total(),
                'count' => $users->count(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'next' => $users->nextPageUrl()?$users->nextPageUrl():"",
                'prev' => $users->previousPageUrl()?$users->previousPageUrl():"",
                'path' => url('/'),
            ];*/

            foreach ( $users  as $data  )
            {
                $joinDate = Carbon::parse($data->join_date);
                $leaveDate = Carbon::parse($data->leave_date);

                if(  $data->user_image && is_FileExist(asset('uploads/user_images/'.$data->user_image)) )
                {
                    $img = asset('uploads/user_images/'.$data->user_image);
                }
                else{
                    $img = asset('images/user.jpg');
                }


                $dataSet[]= [
                    'id'=>enc($data->id),
                    'name'=>$data->full_name,
                    'email'=>$data->email,
                    'join_date'=>getDateFormat($joinDate,0),
                    'leave_date'=>getDateFormat($leaveDate,0),
                    'job_status'=>$data->job_status,
                    'experience'=>$joinDate->diff($leaveDate)->format('%y Year %m Months'),
                    'user_image'=>$img,
                    'updated_at'=>getDateFormat($data->updated_at,0),
                ];
            }

        }
        //return view('index',['dataCollections'=>new UserResource($user)]);
        return view('index',['dataCollections'=>$dataSet ,'paginationData'=> $paginationData]);
    }

    # file Limit 500kb.

    /**
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     * Image file limit is 500kb.
     * upload directory ::  uploads/user_images . ' uploads ' automatically append by system.
     */
    public function storeUser( UserRequest $req )
    {
       $user =  User::where("email",$req->email)->first();

       if( !$user)
       {
           $user =  new  User();
       }

       $joinDate =$req->joinDate?Carbon::createFromFormat('m/d/Y',$req->joinDate)->format('Y-m-d'):"";
       $leaveDate =$req->leaveDate?Carbon::createFromFormat('m/d/Y',$req->leaveDate)->format('Y-m-d'):"";

       if( $joinDate > $leaveDate &&  $req->workStatus == 0 )
       {
           return response()->json(["message"=>"Leave Date is invalid!. Leave Date can not be less than to Join Date" ,'status'=>'danger' ]);
       }

        $user ->full_name = $req->full_name ;
        $user ->email = $req->email ;
        $user ->join_date = $joinDate;
        $user ->leave_date =$leaveDate?$leaveDate:null;
        $user ->job_status = $req->workStatus?$req->workStatus:0  ;

        if( $user ->save() )
        {
            if( $req->userImage )
            {
                $userImage = $req->file('userImage');

                if (($userImage->getClientMimeType()=="image/jpeg" || $userImage->getClientMimeType()=="image/jpg" ||
                        $userImage->getClientMimeType()=="image/png" )&& $userImage->getSize()<=500000)
                {
                    $filename = 'user_'.date('ymd_').rand(111,999);
                    $imageName = $filename.'.'.$userImage->guessExtension();

                    # Create image  Folder if not exist.
                    if(!is_dir(public_path('uploads/'))) {
                        mkdir(public_path('uploads/'),01777);
                    }

                    if(!is_dir(public_path('uploads/user_images')))
                    {
                        mkdir(public_path('uploads/user_images'),01777);
                    }
                    Storage::disk('myDisk')->putFileAs ('user_images',$userImage,$imageName);
                    $user ->user_image = $imageName ;
                    $user->save();

                }
                else
                {
                    return response()->json(["message"=>"Image size should be less to 500kb" ,'status'=>'danger' ]);
                }
            }
            return response()->json(["message"=>"User created successfully!" ,'status'=>'success' ]);
        }
        return response()->json(["message"=>"Unable to save record!" ,'status'=>'danger' ]);
    }

    /**
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     * Do not use  Directory name '  uploads '. it will automatically append by system.
     * when user will delete then image  file self  permanent deleted but user record only soft delete.
     */
    public function destroyUser(Request $req )
    {
        $user =  User::where('id',dnc($req->id))->first();
        if(  $user )
        {
            $user->delete();
            Storage::disk('myDisk')->delete('user_images/'.$user->user_image);
            $user->user_image =null;
            $user->save();
            return response()->json(["message"=>"User deleted successfully!" ,'status'=>'success' ]);
        }
        return response()->json(["message"=>"Unable to delete user!" ,'status'=>'danger' ]);
    }



    function editUserShow( Request $req )
    {
        $user =  User::where("id",dnc($req->id))->first();

        if( $user )
        {
            return view('');
        }
    }


}
