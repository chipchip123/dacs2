<section class="category-bar">
  <div class="container px-3">
    <div class="category-scroll">
      @foreach(\App\Helpers\CategoryHelper::getAll() as $c)
        <a href="/products/category/{{ $c->category_id }}" class="category-item">
          <span class="category-text">{{ $c->category_name }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>
