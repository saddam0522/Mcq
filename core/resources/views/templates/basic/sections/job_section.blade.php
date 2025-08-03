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
      <div class="col-md-6 col-lg-3">
        <div class="job-category-list">
          @foreach (range(1, 8) as $i)
          <a href="#">
            <i class="fa-solid fa-chevron-right"></i>
            <span>
              <span class="wr">Accounting/Finance</span>
              <span class="wr">(439)</span>
            </span>
          </a>
          @endforeach
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="job-category-list">
          @foreach (range(1, 8) as $i)
          <a href="#">
            <i class="fa-solid fa-chevron-right"></i>
            <span>
              <span class="wr">Accounting/Finance</span>
              <span class="wr">(439)</span>
            </span>
          </a>
          @endforeach
        </div>
      </div>
      <div class="col-md-6 col-lg-3 d-none d-md-block">
        <div class="job-category-list">
          @foreach (range(1, 8) as $i)
          <a href="#">
            <i class="fa-solid fa-chevron-right"></i>
            <span>
              <span class="wr">Accounting/Finance</span>
              <span class="wr">(439)</span>
            </span>
          </a>
          @endforeach
        </div>
      </div>
      <div class="col-md-6 col-lg-3 d-none d-md-block">
        <div class="job-category-list">
          @foreach (range(1, 8) as $i)
          <a href="#">
            <i class="fa-solid fa-chevron-right"></i>
            <span>
              <span class="wr">Accounting/Finance</span>
              <span class="wr">(439)</span>
            </span>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="m-visible  d-none">
    <div class="d-flex justify-content-center pt-4">
      <div class="job-section-btn align-items-center justify-content-center gap-3">
        <a href="#">View All</a>
        <i class="fa-solid fa-arrow-right"></i>
      </div>
    </div>
  </div>
</div>