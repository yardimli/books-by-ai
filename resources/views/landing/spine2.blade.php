<style>
    .spine {
        width: 480px;
        height: 24px;
        background-color: #0c0c0c;
        position: relative;
        overflow: hidden;
    }

    .spine-text {
        position: relative;
        display: flex;
        align-items: center;
        height: 100%;
        padding: 0 20px;
    }

    .spine-author-name {
        font-size: 10px;
        color: #FFFFDD;
        margin-right: 20px;
        white-space: nowrap;
        overflow: hidden;
		    line-height: 24px;
    }

    .spine-title {
        font-size: 14px;
        color: #DDEE99;
        white-space: nowrap;
        overflow: hidden;
		    line-height: 24px;
    }

    .uppercase-spine-title {
        font-size: 16px;
        color: #DDEE99;
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
    }

    .uppercase-spine-title-first-letter {
        font-size: 18px;
    }

    .spine-logo {
        position: absolute;
        right: 2px;
        top: 0px;
        height: 20px;
    }

    .spin-logo-img {
        height: auto;
        width: 20px;
        transform: rotate(90deg);
    }
</style>

<div class="spine">
	<div class="spine-text">
		<span class="spine-author-name book-spine-author-name roboto-mono-regular"></span>
		<span class="spine-title book-spine-title bungee-tint-regular"></span>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
