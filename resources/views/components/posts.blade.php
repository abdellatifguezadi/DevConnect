@foreach($posts as $post)
    @include('components.post-card', ['post' => $post])
@endforeach
