<?php

namespace App\Services;

use App\Models\AboutSection;
use App\Models\CtaSection;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\HeroBanner;
use App\Models\HowItWork;
use App\Models\Statistic;
use App\Repositories\Contracts\AboutSectionRepositoryInterface;
use App\Repositories\Contracts\CtaSectionRepositoryInterface;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use App\Repositories\Contracts\HeroBannerRepositoryInterface;
use App\Repositories\Contracts\HowItWorkRepositoryInterface;
use App\Repositories\Contracts\StatisticRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class CmsService
{
    public function __construct(
        protected HeroBannerRepositoryInterface $heroBannerRepo,
        protected AboutSectionRepositoryInterface $aboutSectionRepo,
        protected StatisticRepositoryInterface $statisticRepo,
        protected FeatureRepositoryInterface $featureRepo,
        protected HowItWorkRepositoryInterface $howItWorkRepo,
        protected CtaSectionRepositoryInterface $ctaSectionRepo,
        protected GalleryItemRepositoryInterface $galleryItemRepo,
        protected FileUploadService $fileUploadService
    ) {}

    // ==========================================
    // HERO BANNERS
    // ==========================================

    public function getAllBanners(): Collection
    {
        return HeroBanner::query()->orderBy('sort_order')->orderByDesc('id')->get();
    }

    public function getActiveBanners(): Collection
    {
        return $this->heroBannerRepo->getActive();
    }

    public function getBannerById(int $id): ?HeroBanner
    {
        /** @var HeroBanner|null */
        return $this->heroBannerRepo->findById($id);
    }

    public function createBanner(array $data, ?UploadedFile $image = null, ?UploadedFile $mobileImage = null): HeroBanner
    {
        if ($image) {
            $data['image'] = $this->fileUploadService->upload($image, 'banners');
        }

        if ($mobileImage) {
            $data['mobile_image'] = $this->fileUploadService->upload($mobileImage, 'banners');
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        $data['sort_order'] = $data['sort_order'] ?? (HeroBanner::max('sort_order') + 1);

        /** @var HeroBanner */
        return $this->heroBannerRepo->create($data);
    }

    public function updateBanner(int $id, array $data, ?UploadedFile $image = null, ?UploadedFile $mobileImage = null): bool
    {
        $banner = $this->getBannerById($id);
        if (! $banner) {
            return false;
        }

        if ($image) {
            $data['image'] = $this->fileUploadService->replace($banner->image, $image, 'banners');
        }

        if ($mobileImage) {
            $data['mobile_image'] = $this->fileUploadService->replace($banner->mobile_image, $mobileImage, 'banners');
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return $this->heroBannerRepo->update($id, $data);
    }

    public function deleteBanner(int $id): bool
    {
        $banner = $this->getBannerById($id);
        if ($banner) {
            $this->fileUploadService->delete($banner->image);
            $this->fileUploadService->delete($banner->mobile_image);
        }

        return $this->heroBannerRepo->delete($id);
    }

    public function toggleBannerStatus(int $id): bool
    {
        $banner = $this->getBannerById($id);
        if (! $banner) {
            return false;
        }

        return $banner->update(['is_active' => ! $banner->is_active]);
    }

    // ==========================================
    // ABOUT SECTION
    // ==========================================

    public function getAboutSection(): ?AboutSection
    {
        return AboutSection::first();
    }

    public function getActiveAboutSection(): ?AboutSection
    {
        return $this->aboutSectionRepo->getActive();
    }

    public function saveAboutSection(array $data, ?UploadedFile $image = null, ?UploadedFile $secondaryImage = null): AboutSection
    {
        $about = $this->getAboutSection();

        if ($image) {
            $data['image'] = $about && $about->image
                ? $this->fileUploadService->replace($about->image, $image, 'about')
                : $this->fileUploadService->upload($image, 'about');
        }

        if ($secondaryImage) {
            $data['secondary_image'] = $about && $about->secondary_image
                ? $this->fileUploadService->replace($about->secondary_image, $secondaryImage, 'about')
                : $this->fileUploadService->upload($secondaryImage, 'about');
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        if ($about) {
            $about->update($data);

            return $about->fresh();
        }

        /** @var AboutSection */
        return $this->aboutSectionRepo->create($data);
    }

    // ==========================================
    // STATISTICS
    // ==========================================

    public function getAllStatistics(): Collection
    {
        return Statistic::query()->orderBy('sort_order')->orderBy('id')->get();
    }

    public function getActiveStatistics(): Collection
    {
        return $this->statisticRepo->getActive();
    }

    public function getStatisticById(int $id): ?Statistic
    {
        /** @var Statistic|null */
        return $this->statisticRepo->findById($id);
    }

    public function createStatistic(array $data): Statistic
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        $data['sort_order'] = $data['sort_order'] ?? (Statistic::max('sort_order') + 1);

        /** @var Statistic */
        return $this->statisticRepo->create($data);
    }

    public function updateStatistic(int $id, array $data): bool
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return $this->statisticRepo->update($id, $data);
    }

    public function deleteStatistic(int $id): bool
    {
        return $this->statisticRepo->delete($id);
    }

    // ==========================================
    // FEATURES (WHY CHOOSE US)
    // ==========================================

    public function getAllFeatures(): Collection
    {
        return Feature::query()->orderBy('sort_order')->orderBy('id')->get();
    }

    public function getActiveFeatures(): Collection
    {
        return $this->featureRepo->getActive();
    }

    public function getFeatureById(int $id): ?Feature
    {
        /** @var Feature|null */
        return $this->featureRepo->findById($id);
    }

    public function createFeature(array $data): Feature
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        $data['sort_order'] = $data['sort_order'] ?? (Feature::max('sort_order') + 1);

        /** @var Feature */
        return $this->featureRepo->create($data);
    }

    public function updateFeature(int $id, array $data): bool
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return $this->featureRepo->update($id, $data);
    }

    public function deleteFeature(int $id): bool
    {
        return $this->featureRepo->delete($id);
    }

    // ==========================================
    // HOW IT WORKS
    // ==========================================

    public function getAllHowItWorks(): Collection
    {
        return HowItWork::query()->orderBy('sort_order')->orderBy('step_number')->get();
    }

    public function getActiveHowItWorks(): Collection
    {
        return $this->howItWorkRepo->getActive();
    }

    public function getHowItWorkById(int $id): ?HowItWork
    {
        /** @var HowItWork|null */
        return $this->howItWorkRepo->findById($id);
    }

    public function createHowItWork(array $data): HowItWork
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        $data['sort_order'] = $data['sort_order'] ?? (HowItWork::max('sort_order') + 1);
        $data['step_number'] = $data['step_number'] ?? (HowItWork::max('step_number') + 1);

        /** @var HowItWork */
        return $this->howItWorkRepo->create($data);
    }

    public function updateHowItWork(int $id, array $data): bool
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return $this->howItWorkRepo->update($id, $data);
    }

    public function deleteHowItWork(int $id): bool
    {
        return $this->howItWorkRepo->delete($id);
    }

    // ==========================================
    // CTA SECTION
    // ==========================================

    public function getCtaSection(): ?CtaSection
    {
        return CtaSection::first();
    }

    public function getActiveCtaSection(): ?CtaSection
    {
        return $this->ctaSectionRepo->getActive();
    }

    public function saveCtaSection(array $data, ?UploadedFile $backgroundImage = null): CtaSection
    {
        $cta = $this->getCtaSection();

        if ($backgroundImage) {
            $data['background_image'] = $cta && $cta->background_image
                ? $this->fileUploadService->replace($cta->background_image, $backgroundImage, 'cta')
                : $this->fileUploadService->upload($backgroundImage, 'cta');
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        if ($cta) {
            $cta->update($data);

            return $cta->fresh();
        }

        /** @var CtaSection */
        return $this->ctaSectionRepo->create($data);
    }

    // ==========================================
    // GALLERY ITEMS
    // ==========================================

    public function getAllGalleryItems(): Collection
    {
        return GalleryItem::query()->orderBy('sort_order')->orderByDesc('id')->get();
    }

    public function getActiveGalleryItems(): Collection
    {
        return $this->galleryItemRepo->getActive();
    }

    public function getGalleryItemById(int $id): ?GalleryItem
    {
        /** @var GalleryItem|null */
        return $this->galleryItemRepo->findById($id);
    }

    public function createGalleryItem(array $data, ?UploadedFile $image = null, ?UploadedFile $beforeImage = null, ?UploadedFile $afterImage = null): GalleryItem
    {
        if ($image) {
            $data['image'] = $this->fileUploadService->upload($image, 'gallery');
        }

        if ($beforeImage) {
            $data['before_image'] = $this->fileUploadService->upload($beforeImage, 'gallery');
        }

        if ($afterImage) {
            $data['after_image'] = $this->fileUploadService->upload($afterImage, 'gallery');
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;

        /** @var GalleryItem */
        return $this->galleryItemRepo->create($data);
    }

    public function updateGalleryItem(int $id, array $data, ?UploadedFile $image = null, ?UploadedFile $beforeImage = null, ?UploadedFile $afterImage = null): GalleryItem
    {
        $item = $this->getGalleryItemById($id);
        if (! $item) {
            throw new \Exception('Gallery item not found');
        }

        if ($image) {
            $data['image'] = $item->image
                ? $this->fileUploadService->replace($item->image, $image, 'gallery')
                : $this->fileUploadService->upload($image, 'gallery');
        }

        if ($beforeImage) {
            $data['before_image'] = $item->before_image
                ? $this->fileUploadService->replace($item->before_image, $beforeImage, 'gallery')
                : $this->fileUploadService->upload($beforeImage, 'gallery');
        }

        if ($afterImage) {
            $data['after_image'] = $item->after_image
                ? $this->fileUploadService->replace($item->after_image, $afterImage, 'gallery')
                : $this->fileUploadService->upload($afterImage, 'gallery');
        }

        if (isset($data['is_active'])) {
            $data['is_active'] = (bool) $data['is_active'];
        }

        $this->galleryItemRepo->update($id, $data);

        return $item->fresh();
    }

    public function deleteGalleryItem(int $id): bool
    {
        $item = $this->getGalleryItemById($id);
        if ($item) {
            if ($item->image) {
                $this->fileUploadService->delete($item->image);
            }
            if ($item->before_image) {
                $this->fileUploadService->delete($item->before_image);
            }
            if ($item->after_image) {
                $this->fileUploadService->delete($item->after_image);
            }
        }

        return $this->galleryItemRepo->delete($id);
    }

    public function toggleGalleryItem(int $id): bool
    {
        return $this->galleryItemRepo->toggleActive($id);
    }
}
