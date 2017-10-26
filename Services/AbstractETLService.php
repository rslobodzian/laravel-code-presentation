<?php

namespace App\Services;

use App\Models\Customer\Source;
use App\Models\Segment;
use App\Repositories\CustomerRepository;
use App\User;

/**
 * Class AbstractETLService
 *
 * @package App\Services
 */
abstract class AbstractETLService
{
    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Start python script
     * @param User $user
     * @param Source $source
     * @param Segment|null $segment
     */
    final public function insertNewData(User $user, Source $source, Segment $segment = null)
    {
        // Update visits table before inserting data in intermediate table
        $this->updateVisitsTables($user, $source);

        $this->fillIntermediateTable($source, $segment);
    }

    /**
     * Move calculated data to customer table
     *
     * @param User $user
     * @param Source $source
     * @param Segment $segment
     * @return mixed
     */
    final public function moveCalculatedDataToCustomer(User $user, Source $source, Segment $segment = null)
    {
        $this->customerRepository->moveCalculatedDataToCustomer($user, $source, $segment);
    }

    /**
     * @param User $user
     * @param Source $source
     * @return mixed
     */
    abstract protected function updateVisitsTables(User $user, Source $source);

    /**
     * @param Source $source
     * @param Segment|null $segment
     */
    private function fillIntermediateTable(Source $source, Segment $segment = null)
    {
        $this->customerRepository->fillIntermediateTable($source, $segment);
    }

}
