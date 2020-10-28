<?php

use App\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionTypes = [
            ['id' => 1, 'transaction_name' => 'Deposit'],
            ['id' => 2, 'transaction_name' => 'Withdraw']
        ];

        foreach ($transactionTypes as $transactionType) {
            $model = new TransactionType();
            $model->fill([
                'id' => $transactionType['id'],
                'transaction_name' => $transactionType['transaction_name']
            ])->save();
        }
    }
}
