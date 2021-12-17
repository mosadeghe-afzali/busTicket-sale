<?php

namespace App\repositories;

use App\Models\User;
use App\Models\Payment;

class PaymentRepository
{
    /**
     * store a new payment request in database.
     *
     * @param array $data
     */
    public function store(array $data)
    {
        Payment::query()->create($data);
    }

    /**
     * fetch amount of a payment request form database
     *
     * @param int $id
     * @return mixed
     */
    public function getAmount(int $id)
    {
        $data = Payment::query()->where('id', $id)->value('amount');

        return $data;
    }

    /**
     * fetch description of a payment request form database.
     *
     * @param int $id
     * @return mixed
     */
    public function getDescription(int $id)
    {
        $description = Payment::query()->where('id', $id)->value('description');

        return $description;
    }

    /**
     * update status and add refId of payment in database.
     *
     * @param array $data
     * @param int $id
     */
    public function update(array $data, int $id)
    {
        Payment::query()->findOrFail($id)->update($data);
    }

    /**
     * get authority of a payment request form database.
     *
     * @param int $id
     * @return int $authority
     */
    public function getAuthority(int $id)
    {
        $authority = Payment::query()->where('id', $id)->value('authority');

        return $authority;
    }

    /**
     * fetch user who paid a specific reserve.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUser(int $id)
    {
        $userId = Payment::query()->where('id', $id)->value('user_id');
        $user = User::query()->findOrFail($userId);

        return$user;
    }

    /**
     * get creation date of a specific payment.
     *
     * @param int $id
     * @return string
     */
    public function getCreatedDate($id)
    {
        return Payment::query()->where('id', $id)->value('created_at')->format('Y-m-d H:i:s');
    }
}
