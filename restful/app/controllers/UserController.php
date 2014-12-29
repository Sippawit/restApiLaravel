<?php

class UserController extends \BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return User::all();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
            'username' => ['required', 'alpha'],
            'password' => ['required', 'min:7']
        ];

        $payload = Input::only('username', 'password');

        $validator = Validator::make($payload, $rules);


        if ($validator->fails()) {
            throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }else{
        	Eloquent::unguard();
        	$user =  User::create(array(
            'username' => $payload['username'],
            'password' => Hash::make($payload['password'])
	        ));
	        Eloquent::reguard();
	        $result = array(
			        'insertd' => true,
			        'message' => 'user is insertd',
			        'user' => $user->toArray());
        	return $result;

        }



	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try{
	        $user = User::findOrFail($id);
	    }
	    catch(Illuminate\Database\Eloquent\ModelNotFoundException $exception){
	        throw new Dingo\Api\Exception\StoreResourceFailedException("entity not exist !!");
	    }

	    return $user;

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = [
            'value' => ['required'],
        ];

        $payload = Input::only('value');

        $validator = Validator::make($payload, $rules);


        if ($validator->fails()) {
            throw new Dingo\Api\Exception\UpdateResourceFailedException('Could not update user.',$validator->errors());
        }else{
        	Eloquent::unguard();
        	User::find($id)->update(json_decode($payload['value'],true));
        	$user = User::find($id);
        	Eloquent::reguard();
        	$result = array(
			        'updated' => true,
			        'message' => 'user is updated',
			        'user' => $user->toArray());
        	return $result;
        }

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(User::destroy($id)){

			$reslut = array('deleted' => true, 'message' => 'user is deleted');
		}else{
			$reslut = array('deleted' => false, 'message' => 'Could not delete user.');
		}
		return $reslut;

	}


}
