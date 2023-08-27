<div class="col-lg-4 col-sm-6">
    <div class="product-style-1 mt-30">
        <div class="product-image">
            <span class="icon-text text-style-1">NEW</span>
            <div class="product-active">
                <div class="product-item active">
                    <img src="assets/images/product-1/product-1.jpg" alt="product">
                </div>
                <div class="product-item">
                    <img src="assets/images/product-1/product-2.jpg" alt="product">
                </div>
            </div>

            @php
               $wish = App\Models\Favoraite::where('favoritable_id',$product->id)->where('customer_id',$customer_id)->first();
               $is_favoraite = isset($wish) ? 1 : 0;
            @endphp

            @if ($is_favoraite==1)
                <a href="{{ route('favoraite', ['ID' => $product->id, 'customerId' => $customer_id]) }}" class="add-wishlist" >
                    <i></i>
                    <i class="mdi mdi-heart" id="heart" style="color: red"></i>
                </a>
            @else
                <a href="{{ route('favoraite', ['ID' => $product->id, 'customerId' => $customer_id]) }}" class="add-wishlist" >
                    <i></i>
                    <i class="mdi mdi-heart-outline" id="heart"></i>
                </a>
            @endif

        </div>
        <div class="product-content text-center">
            {{-- <h4 class="title"><a href="{{route('product-details',$product->id)}}">{{ $product->name }}</a></h4> --}}
            <h4 class="title"><a href="">{{ $product->product_name }}</a></h4>

            {{-- <p>Reference 1102</p> --}}
            <a href="javascript:void(0)" class="main-btn secondary-1-btn">
                <img src="assets/images/icon-svg/cart-7.svg" alt="">
                $ {{ $product->price }}
            </a>
        </div>
    </div>
</div>
