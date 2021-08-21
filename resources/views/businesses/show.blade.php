@extends('app')
@section('content')
<div class="business-page col-xs-12">
  <div class="row no-margin">
    <!-- Top Row -->
    <div class="info-stuff pull-left">
      <img class="logo pull-left" src="{{ $business->logo ? asset("assets/storage/$business->logo") : asset('assets/images/placeholder.png') }}">
      <h1 class="section-header pull-left">
        {{ $business->name }}
        <br>
        @if($business->reviews->isEmpty())
          <small class="rating">No rating yet</small>
          <br>
        @else
          <!-- RatingBar -->
          <div id="rating-bar" data-interactive="0">
            <ul class="rating-icons md">
              <li>
                <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive" data-rating-level="1"/>
              </li>
              <li>
                <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive" data-rating-level="2"/>
              </li>
              <li>
                <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive" data-rating-level="3"/>
              </li>
              <li>
                <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive" data-rating-level="4"/>
              </li>
              <li>
                <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive" data-rating-level="5"/>
              </li>
              <li>
                <p>
                  <small>&nbsp;| <a data-toggle="modal" data-target="#scorecard-modal">View Scorecard</a></small></a>
                </p>
              </li>
            </ul>
            <input type="hidden" value="{{ $business->rating }}" class="hidden" id="rating-input"/>
          </div>
        @endif
        <small class="categories">{{ implode(', ', array_merge($business->e_categories_concat(), $business->commodities_concat())) }}</small>
      </h1>
    </div>
    <div class="actions pull-right">
      @if(isset($_GET['dev']) && $_GET['dev']==1)
      <a href="{{route('Send Message', ['user_id' => $business->user_id])}}" class="btn btn-primary btn-lg"><i class="icon-pencil"></i> Chat With Us</a>
      @endif

            @if(\Auth::check())
                @if(\Auth::user()->hasSubscriptions())
                   <a href="/chat?business_id={{ $business->user_id }}" class="btn btn-primary btn-lg"><i class="fa fa-comments-o" aria-hidden="true"></i> Chat With Us</a>
                @endif 
            @endif

 
      @if(\Auth::check())
        @if(\Auth::user()->business)
        
          @if(\Auth::user()->business->id != $business->id)



{{-- @if(\Auth::user()->billing)
           
<a href="{{ route('Chat & Message') }}" class="btn btn-primary btn-lg"><i class="fa fa-comments-o" aria-hidden="true"></i> Chat With Us</a>
      @endif  --}}  


            <button id="follow-button" business-id="{{ $business->id }}" following="{{ \Auth::user()->following()->where('business_id', $business->id)->count() > 0 }}" class="btn btn-primary btn-lg">
              @if(\Auth::user()->following()->where('business_id', $business->id)->count() == 0)
                <i class="icon-heart"></i> Follow
              @else
                <i class="icon-check"></i> Following
              @endif
            </button>
            <a href="{{route('Create Review', ['id' => $business->id])}}" class="btn btn-primary btn-lg"><i class="icon-pencil"></i> Review</a>




          @else
            <a href="{{ route('Edit Business', ['id' => $business->id]) }}" class="btn btn-primary btn-lg">
              <i class="icon-pencil"></i> Edit
            </a>
          @endif
        @else
          @if(!\Auth::user()->admin)
            <button id="follow-button" business-id="{{ $business->id }}" following="{{ \Auth::user()->following()->where('business_id', $business->id)->count() > 0 }}" class="btn btn-primary btn-lg">
              @if(\Auth::user()->following()->where('business_id', $business->id)->count() == 0)
                <i class="icon-heart"></i> Follow
              @else
                <i class="icon-check"></i> Following
              @endif
            </button>
            <a href="{{route('Create Review', ['id' => $business->id])}}" class="btn btn-primary btn-lg"><i class="icon-pencil"></i> Review</a>
          @else
            <a href="{{ route('Edit Business', ['id' => $business->id]) }}" class="btn btn-primary btn-lg">
              <i class="icon-pencil"></i> Edit
            </a>
            <a href="/deactivate-business-admin/{{ $business->id }}" class="btn btn-primary btn-lg">
              <i class="icon-pencil"></i> Disable
            </a>
          @endif
        @endif
      @endif
    </div>
  </div>
  <style>
  iframe {
	  width:100%;
  }

