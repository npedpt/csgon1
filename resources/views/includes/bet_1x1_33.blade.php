@if(empty($items_3))
@else
@foreach(json_decode($items_3->items) as $i)
<li class="fast-game-trade-item" style="transform: translate3d(0px, 0px, 0px); background-image: url(https://steamcommunity-a.akamaihd.net/economy/image/class/730/{{ $i->classid }}/23fx23f);">
<div class="item_info darkBlueBg">
					<div class="item_info_img_wrap">
						<div class="item_info_img">
							<img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/{{ $i->classid }}/110fx100f" alt="{{ $i->name }}">
						</div>
					</div>
					<div class="item_info_description">
						<div class="item_info_name">{{ $i->name }}</div>
						<div class="item_info_price">{{ $i->price }} руб.</div>
					</div>
					<div class="item_owner">
						<div class="item_owner_img">
							<img src="{{$items_3->avatar}}">
						</div>
					</div>
				</div></li>
@endforeach
@endif