<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\BlogPostRepositoryInterface;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Repositories\Contracts\FaqRepositoryInterface;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Services\CmsService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected CmsService $cmsService,
        protected ServiceRepositoryInterface $serviceRepository,
        protected DoctorRepositoryInterface $doctorRepository,
        protected ReviewRepositoryInterface $reviewRepository,
        protected BlogPostRepositoryInterface $blogPostRepository,
        protected GalleryItemRepositoryInterface $galleryItemRepository,
        protected FaqRepositoryInterface $faqRepository
    ) {}

    public function __invoke(): View
    {
        $heroBanners = $this->cmsService->getActiveBanners();
        $aboutSection = $this->cmsService->getActiveAboutSection();
        $statistics = $this->cmsService->getActiveStatistics();
        $features = $this->cmsService->getActiveFeatures();
        $howItWorks = $this->cmsService->getActiveHowItWorks();
        $ctaSection = $this->cmsService->getActiveCtaSection();

        $services = $this->serviceRepository->getActiveServices()->take(6);
        $doctors = $this->doctorRepository->getActiveDoctors()->take(4);
        $reviews = $this->reviewRepository->getApprovedReviews(6);
        $blogPosts = $this->blogPostRepository->getRecentPublished(3);
        $galleryItems = $this->galleryItemRepository->getActive()->take(6);
        $faqs = $this->faqRepository->getActive(6);

        return view('pages.home', compact(
            'heroBanners',
            'aboutSection',
            'statistics',
            'features',
            'howItWorks',
            'ctaSection',
            'services',
            'doctors',
            'reviews',
            'blogPosts',
            'galleryItems',
            'faqs'
        ));
    }
}
