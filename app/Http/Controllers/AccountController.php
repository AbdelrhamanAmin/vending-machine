<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccountService;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\UpdateAccountRequest;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService) {
        $this->accountService = $accountService;
    }


    public function update(UpdateAccountRequest $request)
    {
        $account = User::find(Auth()->user()->id);
        $account->update($request->only(['username', 'password']));
        return $this->handleResponse($account, 'Account Updated successfully');
    }

    public function deposit(DepositRequest $request)
    {
        $deposit = $this->accountService->depositCredit($request['deposit']);
        return $this->handleResponse($deposit, 'Deposit added successfully');
    }

    public function resetCredit()
    {
        if(Auth()->user()->role !== User::BUYER_ROLE) {
            return $this->handleError('Unauthorized.', ['error'=>'Unauthorized']);
        }
        $reset = $this->accountService->resetCredit();
        return $this->handleResponse($reset, 'Credit reset successfully');
    }
}
