@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register_shop.css') }}">
@endsection

@section('content')
<div class="shop-register__content w100">
    <div class="shop-register__header">
        <div class="register-header__user">
            ログイン中：{{ $user['name'] }} さん
        </div>
    </div>
    <div class="done__message">
        @if(session('error'))
        <h3>
            {{ session('error')}}
        </h3>
        @endif
    </div>
    <div class="shop-register__wrapper">
        @if(isset($shop))
        <form action="/owner/edit-shop/{{ $shop['id'] }}" method="post" class="shop-register__form" enctype="multipart/form-data">
            @method('PATCH')
            @else
            <form action="/owner/register-shop/" method="post" class="shop-register__form" enctype="multipart/form-data">
                @endif
                @csrf
                <div class="register-form__heading">
                    <h3>店舗登録</h3>
                </div>
                <div class="register-form__group">
                    <div class="register-form__error">
                        <div class="register-form__input-label"></div>
                        <div class="error__message">
                            @error('shop_name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="register-form__input">
                        <div class="register-form__input-label">Shop Name</div>
                        <div class="register-form__input-items">
                            @if(isset($shop['shop_name']))
                            <input type="text" name="shop_name" value="{{ $shop['shop_name'] }}">
                            @else
                            <input type="text" name="shop_name" value="{{ old('shop_name') }}">
                            @endif
                        </div>
                    </div>
                    <div class="register-form__error">
                        <div class="register-form__input-label"></div>
                        <div class="error__message">
                            @error('area_id')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="register-form__input">
                        <div class="register-form__input-label">Area</div>
                        <div class="register-form__input-items">
                            <select name="area_id" id="">
                                <option value="">選択してください</option>
                                @foreach($shop_areas as $area)
                                @if(isset($shop['area']))
                                <option value="{{ $area['id'] }}" {{ $shop['area']['id']==$area['id'] ? 'selected' : ''}}>{{ $area['area_name'] }}</option>
                                @else
                                <option value="{{ $area['id'] }}" {{ old('area_id')==$area['id'] ? 'selected' : '' }}>{{ $area['area_name'] }}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="polygon"></div>
                        </div>
                    </div>
                    <div class="register-form__error">
                        <div class="register-form__input-label"></div>
                        <div class="error__message">
                            @error('category_id')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="register-form__input">
                        <div class="register-form__input-label">Category</div>
                        <div class="register-form__input-items">
                            <select name="category_id" id="">
                                <option value="">選択してください</option>
                                @foreach($shop_categories as $category)
                                @if(isset($shop['category']))
                                <option value="{{ $category['id'] }}" {{ $shop['category']['id']==$category['id'] ? 'selected' : ''}}>{{ $category['category_name'] }}</option>
                                @else
                                <option value="{{ $category['id'] }}" {{ old('category_id')==$category['id'] ? 'selected' : ''}}>{{ $category['category_name'] }}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="polygon"></div>
                        </div>
                    </div>
                    <div class="register-form__error">
                        <div class="register-form__input-label"></div>
                        <div class="error__message">
                            @error('description')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="register-form__input">
                        <div class="register-form__input-label">Description</div>
                        <div class="register-form__input-items">
                            <textarea name="description">{{ isset($shop['description']) ? $shop['description'] : old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="register-form__error">
                        <div class="register-form__input-label"></div>
                        <div class="error__message">
                            @error('image_url')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="register-form__input">
                        <div class="register-form__input-label">Image</div>
                        <div class="register-form__input-items--button">
                            <input type="file" name="image_url" value="{{ isset($shop['image_url']) ? $shop['image_url'] : '' }}">
                        </div>
                    </div>
                </div>
                <div class="register-form__button">
                    <button type="submit" class="register-form__button-submit">
                        @if(!empty($shop))
                         更新 
                        @else
                         登録
                        @endif
                    </button>
                </div>
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            </form>
    </div>

</div>
@endsection