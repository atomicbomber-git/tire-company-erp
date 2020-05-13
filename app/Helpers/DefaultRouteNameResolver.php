<?php


namespace App\Helpers;


use App\Constants\UserType;
use App\User;

class DefaultRouteNameResolver
{
    public static function get(?User $user)
    {
        switch ($user->type ?? null) {
            case UserType::ADMINISTRATOR:
                return "customer.index";
            case UserType::SALESPERSON:
                return "salesperson-sales-order.index";
            case UserType::INVOICE_CLERK:
                return "invoice-clerk-sales-order.index";
            default:
                return "login";
        }
    }
}
