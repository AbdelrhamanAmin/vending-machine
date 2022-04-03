<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;


class AccountService {

    public function depositCredit($credit)
    {
        $userAccount = User::find(Auth()->user()->id);
        $credit = $credit + $userAccount->deposit;
        return $userAccount->update(['deposit' => $credit]);
    }

    public function resetCredit()
    {
        $userAccount = User::find(Auth()->user()->id);
        return $userAccount->update(['deposit' => 0]);
    }
}
