<style>
    .spine {
        width: 480px;
        height: 24px;
        background-color: #f7d3b0;
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
        color: #333333;
        margin-right: 20px;
        white-space: nowrap;
        overflow: hidden;
        line-height: 24px;
    }

    .spine-title {
        font-size: 10px;
        color: #333333;
        white-space: nowrap;
        overflow: hidden;
        line-height: 24px;
    }

    .uppercase-spine-title {
        font-size: 1.1rem;
        color: #333333;
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
    }

    .uppercase-spine-title-first-letter {
        font-size: 1.3rem;
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
		<span class="spine-author-name book-spine-author-name oswald-regular"></span>
		<span class="spine-title book-spine-title lato-black"></span>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
