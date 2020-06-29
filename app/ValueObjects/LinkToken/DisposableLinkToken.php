<?php


namespace App\ValueObjects\LinkToken;


final class DisposableLinkToken extends LinkToken
{
    public function type(): string
    {
        return 'disposable';
    }

    public function typeReadable(): string
    {
        return trans('texts.entities.link-token.types.disposable');
    }

    public function expired(): bool
    {
        return $this->visits() !== 0;
    }

    public function statusReadable(): string
    {
        $visits = $this->visits();

        if ($visits > 0) {
            return trans('texts.entities.link-token.status.expired');
        }

        return parent::statusReadable();
    }
}
