<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Transaction
{
    public static function run(callable $callback)
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return $result;
    }
}