</style>
  <?php 
 
  if(isset($business->youtube_video) && !empty($business->youtube_video)){ ?>
	<div class="row no-margin" style="margin:0px 14px -5px">
	
		<div class="row">
			
    
	  
<?php 


$link = $business->youtube_video;


$video_id = explode("?v=", $link);

if(isset($video_id[1]) && !empty($video_id[1])){
$video_id1 = $video_id[1];

  ?>
<iframe width="560" height="400" src="https://www.youtube.com/embed/<?php echo $video_id1 ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
	</div>
	
  <?php } } ?>

  <!-- Map Row -->
  <div class="row no-margin">
    <div class="col-md-8 col-xs-12 no-pad-left no-pad-small map-info left-business-section">
      <div class="col-md-6 col-xs-12 no-pad map">
        {!! Mapper::render() !!}
      </div>
      <div class="col-md-6 col-xs-12 info" style="background-image:url({{ asset("assets/images/dark-bg.png") }})">
        <p>
          {{ $business->address }}
          @if($business->address2)
            <br>
            {{ $business->address2 }}
          @endif
          <br>
          {{ $business->city }}, {{ $business->state }} {{ $business->zip }}
        </p>
        <p>
          {{ $business->phone }}
        </p>
        <p>

        <?php 
        $URL = $business->url;
        $weblink =   $URL; 
            if(strpos($weblink, "http://") !== false || strpos($weblink, "https://") !== false){ }
            else { $weblink = "http://".$weblink; }
         ?>



          <!-- <a target="_blank" href="{{ $business->url }}">Business Website</a> -->


          <a target="_blank" <?php if($weblink != 'http://'){ ?> href="<?php echo $weblink; ?>"<?php } ?>>Business Website</a>


        </p>
        <p style="margin-top: 25px;margin-bottom: 0px;">Share now:</p>
        {!! \Share::currentPage("Share")
              ->facebook()
              ->twitter()
              ->linkedin()
        !!}
      </div>
    </div>

    <div class="featured-photos col-md-4 col-xs-12 no-pad-right no-pad-small text-center">
      @if(count($business->featured_photos()) == 1)
        <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/storage/{$business->featured_photos()[0]}") }});"></div>
      @elseif(count($business->featured_photos()) == 2)
        <div class="col-xs-6 no-pad-left">
          <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/storage/{$business->featured_photos()[0]}") }});"></div>
        </div>
        <div class="col-xs-6 no-pad-right">
          <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/storage/{$business->featured_photos()[1]}") }});"></div>
        </div>
        <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/images/placeholder.png") }})"></div>
      @elseif(count($business->featured_photos()) == 3)
        <div class="col-xs-6 no-pad-left">
          <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/storage/{$business->featured_photos()[0]}") }});"></div>
        </div>
        <div class="col-xs-6 no-pad-right">
          <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/storage/{$business->featured_photos()[1]}") }});"></div>
        </div>
        <div class="col-xs-12 thumbnail feature-photo" style="background-image: url({{ asset("assets/storage/{$business->featured_photos()[2]}") }})"></div>
      @else
        <h4>No Photos Yet</h4>
      @endif
    </div>
  </div>

  <hr/>

  <!-- Events, Reviews, Hours -->
  <div class="row no-margin">
    <div class="col-md-8 col-xs-12 no-pad-left no-pad-small">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="section-header">
            <i class="icon-list"></i> Description
          </h2>
          <p class="description">{{ $business->description }}</p>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-12">
          <h2 class="section-header" style="margin-bottom:5px;">
            <i class="icon-calendar"></i> Events and Specials
            @if(Auth::user())
              @if(Auth::user()->has_business)
                @if(Auth::user()->business->id === $business->id)
                  <small class="pull-right">
                    <a href="{{route('Events and Specials')}}">Edit</a>
                  </small>
                @endif
              @endif
            @endif
          </h2>
          @forelse($business->eventsAndSpecials as $event)
            <div class="events-specials-item clearfix">
              <div class="icon"><i class={{$event->type == 'event' ? 'icon-calendar' : 'icon-fire'}}></i></div>
              <div class="info-box">
                <h4>{{$event->name}} <small>({{$event->type}})</small></h4>
                <p class="times"><strong>Starts:</strong> {{$event->formattedStart()}} - <strong>Ends:</strong> {{$event->formattedEnd()}}</p>
                <p>{{$event->description}}</p>
              </div>
              <div class="pull-right">
                <a href="{{ route('Download Event', ['id' => $event->id]) }}" download>Save Event</a>
              </div>
            </div>
          @empty
            <p>No Events Upcoming</p>
          @endforelse
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-12">
          <h2 class="section-header" style="margin-bottom:5px;">
            <i class="icon-speech"></i> Recent Reviews
          </h2>
          @forelse($business->reviews->sortByDesc('updated_at') as $review)
            <div class="review-container col-xs-12 no-pad">
              <div class="pull-left img">
                <a href="{{ route('User Profile', ['id' => $review->user->id]) }}">
                  <img class="img-responsive" src="{{ $review->user->picture ? asset('assets/storage/'.$review->user->picture): asset('assets/images/placeholder.png') }}"/>
                </a>
              </div>
              <div class="pull-left info-container">
                <h4><a href="{{ route('User Profile', ['id' => $review->user->id]) }}">{{ $review->user->display_name }}</a></h4>
                <ul class="rating-icons sm">
                  @for($i = 0; $i < 5; $i++)
                    <li>
                      <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon {{ $review->rating >= $i + 1 ? 'active' : 'inactive' }}" rating-level="{{$i + 1}}"></i>
                    </li>
                    @if($i == 4)
                    <li>
                      <small>
                        &nbsp;| {{ $review->created_at->toFormattedDateString() }}
                      </small>
                    </li>
                    @endif
                  @endfor
                </ul>
              </div>
              <div class="pull-right hidden-xs">
                @if(!$review->created_at->eq($review->updated_at))
                  *Updated {{$review->updated_at->diffForHumans()}}
                @else
                  {{$review->created_at->diffForHumans()}}
                @endif
                @if(\Auth::check())
                  @if(\Auth::user()->id == $review->user_id)
                    &nbsp;| <a href="{{ route('Edit Review', ['business_id' => $business->id]) }}">Edit</a>
                  @endif
                @endif
              </div>
              <div class="pull-left review-body" style="clear:both;">
                <p>{!! nl2br(e($review->body)) !!}</p>
              </div>
              @if(\Auth::check())
                @if(\Auth::user()->has_business)
                  @if(\Auth::user()->business->id === $business->id)
                  <!-- React Component: ReviewReply -->
                    <div class="col-xs-12 no-pad clearfix review-reply" reviewId="{{$review->id}}" businessName="{{$business->name}}"
                    @if($review->response)
                      responseBody="{{$review->response->body}}"
                      updatedAt="{{$review->response->updated_at->toAtomString()}}"
                      createdAt="{{$review->response->created_at->toAtomString()}}"
                    @endif
                    >
                    </div>
                  <!-- End Component -->
                  @else <!-- All these checks are stupid, need to look at how to better check -->
                    @if($review->response)
                      <div class="col-xs-12 no-pad clearfix">
                        <p class="review-response">
                          <strong>{{$business->name}}'s response:</strong>
                          <br/>
                          {{$review->response->body}}
                          <br/>
                          <br/>
                          <small>
                            @if(!$review->response->created_at->eq($review->updated_at))
                              Updated: {{$review->response->updated_at->diffForHumans()}}
                            @else
                              Posted: {{$review->response->created_at->diffForHumans()}}
                            @endif
                          </small>
                        </p>
                      </div>
                    @endif
                  @endif
                @else
                  @if($review->response)
                    <div class="col-xs-12 no-pad clearfix">
                      <p class="review-response">
                        <strong>{{$business->name}}'s response:</strong>
                        <br/>
                        {{$review->response->body}}
                        <br/>
                        <br/>
                        <small>
                          @if(!$review->response->created_at->eq($review->updated_at))
                            Updated: {{$review->response->updated_at->diffForHumans()}}
                          @else
                            Posted: {{$review->response->created_at->diffForHumans()}}
                          @endif
                        </small>
                      </p>
                    </div>
                  @endif
                @endif
              @else
                @if($review->response)
                  <div class="col-xs-12 no-pad clearfix">
                    <p class="review-response">
                      <strong>{{$business->name}}'s response:</strong>
                      <br/>
                      {{$review->response->body}}
                      <br/>
                      <br/>
                      <small>
                        @if(!$review->response->created_at->eq($review->updated_at))
                          Updated: {{$review->response->updated_at->diffForHumans()}}
                        @else
                          Posted: {{$review->response->created_at->diffForHumans()}}
                        @endif
                      </small>
                    </p>
                  </div>
                @endif
              @endif
            </div>
          @empty
            <p>
              No Reviews Yet.&nbsp;
              @if(\Auth::user())
                @if(\Auth::user()->has_business)
                  @if(\Auth::user()->business->id !== $business->id)
                    <a href="{{route('Create Review', ['id' => $business->id])}}">Write one!</a>
                  @endif
                @else
                  <a href="{{route('Create Review', ['id' => $business->id])}}">Write one!</a>
                @endif
              @else
                <a href="{{route('Create Review', ['id' => $business->id])}}">Write one!</a>
              @endif
            </p>
          @endforelse
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xs-12 no-pad-right no-pad-small sidebar">
      <div class="row no-margin" style="display: {{!count($hours) ? 'none': 'block'}}">
        <h2 class="section-header">
          <i class="icon-clock"></i> Hours
        </h2>

        <div class="hours col-xs-12 no-pad" id="monday">
          <span class="pull-left">Monday</span>
          @if($hours['Monday'])
            <span class="pull-right">{{ $hours['Monday']['opens_formatted'] }} - {{ $hours['Monday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>

        <div class="hours col-xs-12 no-pad" id="tuesday">
          <span class="pull-left">Tuesday</span>
          @if($hours['Tuesday'])
            <span class="pull-right">{{ $hours['Tuesday']['opens_formatted'] }} - {{ $hours['Tuesday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>

        <div class="hours col-xs-12 no-pad" id="wednesday">
          <span class="pull-left">Wednesday</span>
          @if($hours['Wednesday'])
            <span class="pull-right">{{ $hours['Wednesday']['opens_formatted'] }} - {{ $hours['Wednesday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>

        <div class="hours col-xs-12 no-pad" id="thursday">
          <span class="pull-left">Thursday</span>
          @if($hours['Thursday'])
            <span class="pull-right">{{ $hours['Thursday']['opens_formatted'] }} - {{ $hours['Thursday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>

        <div class="hours col-xs-12 no-pad" id="friday">
          <span class="pull-left">Friday</span>
          @if($hours['Friday'])
            <span class="pull-right">{{ $hours['Friday']['opens_formatted'] }} - {{ $hours['Friday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>

        <div class="hours col-xs-12 no-pad" id="saturday">
          <span class="pull-left">Saturday</span>
          @if($hours['Saturday'])
            <span class="pull-right">{{ $hours['Saturday']['opens_formatted'] }} - {{ $hours['Saturday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>

        <div class="hours col-xs-12 no-pad" id="sunday">
          <span class="pull-left">Sunday</span>
          @if($hours['Sunday'])
            <span class="pull-right">{{ $hours['Sunday']['opens_formatted'] }} - {{ $hours['Sunday']['closes_formatted'] }}</span>
          @else
            <span class="pull-right">Closed</span>
          @endif
        </div>
      </div>
      <hr style="display: {{count($hours) ? 'none': 'block'}}">

      <?php $ads = \SpotzCity\Http\Controllers\ComponentController::getSidebarAds(); ?>
      @include('components/sidebar-ad', ['ad' => $ads[0]])

      <hr>

      @include('components/spotz-new')

      <hr>

      @include('components/sidebar-ad', ['ad' => $ads[1]])
    </div>
  </div>
</div>

<!-- Scorecard Modal -->
<div id="scorecard-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $business->name }} Scorecard</h4>
      </div>
      <div class="modal-body text-center">
        <div>
          <h2>{{ $business->rating }} <small>Overall Rating | </small> {{ $business->reviews->count() }} <small>Total Review(s)</small></h2>
        </div>
        <div id="scorecard-chart"></div>
        {!! \Lava::render('BarChart', 'Scorecard'.$business->id, 'scorecard-chart') !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
