<?php

namespace App\Services;

use App\Models\Customer\Source;
use App\User;

/**
 * Class PiwikETLService
 * @package App\Services
 */
class PiwikETLService extends AbstractETLService
{
    /**
     * @inheritdoc
     */
    public function updateVisitsTables(User $user, Source $source)
    {
        $this->customerRepository->fillVisitsFromPivik($source);

        foreach ($user->segments as $segment) {
            $this->customerRepository->fillVisitsFromPivik($source, $segment);
        }
    }
}
