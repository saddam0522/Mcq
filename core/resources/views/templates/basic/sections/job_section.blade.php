<div class="container">
  <div class="section-top">
    <div class="d-flex align-items-center justify-content-center">
      <div class="s-middle">
      </div>
    </div>
    <div class="section-both-side d-flex align-items-center justify-content-between gap-3">
      <div class="s-left w-full">
        <h2 class="s-title text-center text-md-start">চাকরির বিজ্ঞপ্তি</h2>
      </div>
      <div class="s-right m-hide">
        <div class="job-section-btn align-items-center justify-content-center gap-3">
          <a href="{{ route('all.jobs') }}">View All</a>
          <i class="fa-solid fa-arrow-right"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="all-jobs-category">
    <div class="row">
      @foreach ($jobCategories->chunk(4) as $chunk)
        <div class="col-md-6 col-lg-3">
          <div class="job-category-list">
            @foreach ($chunk as $category)
              <a href="{{ route('category.subjects', $category->slug) }}">
                <i class="fa-solid fa-chevron-right"></i>
                <span>
                  <span class="wr">{{ $category->name }}</span>
                  <span class="wr">({{ $category->job_posts_count }})</span>
                </span>
              </a>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="m-visible d-none">
    <div class="d-flex justify-content-center pt-4">
      <div class="job-section-btn align-items-center justify-content-center gap-3">
        <a href="{{ route('all.jobs') }}">View All</a>
        <i class="fa-solid fa-arrow-right"></i>
      </div>
    </div>
  </div>
</div>