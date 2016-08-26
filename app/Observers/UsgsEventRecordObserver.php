<?php

namespace App\Observers;

class UsgsEventRecordObserver
{
    /**
     * @param $transaction
     */
    public function creating($transaction)
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        
        $transaction->uuid   = $uuid;
    }

    /**
     *
     */
    public function created()
    {

    }

    /**
     *
     */
    public function updating()
    {

    }

    /**
     *
     */
    public function updated()
    {

    }

    /**
     *
     */
    public function saving()
    {

    }

    /**
     *
     */
    public function saved()
    {

    }

    /**
     *
     */
    public function deleting()
    {

    }

    /**
     *
     */
    public function deleted()
    {

    }

    /**
     *
     */
    public function restoring()
    {

    }

    /**
     *
     */
    public function restored()
    {

    }
}
