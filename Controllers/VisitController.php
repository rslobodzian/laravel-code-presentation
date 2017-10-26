<?php

namespace App\Http\Controllers;

use App\Helpers\Export\Exporter;
use App\Helpers\Export\Transformers\VisitsTransformer;
use App\Helpers\FormState\Form\TopFiltersFormState;
use App\Repositories\VisitRepository;
use App\Services\VisitService;
use Illuminate\Http\Request;

/**
 * Class VisitController
 * @package App\Http\Controllers
 */
class VisitController extends Controller
{
    /**
     * @var VisitRepository
     */
    protected $visitRepository;

    /**
     * @var VisitService
     */
    protected $visitService;

    /**
     * @var Exporter
     */
    protected $exporter;

    /**
     * @param VisitRepository $visitRepository
     * @param VisitService $visitService
     * @param Exporter $exporter
     */
    public function __construct(VisitRepository $visitRepository, VisitService $visitService, Exporter $exporter)
    {
        $this->visitRepository = $visitRepository;
        $this->visitService = $visitService;
        $this->exporter = $exporter;
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function browsers(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByBrowser($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'),
                $this->visitService->getVisitsByBrowser($data), new VisitsTransformer(), 'visits_browser');
        }

        return view('visit.visits', [
            'title' => 'Browser',
            'tableData' => $this->visitService->getVisitsByBrowser($data),
            'visitsPie' => $this->visitService->getVisitsByBrowserPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function os(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByOS($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'),
                $data, new VisitsTransformer(), 'visits_os');
        }

        return view('visit.visits', [
            'title' => 'Operating system',
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsByOSPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function resolution(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByResolution($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'visits_resolution');
        }

        return view('visit.visits', [
            'title' => 'Resolutions',
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsByResolutionPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function clients(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByClients($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'visits_clients');
        }

        return view('visit.visits', [
            'title' => trans('labels.charts.visits clients'),
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsByClientsPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function mobileDevices(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByMobileDevices($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'visits_mobile_devices');
        }

        return view('visit.visits', [
            'title' => trans('labels.charts.visits mobile devices'),
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsByMobileDevicesPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function referrer(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByReferrer($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'referrer');
        }

        $formattedData = [];

        foreach ($data as $k => $v) {
            $v->name = trans('labels.names of refferers.' . $v->name);
            $formattedData[$k] = $v;
        }

        return view('visit.visits', [
            'title' => trans('labels.charts.referrer'),
            'tableData' => $formattedData,
            'visitsPie' => $this->visitService->getVisitsByReferrerPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function searchEngines(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsBySearchEngines($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'referrer');
        }

        return view('visit.visits', [
            'title' => trans('labels.charts.search engines'),
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsBySearchEnginesPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function campaigns(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByCampaigns($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'referrer');
        }

        return view('visit.visits', [
            'title' => trans('labels.charts.campaigns'),
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsByCampaignsPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }

    /**
     * @param TopFiltersFormState $filtersFormState
     * @param Request $request
     * @return mixed
     */
    public function websitesAndSocial(TopFiltersFormState $filtersFormState, Request $request)
    {
        $data = $this->visitRepository->getVisitsByWebsitesAndSocial($filtersFormState->getState());

        if ($request->get('export')) {
            return $this->exporter->createDocumentResponse($request->get('format'), $data, new VisitsTransformer(),
                'referrer');
        }

        return view('visit.visits', [
            'title' => trans('labels.charts.website & social'),
            'tableData' => $data,
            'visitsPie' => $this->visitService->getVisitsByWebsiteAndSocialPie($data),
            'filters' => $filtersFormState->getState()
        ]);
    }
}
