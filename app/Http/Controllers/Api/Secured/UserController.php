<?php

namespace App\Http\Controllers\Api\Secured;

use App\Criterias\User\UsernameOrEmail;
use App\Criterias\User\SearchByUsernameOrEmail;
use App\Criterias\User\SearchByEmail;
use App\Criterias\User\SearchWithoutSuperAdmin;
use App\Criterias\User\VerifiedOnly;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\User\UserRepository;
use App\Validators\UserValidator;
use App\Transformers\UserTransformer;
use App\Models\User;
use Dingo\Api\Http\Request;

class UserController extends BaseController
{
    public function __construct(UserRepository $repository, UserValidator $validator, UserTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function checkpass(Request $request)
    {
        try {
            $user = User::where('id', $request->user_id)->first();
            $isCurrent = \Hash::check($request->password, $user->password);
            return ['current' => $isCurrent];
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.'
            ], 404);
        }
    }

    public function index(Request $request)
    {
        // $this->repository->pushCriteria(new SearchWithoutSuperAdmin());
        // $this->repository->pushCriteria(new VerifiedOnly());
        
        if ($request->get('applicant')) {
            if ($request->get('username') && $request->get('email')) {
                $this->repository->pushCriteria(
                    new UsernameOrEmail($request->get('username'), $request->get('email'))
                );
            } elseif ($request->get('email')) {
                $this->repository->pushCriteria(
                    new SearchByEmail($request->get('email'))
                );
            }
        }

        if ($request->get('search')) {
            $this->repository->pushCriteria(
                new SearchByUsernameOrEmail($request->get('search'))
            );
        }

        return parent::index($request);
    }

    public function show($id)
    {
        // check if we want the current authenticated user data specified by $id === 'me'
        if ('me' == strtolower(trim($id))) {
            $id = request()->user()->id;
        }

        // call mom!
        return parent::show($id);
    }

    public function store(Request $request)
    {
        if($request->password) {
            $request->merge([
                //'password' => \Hash::make($request->password)
                'password' => User::getPasswordHashValue($request->password)
            ]);
        }

        return parent::store($request);
    }

    public function update(Request $request, $id)
    {
        if($request->password) {
            $request->merge([
                'password' => \Hash::make($request->password)
            ]);
        }
        return parent::update($request, $id);
    }
}
