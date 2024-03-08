<section class="latest-blog-posts">
    <div class="text">
        <div>
            <h2 class="section-heading">{{ $data['title'] }}</h2>
            {!! $data['description'] !!}
        </div>
        <a href="{{ $data['view_all_posts_link'] }}" title="{{ $data['view_all_posts_text'] }}" class="read-more">{{ $data['view_all_posts_text'] }}</a>
    </div>

    <div class="posts-list">
        @foreach($data['recent_posts'] as $post)
            <article class="post">
                <div class="thumbnail">
                    <a href="{{ $post['link'] }}">
                        <img src="{{ $post['image'] }}" alt="{{ $post['name'] }}">
                    </a>
                </div>

                <div class="meta">
                    <span class="posted-on">{{ $post['created_at'] }}</span>
                </div>

                <h3 class="post-heading">
                    <a href="{{ $post['link'] }}">{{ $post['name'] }}</a>
                </h3>
            </article>
        @endforeach
    </div>
</section>
