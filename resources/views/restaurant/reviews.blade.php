@extends('restaurant.layout', compact('restaurant'))
@section('section')
<div class="row" style="margin-top:10px">
    <div class="col-sm-5">
        <div class="box">
            <div class="box-content" style="padding: 0">
                @if(Auth::check())
                    @if($review)
                        <h3>Thanks for your review! <i class="fa fa-smile-o"></i></h3>
                        <hr>
                        <blockquote>
                            {!! Form::selectRange('rating', 1, 5, $review->rating, ['id' => 'user-rating']); !!}
                            <p class="lead">
                                {{ $review->feedback }}
                            </p>
                            <footer> {{ date_create($review->created_at)->format('F d, Y h:i A') }}</footer>
                        </blockquote>
                    @else
                        <h3>Help us improve! <i class="fa fa-smile-o"></i></h3>
                        <hr>
                        
                        {!! Form::open(['url' => route('restaurant.review.save', ['id' => $restaurant->id]), 'method' => 'POST']) !!}
                            <div class="text-center">
                                <select id="rating" name="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            {!! Form::bsTextarea('feedback', 'Give us your feedback') !!}
                            <button type="submit" class="btn btn-danger">Submit!</button>
                        {!! Form::close() !!}
                    @endif
                @else
                    
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        @if($restaurant->reviews->count())
            <div class="box">
                <div class="box-content" style="padding: 0">
                    <h3>Restaurant Reviews</h3>
                    <hr>
                    @foreach($restaurant->reviews AS $rating)
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                <img class="media-object" src="{{ $rating->user->displayPhoto() }}" alt="{{ $rating->user->fullname() }}" style="width:64px;height:64px">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading text-danger">{{ $rating->user->fullname() }}</h4>
                                {!! Form::selectRange('', 1, 5, $rating->rating, ['class' => 'mass-rating']); !!}
                                <p>{!! $rating->feedback ?: '<em class="text-warning">User has not given any feedback</em>' !!} [[ <small>{{ date_create($rating->created_at)->format('F d, Y \@ h:i A') }} ]]</small></p>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bs-callout bs-callout-danger" style="background:#fff">
                <h4>Uh oh!</h4>
                <p>This restaurant does not have any reviews yet!</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
    
    <script type="text/javascript">
        $(document).ready(function () {
            $(function() {
                $('#rating').barrating({
                    theme: 'fontawesome-stars-o',
                });

                $('.mass-rating').barrating({
                    theme: 'fontawesome-stars-o',
                    readonly: true
                });
                

                @if($review)
                    $('#user-rating').barrating({
                        theme: 'fontawesome-stars-o',
                        initialRating: {{ $review->rating }},
                        readonly: true
                    });
                @endif
            });
        })
    </script>
@endpush