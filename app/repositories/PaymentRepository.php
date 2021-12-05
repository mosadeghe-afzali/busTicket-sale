<?php


namespace App\repositories;


use App\Models\Payment;
use App\Models\User;

class PaymentRepository
{
    /* store a new payment request in database */
    public function store($data)
    {
        $pay = Payment::query()->create($data);

        return $pay;
    }

    /* fetch amount of a payment request form database */
    public function getAmount($id)
    {
        $data = Payment::query()->where('id', $id)->value('amount');

        return $data;
    }

    /* fetch description of a payment request form database */
    public function getDescription($id)
    {
        $description = Payment::query()->where('id', $id)->value('description');

        return $description;
    }

    /* update status and add refId of payment in database */
    public function update($data, $id)
    {
        $pay = Payment::query()->findOrFail($id)->update($data);

        return $pay;
    }

    /* get authority of a payment request form database */
    public function getAuthority($id)
    {
        $au = Payment::query()->where('id', $id)->value('authority');

        return $au;
    }

    /* fetch user who paid a specific reserve */
    public function getUser($id)
    {
        $userId = Payment::query()->where('id', $id)->value('user_id');
        $user = User::query()->find($userId);

        return$user;
    }

    /* get creation date of a specific payment */
    public function getCreatedDate($id)
    {
        return Payment::query()->where('id', $id)->value('created_at')->format('Y-m-d H:i:s');
    }

}
